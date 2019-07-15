<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $openid 微信openid
 * @property string $appid 应用id
 * @property string $unionid 用户在开放平台的唯一标识符
 * @property string $session_key 会话令牌
 * @property string $session_token 会话令牌
 * @property string $mch_id 商户id
 * @property string $nick_name 昵称
 * @property string $avatar 头像
 * @property int $type 账号类型：1消费者账户 2商户账户
 * @property int $token_expire_time 会话令牌过期时间
 * @property int $create_time 创建时间
 */
class User extends \yii\db\ActiveRecord
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
            [['type', 'token_expire_time', 'create_time'], 'integer'],
            [['openid', 'appid', 'unionid', 'session_key', 'session_token', 'mch_id', 'nick_name'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 200],
            [['openid'], 'unique'],
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
            'appid' => 'Appid',
            'unionid' => 'Unionid',
            'session_key' => 'Session Key',
            'session_token' => 'Session Token',
            'mch_id' => 'Mch ID',
            'nick_name' => 'Nick Name',
            'avatar' => 'Avatar',
            'type' => 'Type',
            'token_expire_time' => 'Token Expire Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * 通过id获取User
     * @param $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * 通过微信openid获取
     * @param $openId
     * @return null|static
     */
    public static function findIdentityByOpenId($openId){
        return self::findOne(['openid'=>$openId]);
    }

    /**
     * 生成会话令牌
     * @param string $unionId
     * @return string
     */
    public static function generateSessionToken(string $unionId){
        return md5(uniqid().$unionId);
    }

    /**
     * 获取用户id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 获取权限key
     * @return string
     */
    public function getAuthKey()
    {
        return $this->session_token;
    }

    /**
     * 是否注册商户
     * @return bool
     */
    public function hasRegisterMerchant()
    {
        $mchId=$this->mch_id;
        return $mchId>0;
    }

    /**
     * 获取商户id
     * @return int
     */
    public function getMerchantId()
    {
        return $this->mch_id;
    }

    /**
     * 获取商户
     * @return Merchant|null
     */
    public function getMerchant():?Merchant{
        return Merchant::findOne(['id'=>$this->getMerchantId()]);
    }

}
