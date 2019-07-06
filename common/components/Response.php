<?php
namespace common\components;
use common\lib\Error;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/3 0003
 * Time: 下午 9:38
 */
class Response extends \yii\web\Response {

    /**
     * 定义返回的数据格式
     * @var string
     */
    public $format=self::FORMAT_JSON;

    /**
     * 返回错误
     * @param int $code
     * @param string $errMsg
     * @return Response
     */
    public function error(int $code,string $errMsg=''):Response{
        $this->setData($code,$errMsg);
        return $this;
    }

    /**
     * 返回错误
     * @param Error $error
     * @return Response
     */
    public function errorObj(Error $error):Response{
        return $this->error($error->getCode(),$error->getErrMsg());
    }

    /**
     * 返回成功
     * @param $data
     * @return Response
     */
    public function success($data=[]):Response{
        $this->setData(0,'',$data);
        return $this;
    }

    /**
     * 设置返回的数据
     * @param int $code
     * @param string $errMsg
     * @param null $data
     */
    private function setData(int $code,string $errMsg,$data=null){
        $this->format=self::FORMAT_JSON;
        $this->data=[
            'code'=>$code,
            'errMsg'=>$errMsg,
            'data'=>$data
        ];
    }
}