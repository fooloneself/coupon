<?php

namespace app\controllers;

use app\models\Merchant;
use app\models\MerchantWeight;
use yii\base\Controller;

class UserController extends Controller
{


    /**
     * 推荐列表
     * @return \common\components\Response
     */
    public function actionRecommendList(){
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        $merchants=MerchantWeight::getRecommendList($page,$pageSize);
        foreach ($merchants as &$merchant){
            $merchant['products']=self::toProducts($merchant['products']);
        }
        return \Yii::$app->response->success($merchants);
    }

    /**
     * 将字符串转为二维数组
     * @param string $products
     * @return array
     */
    public static function toProducts(string $products):array{
        if(empty($products))return [];
        $products=explode(';',$products);
        $ret=[];
        foreach ($products as $product){
            list($id,$name,$price,$coverImg)=explode(',',$product);
            $ret[]=[
                'id'=>$id,
                'name'=>$name,
                'price'=>$price,
                'cover_img'=>$coverImg
            ];
        }
        return $ret;
    }

    /**
     * 登录
     */
    public function actionLogin(){
        $code=\Yii::$app->request->post('code');
        $res=\Yii::$app->user->wxCodeToSession($code);
        return \Yii::$app->response->success($res);
    }

    /**
     * 退出登录
     */
    public function actionLogout(){
        \Yii::$app->user->logout();
        return \Yii::$app->response->success();
    }

}
