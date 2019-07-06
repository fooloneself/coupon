<?php
namespace app\modules\user\controllers;
use app\models\Merchant;
use yii\base\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 10:18
 */
class MerchantController extends Controller{

    /**
     * 注册商户
     * @return \common\components\Response
     */
    public function actionRegister(){
        $merchant=new Merchant();
        $merchant->user_id=\Yii::$app->user->getId();
        $merchant->name=\Yii::$app->request->post('name');
        $merchant->type=\Yii::$app->request->post('type');
        $merchant->address=\Yii::$app->request->post('address');
        $merchant->contact_info=\Yii::$app->request->post('contact');
        $merchant->contact_person=\Yii::$app->request->post('contactPerson');
        $merchant->register_date=date('Y-m-d');
        $merchant->register_time=time();
        $merchant->serial_number=Merchant::generateSerialNo(time());

        if($merchant->insert()){
            return \Yii::$app->response->success($merchant->getAttributes());
        }else{
            return \Yii::$app->response->success($merchant->getAttributes());
        }
    }
}