<?php
namespace common\lib;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 4:48
 */

class Service{

    /**
     * 服务实例
     * @var array
     */
    private static $__instances=[];

    /**
     * @var null|Error
     */
    private static $__err;

    /**
     * 设置错误信息
     * @param Error $error
     */
    public static function setError(Error $error){
        self::$__err=$error;
    }

    /**
     * 获取错误信息
     * @return Error
     */
    public static function getError():Error{
        return self::$__err;
    }

    /**
     * 单例模式创建对象实例
     * @param array ...$args
     * @return mixed
     */
    public static function singleton(... $args){
        if(!isset(self::$__instances[static::class])){
            self::$__instances[static::class]=\Yii::createObject(static::class,$args);
        }
        return self::$__instances[static::class];
    }
}