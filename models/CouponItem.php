<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coupon_item".
 *
 * @property string $code 券码
 * @property int $status 状态：1未使用 2已核销
 * @property int $coupon_id 券id
 * @property int $own_user_id 拥有用户id
 * @property int $own_time 抢占时间
 * @property int $write_off_user_id 核销人用户id
 * @property int $write_off_time 核销时间
 */
class CouponItem extends \yii\db\ActiveRecord
{
    const STATUS_NOT_USE    =1;
    const STATUS_HAS_USE    =2;
    const STATUS_EXPIRE     =3;

    const ORDER_BY_OWN_TIME_DESC    =1;
    const ORDER_BY_OWN_TIME_ASC     =2;
    const ORDER_BY_END_DATE_ASC     =3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coupon_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['status', 'coupon_id', 'own_user_id', 'own_time', 'write_off_user_id', 'write_off_time'], 'integer'],
            [['discount_amount'], 'number'],
            [['code'], 'string', 'max' => 100],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'status' => 'Status',
            'discount_amount' => 'Discount Amount',
            'coupon_id' => 'Coupon ID',
            'own_user_id' => 'Own User ID',
            'own_time' => 'Own Time',
            'write_off_user_id' => 'Write Off User ID',
            'write_off_time' => 'Write Off Time',
        ];
    }

    /**
     * 获取个人券列表
     * @param int $userId
     * @param int $status
     * @param int $orderBy
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getList(int $userId,int $status,int $orderBy,int $page,int $pageSize):array{
        $query=self::find()->alias('ci')
            ->select('c.mch_id,m.name as mch_name,c.type as coupon_type,c.discount,c.shop_price,c.end_date,c.title,c.sub_title,ci.code')
            ->leftJoin(['c'=>Coupon::tableName()],'ci.coupon_id=c.id')
            ->leftJoin(['m'=>Merchant::tableName()],'c.mch_id=m.id')
            ->where([
                'ci.own_user_id'=>$userId,
            ]);
        if($status==self::STATUS_EXPIRE){
            $query->andWhere([
                 'c.end_date'=>['<',date('Y-m-d')]
            ]);
        }else{
            $query->andWhere([
                'ci.status'=>$status
            ]);
        }
        switch ($orderBy){
            case self::ORDER_BY_END_DATE_ASC:
                $query->orderBy('c.end_date asc');
                break;
            case self::ORDER_BY_OWN_TIME_ASC:
                $query->orderBy('ci.own_time desc');
                break;
            default:
                $query->orderBy('ci.own_time asc');
        }
        return $query ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->asArray()->all();
    }

    /**
     * 获取用户可用券的数量
     * @param int $userId
     * @return int
     */
    public static function getUsableCouponCountOfUser(int $userId):int{
        $count=self::find()->alias('ci')
            ->leftJoin(['c'=>Coupon::tableName()],'c.id=ci.coupon_id')
            ->where([
                'ci.own_user_id'=>$userId,
                'ci.status'=>self::STATUS_NOT_USE,
                'c.end_date'=>['>=',date('Y-m-d')]
            ])->count();
        return intval($count);
    }

    /**
     * 获取用户已使用券的数量
     * @param int $userId
     * @return int
     */
    public static function getUsedCouponCountOfUser(int $userId):int{
        $count=self::find()
            ->where([
                'own_user_id'=>$userId,
                'status'=>self::STATUS_HAS_USE,
            ])->count();
        return intval($count);
    }

    /**
     * 获取用户获取优惠券的总数量
     * @param int $userId
     * @return int
     */
    public static function getTotalCountThatOwnWithUser(int $userId):int{
        $count=self::find()
            ->where([
                'own_user_id'=>$userId,
            ])->count();
        return intval($count);
    }

    /**
     * 优惠总金额
     * @param int $userId
     * @return float
     */
    public static function getDiscountAmountOfUser(int $userId):float {
        $count=self::find()
            ->where([
                'own_user_id'=>$userId,
                'status'=>self::STATUS_HAS_USE
            ])->count('discount_amount');
        return floatval($count);
    }
}
