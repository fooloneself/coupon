<?php

//程序错误
define('ERROR_EXCEPTION',1);
//未登录
define('ERROR_NOT_LOGIN',2);
//未注册商户
define('ERROR_NOT_REGISTER_MERCHANT',3);
//参数错误
define('ERROR_PARAM_WRONG',4);
//数据库保存失败
define('ERROR_DATABASE_SAVE_FAIL',5);
//未找打商品
define('ERROR_PRODUCT_NOT_FOUND',6);
//数据库删除失败
define('ERROR_DATABASE_DELETE_FAIL',7);
//未找到券
define('ERROR_COUPON_NOT_FOUND',8);
//券已失效
define('ERROR_COUPON_OVERDUE',9);
//此券不能投放
define('ERROR_COUPON_CANNOT_GRANT',10);
//此券不能领取
define('ERROR_COUPON_CANNOT_RECEIVE',11);
//券币不足
define('ERROR_COUPON_CURRENCY_NOT_ENOUGH',12);
//未找到商户
define('ERROR_MERCHANT_NOT_FOUND',13);
//领取数量已达上线
define('ERROR_COUPON_RECEIVE_OVERRUN',14);
//券已领完
define('ERROR_COUPON_RECEIVE_OVER',14);