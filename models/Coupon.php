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
 * @property int $uper_limit_per_person 每人可领取的数量上限
 * @property int $type 优惠券类型：1代金券 2折扣券 3兑换券 4团购券 5特价券
 * @property int $status 状态:1待审核 2拒绝 3待投放 4已投放 5已下架
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
            [['mch_id', 'user_id', 'total_num', 'race_num', 'uper_limit_per_person', 'type', 'status'], 'integer'],
            [['end_date'], 'safe'],
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
            'uper_limit_per_person' => 'Uper Limit Per Person',
            'type' => 'Type',
            'status' => 'Status',
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
}
