<?php

namespace app\models;

use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $openid 微信openid
 * @property string $session_key 会话令牌
 * @property string $session_token 会话令牌
 * @property string $mch_id 商户id
 * @property int $type 账号类型：1消费者账户 2商户账户
 * @property int $token_expire_time 会话令牌过期时间
 * @property int $create_time 创建时间
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['openid'], 'required'],
            [['type', 'coupon_currency', 'token_expire_time', 'create_time'], 'integer'],
            [['openid', 'session_key', 'session_token', 'mch_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'session_key' => 'Session Key',
            'session_token' => 'Session Token',
            'mch_id' => 'Mch ID',
            'type' => 'Type',
            'coupon_currency' => 'Coupon Currency',
            'token_expire_time' => 'Token Expire Time',
            'create_time' => 'Create Time',
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['session_token'=>$token])->one();
    }

    public static function findIdentity($id)
    {
        return self::find()->where(['id'=>$id])->one();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }

    public function hasRegisterMerchant()
    {
        $mchId=$this->mch_id;
        return $mchId>0;
    }

    public function getMerchantId()
    {
        return intval($this->mch_id);
    }
}
