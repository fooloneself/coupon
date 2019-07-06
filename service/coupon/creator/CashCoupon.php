<?php
namespace service\coupon\creator;

use app\models\Coupon;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 9:12
 */
class CashCoupon extends Creator{

    function __construct($type)
    {
        parent::__construct(Coupon::TYPE_CASH_COUPON);
    }


    public function validator(): array
    {
        return array_merge(parent::validator(),[
            [[$this,'largerThanZero'],['$','discount'],[ERROR_PARAM_WRONG,'金额必须大于零']]
        ]);
    }
}