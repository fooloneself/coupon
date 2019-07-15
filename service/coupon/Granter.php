<?php
namespace service\coupon;

use app\models\Merchant;
use common\lib\Service;

/**
 * 商户发放券
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15 0015
 * Time: 下午 10:07
 */
class Granter extends Service
{
    /**
     * @var Merchant
     */
    private $merchant;

    /**
     * Granter constructor.
     * @param Merchant $merchant
     */
    function __construct(Merchant $merchant)
    {
        $this->merchant=$merchant;
    }

    /**
     * 发放
     * @param int $couponId
     * @return bool
     */
    public function grant(int $couponId):bool {
        $coupon=$this->merchant->getCouponById($couponId);
        if(empty($coupon)){
            self::setError(ERROR_COUPON_NOT_FOUND);
            return false;
        }else if(!$coupon->canGrant()){
            self::setError(ERROR_COUPON_CANNOT_GRANT);
            return false;
        }else if($coupon->isOverdue()){
            self::setError(ERROR_COUPON_OVERDUE);
            return false;
        }
        $currency=$coupon->calculateCouponCurrency();
        if($this->merchant->coupon_currency<$currency){
            self::setError(ERROR_COUPON_CURRENCY_NOT_ENOUGH);
            return false;
        }
        $transaction=\Yii::$app->db->beginTransaction();
        $res=$coupon->grant() && $this->merchant->deductCurrency($currency);
        if($res){
            $transaction->commit();
            return true;
        }else{
            self::setError(ERROR_DATABASE_SAVE_FAIL);
            $transaction->rollBack();
            return false;
        }
    }
}