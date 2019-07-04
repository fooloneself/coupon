<?php

namespace app\controllers;

use app\models\Merchant;
use yii\base\Controller;

class SiteController extends Controller
{


    /**
     * 推荐列表
     * @return \common\components\Response
     */
    public function actionRecommendList(){
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        return \Yii::$app->response->success(Merchant::getRecommendList($page,$pageSize));
    }

}
