<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/14 0014
 * Time: 上午 10:46
 */

namespace common\components;


use app\models\Merchant;
use app\models\User;
use yii\base\Component;

class UserAuthority extends Component
{
    /**
     * @var User
     */
    private $_identity;

    /**
     * 获取身份标识
     * @return User|null
     */
    public function getIdentity(){
        return $this->_identity;
    }

    /**
     * 刷新身份标识
     * @param string $id
     */
    public function renewIdentity(string $id){
        $this->_identity=User::findIdentityByOpenId($id);
    }

    /**
     * 是否为游客
     * @return bool
     */
    public function getIsGuest():bool {
        return $this->getIdentity()==null;
    }

    public function getId(){
        return $this->getIdentity()->getId();
    }

    /**
     * 是否登录
     * @param string $token
     * @return bool
     */
    public function isLogin(string $token):bool {
        if(empty($token) || $this->getIsGuest() || $this->getIdentity()->getAuthKey()!=$token){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 登录
     * @param User $user
     * @return bool
     */
    public function login(User $user):bool {
        $this->_identity=$user;
        return $this->_identity->save();
    }

    /**
     * 退出登录
     */
    public function logout(){
        $this->_identity->session_token='';
        $this->_identity->update();
        $this->_identity=null;
    }

    /**
     *
     * @param $code
     * @return mixed
     */
    public function wxCodeToSession($code){
        $wx=\Yii::$app->params['wxSmallProject'];
        $paramStr=http_build_query([
            'appid'=>$wx['appId'],
            'secret'=>$wx['appSecret'],
            'js_code'=>$code,
            'grant_type'=>'authorization_code'
        ]);
        $url=$wx['code2Session'].'?'.$paramStr;
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_HEADER,0);
        $res=curl_exec($ch);
        curl_close($ch);
        return $res;
    }

}