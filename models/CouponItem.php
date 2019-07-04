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
            'coupon_id' => 'Coupon ID',
            'own_user_id' => 'Own User ID',
            'own_time' => 'Own Time',
            'write_off_user_id' => 'Write Off User ID',
            'write_off_time' => 'Write Off Time',
        ];
    }
}
