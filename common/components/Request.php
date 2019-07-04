<?php
namespace common\components;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/3 0003
 * Time: 下午 9:44
 */
class Request extends \yii\web\Request {


    const HEADER_OPEN_ID        ='open_id';

    const HEADER_SESSION_TOKEN  ='session_token';

    const HEADER_SIGNATURE      ='signature';

    /**
     * 获取openid
     * @return string
     */
    public function getOpenId():string{
        return $this->getHeaders()->get(self::HEADER_OPEN_ID,'');
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