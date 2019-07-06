<?php
namespace app\modules\user\controllers;

use app\models\CouponItem;
use yii\base\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 3:52
 */
class StatisticsController extends Controller{

    /**
     * 获取用户优惠券的统计数
     * @return \common\components\Response
     */
    public function actionCoupon(){
        $userId=\Yii::$app->user->getId();
        $usedCount=CouponItem::getUsedCouponCountOfUser($userId);
        $usableCount=CouponItem::getUsableCouponCountOfUser($userId);
        $totalCount=CouponItem::getTotalCountThatOwnWithUser($userId);
        $discountAmount=CouponItem::getDiscountAmountOfUser($userId);
        return \Yii::$app->response->success([
            'used'=>$usedCount,
            'usable'=>$usableCount,
            'totalNum'=>$totalCount,
            'hasDiscountAmount'=>$discountAmount
        ]);
    }
}