<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property int $id 优惠券id
 * @property int $mch_id 商户id
 * @property int $user_id 发布券的账户id
 * @property int $total_num 发放总量
 * @property int $race_num 已抢占数量
 * @property int $upper_limit_per_person 每人可领取的数量上限
 * @property int $create_time 创建时间
 * @property int $type 优惠券类型：1代金券 2折扣券 3兑换券 4团购券 5特价券
 * @property int $status 状态:1待审核 2拒绝 3待投放 4已投放 5已下架
 * @property string $start_date 券可用起始日期
 * @property string $end_date 券可用截止日期
 * @property string $title 卡券名称
 * @property string $sub_title 卡券副标题
 * @property string $shop_price 店面价格
 * @property string $discount 优惠
 * @property string $minimum_consumption 最低消费
 * @property string $usable_slot 可用时段
 * @property string $notice 使用须知
 * @property string $suitable_product 适合产品
 * @property string $unsuitable_product 不适合产品
 */
class Coupon extends \yii\db\ActiveRecord
{
    //待审核
    const STATUS_EXAMINING      =1;
    //拒绝
    const STATUS_REFUSE         =2;
    //待投放
    const STATUS_THROWING       =3;
    //已投放
    const STATUS_THROWN         =4;
    //下架
    const STATUS_UNDERCARRIAGE  =4;

    //代金券
    const TYPE_CASH_COUPON              =1;
    //折扣券
    const TYPE_DISCOUNT_COUPON          =2;
    //兑换券
    const TYPE_EXCHANGE_COUPON          =3;
    //团购券
    const TYPE_GROUP_BUY_COUPON         =4;
    //特价券
    const TYPE_SPECIAL_PRICE_COUPON     =5;

    //有效
    const FILTER_STATUS_EFFECTIVE       =1;
    //失效
    const FILTER_STATUS_INVALID         =2;
    //待审核
    const FILTER_STATUS_EXAMINING       =3;

    public static $types=[
        self::TYPE_CASH_COUPON,
        self::TYPE_DISCOUNT_COUPON,
        self::TYPE_EXCHANGE_COUPON,
        self::TYPE_GROUP_BUY_COUPON,
        self::TYPE_SPECIAL_PRICE_COUPON
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mch_id', 'user_id', 'total_num', 'race_num', 'upper_limit_per_person', 'create_time', 'type', 'status'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['shop_price', 'minimum_consumption'], 'number'],
            [['usable_slot', 'notice', 'suitable_product', 'unsuitable_product'], 'string'],
            [['title', 'sub_title', 'discount'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mch_id' => 'Mch ID',
            'user_id' => 'User ID',
            'total_num' => 'Total Num',
            'race_num' => 'Race Num',
            'upper_limit_per_person' => 'Upper Limit Per Person',
            'create_time' => 'Create Time',
            'type' => 'Type',
            'status' => 'Status',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'title' => 'Title',
            'sub_title' => 'Sub Title',
            'shop_price' => 'Shop Price',
            'discount' => 'Discount',
            'minimum_consumption' => 'Minimum Consumption',
            'usable_slot' => 'Usable Slot',
            'notice' => 'Notice',
            'suitable_product' => 'Suitable Product',
            'unsuitable_product' => 'Unsuitable Product',
        ];
    }

    /**
     * 是否包含指定类型
     * @param int $type
     * @return bool
     */
    public static function hasType(int $type):bool {
        return in_array($type,self::$types);
    }

    /**
     * 获取商家可领取的优惠券
     * @param int $mchId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getReceivableCouponOfMch(int $mchId,int $page,int $pageSize):array{
        return self::find()
            ->where([
                'mch_id'=>$mchId,
                'status'=>self::STATUS_THROWN,
                'end_date'=>['>=',date('Y-m-d')]
            ])
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->asArray()->all();
    }

    /**
     * 获取商户券列表
     * @param int $mchId
     * @param int $status
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getCouponListOfMch(int $mchId,int $status,int $page,int $pageSize):array{
        $query= self::find()->where(['mch_id'=>$mchId]);
        switch ($status){
            case self::FILTER_STATUS_EXAMINING:
                $query->andWhere([
                    'status'=>self::STATUS_EXAMINING,
                    'end_date'=>['>=',date('Y-m-d')]
                ]);
                break;
            case self::FILTER_STATUS_EFFECTIVE:
                $query->andWhere([
                    'status'=>[self::STATUS_THROWING,self::STATUS_THROWN],
                    'end_date'=>['>=',date('Y-m-d')]
                ]);
                break;
            case self::FILTER_STATUS_INVALID:
                $query->andWhere([
                    'or',
                    ['status'=>self::STATUS_EXAMINING,'end_date'=>['<',date('Y-m-d')]],
                    ['status'=>self::STATUS_REFUSE],
                    ['status'=>[self::STATUS_THROWING,self::STATUS_THROWN],'end_date'=>['<',date('Y-m-d')]],
                    ['status'=>self::STATUS_UNDERCARRIAGE]
                ]);
                break;
            default:
                return [];
        }
        return $query->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->asArray()->all();
    }

    public function canGrant():bool {
        if($this->status==self::STATUS_THROWING){
            return true;
        }else{
            return false;
        }
    }

    public function isOverdue():bool {
        $endTime=strtotime($this->end_date)+86400;
        if(time()>=$endTime){
            return true;
        }else{
            return false;
        }
    }

    public function grant():bool {
        $this->status=self::STATUS_THROWN;
        return $this->save();
    }
}
