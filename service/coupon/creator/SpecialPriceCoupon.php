<?php
namespace service\coupon\creator;
use app\models\Coupon;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 9:34
 */
class SpecialPriceCoupon extends Creator{

    function __construct()
    {
        parent::__construct(Coupon::TYPE_SPECIAL_PRICE_COUPON);
    }

    public function validator(): array
    {
        return array_merge(parent::validator(),[
            [[$this,'largerThanZero'],['$','shop_price'],[ERROR_PARAM_WRONG,'店面价格必须大于零']],
            [[$this,'largerThanZero'],['$','discount'],[ERROR_PARAM_WRONG,'店面价格必须大于零']],
            [[$this,'checkDiscount'],['$','shop_price'],['$','discount'],[ERROR_PARAM_WRONG,'店面价格必须大于特价']],
        ]);
    }

    public function checkDiscount($shopPrice,$discount):bool {
        return $shopPrice>$discount;
    }
}