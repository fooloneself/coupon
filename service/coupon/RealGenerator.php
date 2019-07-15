<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15 0015
 * Time: 下午 10:27
 */

namespace service\coupon;


use app\models\Coupon;
use app\models\CouponItem;
use common\lib\Service;

class RealGenerator extends Service
{

    /**
     * @var Coupon
     */
    private $coupon;

    /**
     * RealGenerator constructor.
     * @param Coupon $coupon
     */
    function __construct(Coupon $coupon)
    {
        $this->coupon=$coupon;
    }

    /**
     *
     * @param int $userId
     * @return bool
     */
    public function generate(int $userId):bool {
        if($this->coupon->isOverdue()){
            self::setError(ERROR_COUPON_OVERDUE);
            return false;
        }else if(!$this->coupon->canReceive()){
            self::setError(ERROR_COUPON_CANNOT_RECEIVE);
            return false;
        }else if(!$this->coupon->hasSurplus()){
            self::setError(ERROR_COUPON_RECEIVE_OVER);
            return false;
        }else if($this->coupon->hasReceivedNum($userId)>=$this->coupon->upper_limit_per_person){
            self::setError(ERROR_COUPON_RECEIVE_OVERRUN);
            return false;
        }else{
            $couponItem=new CouponItem();
            $couponItem->coupon_id=$this->coupon->id;
            $couponItem->own_user_id=$userId;
            $couponItem->own_time=time();
            $couponItem->code=$this->coupon->generateCouponCode();
            $couponItem->status=CouponItem::STATUS_NOT_USE;
            $transaction=\Yii::$app->db->beginTransaction();
            if($couponItem->insert() && $this->coupon->addRaceNum()){
                $transaction->commit();
                return true;
            }else{
                $transaction->rollBack();
                self::setError(ERROR_DATABASE_SAVE_FAIL);
                return false;
            }
        }
    }
}