<?php

namespace app\modules\merchant\controllers;

use app\models\Coupon;
use service\coupon\creator\Creator;
use service\coupon\Granter;
use yii\base\Controller;

/**
 * Default controller for the `merchant` module
 */
class CouponController extends Controller
{

    /**
     * 获取商户的券列表
     * @return \common\components\Response
     */
    public function actionList()
    {
        $mchId=\Yii::$app->user->getIdentity()->getMerchantId();
        $status=\Yii::$app->request->post('status',Coupon::FILTER_STATUS_EFFECTIVE);
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        return \Yii::$app->response->success(Coupon::getCouponListOfMch($mchId,$status,$page,$pageSize));
    }

    /**
     * 创建优惠券
     * @return \common\components\Response
     */
    public function actionCreate(){
        $userId=\Yii::$app->user->getId();
        $mchId=\Yii::$app->user->getIdentity()->getMerchantId();
        $type=\Yii::$app->request->post('type');
        $creator=Creator::get($type);
        if(empty($creator)){
            return \Yii::$app->response->error(Creator::getError());
        }
        $creator->user_id=$userId;
        $creator->mch_id=$mchId;
        $creator->create_time=time();
        $creator->status=Coupon::STATUS_EXAMINING;
        $creator->title=\Yii::$app->request->post('title','');
        $creator->sub_title=\Yii::$app->request->post('subTitle','');
        $creator->shop_price=\Yii::$app->request->post('shopPrice',0);
        $creator->discount=\Yii::$app->request->post('discount');
        $creator->minimum_consumption=\Yii::$app->request->post('minimumConsumption',0);
        $creator->suitable_product=\Yii::$app->request->post('suitableProduct','');
        $creator->unsuitable_product=\Yii::$app->request->post('unsuitableProduct','');
        $creator->notice=\Yii::$app->request->post('notice','');
        $creator->total_num=\Yii::$app->request->post('totalNum','');
        $creator->upper_limit_per_person=\Yii::$app->request->post('upperLimitPerPerson',1);
        $creator->end_date=\Yii::$app->request->post('endDate');
        $creator->usable_slot=\Yii::$app->request->post('usableSlot');

        $coupon=$creator->create();
        if(empty($coupon)){
            return \Yii::$app->response->error($creator->getError());
        }else{
            return \Yii::$app->response->success($creator->getAttributes());
        }
    }

    /**
     * 发放券
     * @return \common\components\Response
     */
    public function actionGrant(){
        $id=\Yii::$app->request->post('couponId');
        $merchant=\Yii::$app->user->getIdentity()->getMerchant();
        if(empty($merchant)){
            return \Yii::$app->response->error(ERROR_MERCHANT_NOT_FOUND);
        }
        $granter=new Granter($merchant);
        if($granter->grant($id)){
            return \Yii::$app->response->success();
        }else{
            return \Yii::$app->response->error($granter::getError());
        }
    }
}
