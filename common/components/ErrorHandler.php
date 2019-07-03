<?php
namespace common\components;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/3 0003
 * Time: 下午 9:28
 */
class ErrorHandler extends \yii\base\ErrorHandler {

    protected function renderException($exception)
    {
        \Yii::$app->response->error(1,$exception->getMessage())->send();
    }

}