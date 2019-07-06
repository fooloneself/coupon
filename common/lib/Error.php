<?php
namespace common\lib;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 4:50
 */
class Error{

    /**
     * 错误编码
     * @var int
     */
    private $code;

    /**
     * 错误信息
     * @var string
     */
    private $errMsg;

    /**
     * Error constructor.
     * @param int $code
     * @param string $errMsg
     */
    function __construct(int $code=0,string $errMsg='')
    {
        $this->code=$code;
        $this->errMsg=$errMsg;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getErrMsg(): string
    {
        return $this->errMsg;
    }

    /**
     * @param string $errMsg
     */
    public function setErrMsg(string $errMsg)
    {
        $this->errMsg = $errMsg;
    }

    /**
     * @param int $code
     * @param string $err
     * @return static
     */
    public static function instance(int $code,string $err=''){
        return new static($code,$err);
    }
}