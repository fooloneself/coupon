<?php

namespace app\modules\user\controllers;

use app\models\Coupon;
use app\models\CouponItem;
use service\coupon\RealGenerator;
use yii\base\Controller;

/**
 * Default controller for the `user` module
 */
class CouponController extends Controller
{

    /**
     * 获取个人券列表
     * @return \common\components\Response
     */
    public function actionList()
    {
        $status=\Yii::$app->request->post('status',1);
        $orderBy=\Yii::$app->request->post('order',CouponItem::ORDER_BY_OWN_TIME_DESC);
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        $userId=\Yii::$app->user->getId();
        $couponList=CouponItem::getList(intval($userId),intval($status),intval($orderBy),intval($page),intval($pageSize));
        return \Yii::$app->response->success($couponList);
    }

    /**
     * 领取券
     * @return \common\components\Response
     */
    public function actionReceive(){
        $couponId=\Yii::$app->request->post('couponId');
        $userId=\Yii::$app->user->getId();
        $coupon=Coupon::findOne(['id'=>$couponId]);
        if(empty($coupon)){
            return \Yii::$app->response->error(ERROR_COUPON_NOT_FOUND);
        }
        $realGenerator=new RealGenerator($coupon);
        if($realGenerator->generate($userId)){
            return \Yii::$app->response->success();
        }else{
            return \Yii::$app->response->error($realGenerator::getError());
        }
    }
}
