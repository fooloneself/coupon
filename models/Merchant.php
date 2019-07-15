<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant".
 *
 * @property int $id 商户id
 * @property int $user_id 创建人用户ID
 * @property string $serial_number 商户编号
 * @property string $logo 商户logo
 * @property string $name 商户名称
 * @property string $contact_info 联系方式
 * @property string $contact_person 联系人
 * @property string $longitude 经度
 * @property string $latitude 纬度
 * @property string $register_date 注册日期
 * @property string $not_limit_end_date 不限次截止日期
 * @property int $register_time 注册时间
 * @property int $coupon_currency 券币
 * @property int $is_recommend 是否推荐：0否 1是
 * @property int $type 商户类型
 * @property string $address 商户地址
 * @property string $introduce 商户介绍
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'register_time', 'coupon_currency', 'is_recommend', 'type'], 'integer'],
            [['serial_number'], 'required'],
            [['longitude', 'latitude'], 'number'],
            [['register_date', 'not_limit_end_date'], 'safe'],
            [['address', 'introduce'], 'string'],
            [['serial_number', 'logo', 'name', 'contact_person'], 'string', 'max' => 100],
            [['contact_info'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'serial_number' => 'Serial Number',
            'logo' => 'Logo',
            'name' => 'Name',
            'contact_info' => 'Contact Info',
            'contact_person' => 'Contact Person',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'register_date' => 'Register Date',
            'not_limit_end_date' => 'Not Limit End Date',
            'register_time' => 'Register Time',
            'coupon_currency' => 'Coupon Currency',
            'is_recommend' => 'Is Recommend',
            'type' => 'Type',
            'address' => 'Address',
            'introduce' => 'Introduce',
        ];
    }

    /**
     * 获取商家的基本信息
     * @param int $mchId
     * @return array
     */
    public static function getBaseInfo(int $mchId):array{
        return self::find()
            ->where(['id'=>$mchId])
            ->asArray()->one();
    }

    /**
     * 生成商户编号
     * @param int $time
     * @return string
     */
    public static function generateSerialNo(int $time):string{
        return str_pad(dechex($time*100+rand(10,99)),10,'0',STR_PAD_LEFT);
    }

    /**
     * 获取券
     * @param int $couponId
     * @return Coupon|null
     */
    public function getCouponById(int $couponId):?Coupon{
        return Coupon::findOne(['mch_id'=>$this->id,'id'=>$couponId]);
    }

    public function deductCurrency(int $currency):bool {
        $this->coupon_currency=$this->coupon_currency-$currency;
        return $this->update();
    }
}
