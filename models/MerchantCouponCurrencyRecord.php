<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant_coupon_currency_record".
 *
 * @property int $id 记录ID
 * @property string $serial_number 流水号
 * @property int $mch_id 商户id
 * @property int $type 1进账 2出账
 * @property int $amount 金额：<0 出账 >0进账
 * @property int $happen_time 发生时间
 * @property string $mark 资金流向备注
 */
class MerchantCouponCurrencyRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant_coupon_currency_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mch_id', 'type'], 'required'],
            [['mch_id', 'type', 'amount', 'happen_time'], 'integer'],
            [['mark'], 'string'],
            [['serial_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_number' => 'Serial Number',
            'mch_id' => 'Mch ID',
            'type' => 'Type',
            'amount' => 'Amount',
            'happen_time' => 'Happen Time',
            'mark' => 'Mark',
        ];
    }
}
