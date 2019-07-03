<?php
namespace common\components;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/3 0003
 * Time: 下午 9:38
 */
class Response extends \yii\web\Response {

    public $format=self::FORMAT_JSON;


    public function error(int $code,string $errMsg):Response{
        $this->setData($code,$errMsg);
        return $this;
    }


    public function success($data):Response{
        $this->setData(0,'',$data);
        return $this;
    }


    private function setData(int $code,string $errMsg,$data=null){
        $this->data=[
            'code'=>$code,
            'errMsg'=>$errMsg,
            'data'=>$data
        ];
    }
}