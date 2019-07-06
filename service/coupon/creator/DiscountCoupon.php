<?php
namespace service\coupon\creator;

use app\models\Coupon;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 9:18
 */

class DiscountCoupon extends Creator{

    function __construct()
    {
        parent::__construct(Coupon::TYPE_DISCOUNT_COUPON);
    }

    public function validator(): array
    {
        return array_merge(parent::validator(),[
            [[$this,'checkDiscount'],['$','discount'],[ERROR_PARAM_WRONG,'折扣额度在0~10之间']]
        ]);
    }


    public function checkDiscount($discount):bool {
        if(is_numeric($discount) && $discount>0 && $discount<10){
            return true;
        }else{
            return false;
        }
    }
}