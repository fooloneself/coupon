<?php
namespace service\coupon\creator;
use app\models\Coupon;
use common\lib\Error;
use common\lib\Service;

/**
 * Class Creator
 * @package service\coupon\creator
 * @property int $id 优惠券id
 * @property int $mch_id 商户id
 * @property int $user_id 发布券的账户id
 * @property int $total_num 发放总量
 * @property int $race_num 已抢占数量
 * @property int $upper_limit_per_person 每人可领取的数量上限
 * @property int $create_time 创建时间
 * @property int $type 优惠券类型：1代金券 2折扣券 3兑换券 4团购券 5特价券
 * @property int $status 状态:1待审核 2拒绝 3待投放 4已投放 5已下架
 * @property string $start_date 券可用起始日期
 * @property string $end_date 券可用截止日期
 * @property string $title 卡券名称
 * @property string $sub_title 卡券副标题
 * @property string $shop_price 店面价格
 * @property string $discount 优惠
 * @property string $minimum_consumption 最低消费
 * @property string $usable_slot 可用时段
 * @property string $notice 使用须知
 * @property string $suitable_product 适合产品
 * @property string $unsuitable_product 不适合产品
 */

class Creator extends Service{

    protected static $creatorTypes=[
        Coupon::TYPE_CASH_COUPON=>CashCoupon::class,
        Coupon::TYPE_DISCOUNT_COUPON=>DiscountCoupon::class,
        Coupon::TYPE_GROUP_BUY_COUPON=>GroupByCoupon::class,
        Coupon::TYPE_EXCHANGE_COUPON=>ExchangeCoupon::class,
        Coupon::TYPE_SPECIAL_PRICE_COUPON=>SpecialPriceCoupon::class,
    ];

    private $coupon;

    function __construct(int $type)
    {
        $this->coupon=new Coupon();
        $this->coupon->type=$type;
    }

    public function __get($name)
    {
        return $this->coupon->$name;
    }

    public function __set($name, $value)
    {
        $this->coupon->$name=$value;
    }

    /**
     * 校验器
     * @return array
     */
    public function validator():array{
        return [
            [[$this,'mbLength'],['$','title'],0,9,[ERROR_PARAM_WRONG,'标题长度超限']],
            [[$this,'mbLength'],['$','subTitle'],0,9,[ERROR_PARAM_WRONG,'副标题长度超限']],
            [[$this,'mbLength'],['$','notice'],0,50,[ERROR_PARAM_WRONG,'使用须知长度超限']],
            [[$this,'largerThanZero'],['$','upper_limit_per_person'],[ERROR_PARAM_WRONG,'每人可领取数必须大于零']],
            [[$this,'largerThanZero'],['$','total_num'],[ERROR_PARAM_WRONG,'每人可领取数必须大于零']],
        ];
    }

    public function largerThanZero($num):bool {
        return is_numeric($num) && $num>0;
    }

    public function mbLength(string $str,int $min,int $max):bool {
        $len=mb_strlen($str);
        if($len>=$min && $len<=$max){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证数据正确性
     * @return Error|null
     */
    final private function validate():?Error{
        $validators=$this->validator();
        $error=null;
        foreach ($validators as $validator){
            $error=array_pop($validator);
            $callable=array_shift($validator);
            $params=$this->getValidatorParams($validator);
            if(call_user_func($callable,$params)==false){
                break;
            }else{
                $error=null;
            }
        }
        if(is_array($error)){
            return Error::instance($error[0],$error[1]);
        }else if(is_int($error)){
            return Error::instance($error);
        }else{
            return $error;
        }
    }

    /**
     * 获取校验器参数
     * @param array $params
     * @return array
     */
    final private function getValidatorParams(array $params):array{
        $args=[];
        foreach ($params as $param){
            if(is_array($param) && !empty($param[0]) && $param[0]==='$' && isset($param[1])){
                $args[]=$this->coupon->$param[1];
            }else{
                $args[]=$param;
            }
        }
        return $args;
    }

    /**
     * 创建优惠券
     * @return Coupon|null
     */
    public function create():?Coupon{
        if(!$this->coupon->validate()){
            self::setError(ERROR_PARAM_WRONG);
            return null;
        }
        $err=$this->validate();
        if($err instanceof Error){
            self::setError($err);
            return null;
        }
        if($this->coupon->insert(false)){
            return $this->coupon;
        }else{
            self::setError(Error::instance(ERROR_DATABASE_SAVE_FAIL));
            return null;
        }
    }

    public function getAttributes():array{
        return $this->coupon->getAttributes();
    }

    /**
     * 实例化优惠券
     * @param int $type
     * @return null|Creator
     */
    public static function get(int $type):?Creator{
        if(isset(self::$creatorTypes[$type])){
            $className=self::$creatorTypes[$type];
            return $className::singleton();
        }else{
            self::setError(Error::instance(ERROR_PARAM_WRONG,'优惠券类型错误'));
            return null;
        }
    }
}