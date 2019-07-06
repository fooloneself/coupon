<?php
namespace app\controllers;

use app\models\Coupon;
use app\models\Merchant;
use app\models\MerchantProduct;
use yii\base\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 3:31
 */
class MerchantController extends Controller {

    /**
     * 获取商家的基础信息
     * @return \common\components\Response
     */
    public function actionBaseInfo(){
        $mchId=\Yii::$app->request->post('mchId',0);
        $mchId=intval($mchId);
        if($mchId<=0){
            return \Yii::$app->response->error(ERROR_PARAM_WRONG);
        }
        $mch=Merchant::getBaseInfo($mchId);
        if(empty($mch)){
            return \Yii::$app->response->error(ERROR_PARAM_WRONG);
        }else{
            return \Yii::$app->response->success($mch);
        }
    }

    /**
     * 获取商家的优惠券列表
     * @return \common\components\Response
     */
    public function actionCouponList(){
        $mchId=\Yii::$app->request->post('mchId',0);
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        $mchId=intval($mchId);
        if($mchId<=0){
            return \Yii::$app->response->error(ERROR_PARAM_WRONG);
        }else{
            return \Yii::$app->response->success(Coupon::getReceivableCouponOfMch($mchId,$page,$pageSize));
        }
    }

    /**
     * 商家产品列表
     * @return \common\components\Response
     */
    public function actionProductList(){
        $mchId=\Yii::$app->request->post('mchId',0);
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