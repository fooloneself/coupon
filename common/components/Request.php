<?php
namespace common\components;
use yii\web\JsonParser;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/3 0003
 * Time: 下午 9:44
 */
class Request extends \yii\web\Request {


    const HEADER_IDENTITY_ID       ='identity-id';

    const HEADER_SESSION_TOKEN  ='session-token';

    const HEADER_SIGNATURE      ='signature';

    public $parsers=[
        'application/json'=>JsonParser::class
    ];

    /**
     * 获取openid
     * @return string
     */
    public function getIdentityId():string{
        return $this->getHeaders()->get(self::HEADER_IDENTITY_ID,'');
    }

    /**
     * 获取会话令牌
     * @return string
     */
    public function getToken():string{
        return $this->getHeaders()->get(self::HEADER_SESSION_TOKEN,'');
    }

    /**
     * 获取签名
     * @return string
     */
    public function getSign():string{
        return $this->getHeaders()->get(self::HEADER_SIGNATURE,'');
    }

}