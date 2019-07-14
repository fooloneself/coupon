<?php

namespace app\modules\user;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';


    public function beforeAction($action)
    {
        \Yii::$app->user->renewIdentity(\Yii::$app->request->getIdentityId());
        if(!\Yii::$app->user->isLogin(\Yii::$app->request->getToken()) ){
            \Yii::$app->response->error(ERROR_NOT_LOGIN);
            return false;
        }else{
            return parent::beforeAction($action);
        }
    }
}
