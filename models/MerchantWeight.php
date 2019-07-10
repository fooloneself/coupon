<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant_weight".
 *
 * @property int $mch_id 商户ID
 * @property int $weight 权重
 * @property int $coupon_id 券ID
 * @property int $can_receive_num 可领取的数量
 * @property int $has_received_num 已领取的数量
 */
class MerchantWeight extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant_weight';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mch_id'], 'required'],
            [['mch_id', 'weight', 'coupon_id', 'can_receive_num', 'has_received_num'], 'integer'],
            [['mch_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mch_id' => 'Mch ID',
            'weight' => 'Weight',
            'coupon_id' => 'Coupon ID',
            'can_receive_num' => 'Can Receive Num',
            'has_received_num' => 'Has Received Num',
        ];
    }

    /**
     * 获取推荐列表
     * @param $page
     * @param $pageSize
     * @return array
     */
    public static function getRecommendList($page,$pageSize):array{
        self::find()->alias('mw')
            ->select([
                'mch_id'=>'m.id',
                'mch_name'=>'m.name',
                'mch_longitude'=>'m.longitude',
                'mch_latitude'=>'m.latitude',
                'mch_address'=>'m.address',
                'coupon_id'=>'c.id',
                'coupon_title'=>'c.title',
                'coupon_sub_title'=>'c.sub_title',
                'coupon_shop_price'=>'c.shop_price',
                'coupon_start_date'=>'c.start_date',
                'coupon_end_date'=>'c.end_date',
                'coupon_type'=>'c.type',
                'coupon_discount'=>'c.discount',
                'coupon_minimum_consumption'=>'c.minimum_consumption',
                'has_receive_num'=>'mw.has_received_num',
                'can_receive_num'=>'c.can_receive_num',
                'products'=>"group_concat(concat(mp.id,',',mp.name,',',mp.price,',',mp.cover_img) separator ';')",
            ])
            ->leftJoin([Merchant::tableName(),'m'],'m.id=mw.mch_id')
            ->leftJoin([MerchantProduct::tableName(),'mp'],'mw.mch_id=mp.mch_id')
            ->leftJoin([Coupon::tableName(),'c'],'c.id=mw.coupon_id')
            ->groupBy('mw.mch_id')
            ->orderBy('mw.weight desc')
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->asArray()->all();
    }
}
