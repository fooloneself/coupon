<?php
namespace service\coupon\creator;
use app\models\Coupon;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 9:22
 */
class ExchangeCoupon extends Creator{

    function __construct()
    {
        parent::__construct(Coupon::TYPE_EXCHANGE_COUPON);
    }

    public function validator(): array
    {
        return array_merge(parent::validator(),[
            [[$this,'checkGift'],['$','discount'],9,[ERROR_PARAM_WRONG,'礼品不能为空且字数不超过9个汉字']]
        ]);
    }

    public function checkDiscount($discount,int $length):bool {
        if(empty($discount) || mb_strlen($discount)>$length){
            return false;
        }else{
            return true;
        }
    }
}