<?php
namespace app\modules\merchant\controllers;
use app\models\Merchant;
use yii\base\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 10:17
 */
class InfoController extends Controller{


    /**
     * 编辑商户资料
     * @return \common\components\Response
     */
    public function actionEdit(){
        $merchant=Merchant::findOne(['id'=>\Yii::$app->user->getIdentity()->getMerchantId()]);
        $merchant->name=\Yii::$app->request->post('name');
        $merchant->contact_info=\Yii::$app->request->post('contact');
        $merchant->contact_person=\Yii::$app->request->post('contactPerson');
        $merchant->introduce=\Yii::$app->request->post('introduce');
        if($merchant->save()){
            return \Yii::$app->response->success($merchant->getAttributes());
        }else{
            return \Yii::$app->response->error(ERROR_DATABASE_SAVE_FAIL);
        }
    }
}