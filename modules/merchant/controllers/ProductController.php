<?php
namespace app\modules\merchant\controllers;
use app\models\MerchantProduct;
use yii\base\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 10:28
 */
class ProductController extends Controller{

    /**
     * 商户产品列表
     * @return \common\components\Response
     */
    public function actionList(){
        $mchId=\Yii::$app->user->getIdentity()->getMerchantId();
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        $mchId=intval($mchId);
        if($mchId<=0){
            return \Yii::$app->response->error(ERROR_PARAM_WRONG);
        }else{
            return \Yii::$app->response->success(MerchantProduct::getProductListOfMch($mchId,$page,$pageSize));
        }
    }


}