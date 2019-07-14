<?php

namespace app\modules\merchant;

/**
 * merchant module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\merchant\controllers';


    public function beforeAction($action)
    {
        \Yii::$app->user->renewIdentity(\Yii::$app->request->getIdentityId());
        if(\Yii::$app->user->isLogin(\Yii::$app->request->getToken()) ){
            \Yii::$app->response->error(ERROR_NOT_LOGIN);
            return false;
        }else if(!\Yii::$app->user->getIdentity()->hasRegisterMerchant()){
            \Yii::$app->response->error(ERROR_NOT_REGISTER_MERCHANT);
            return false;
        }
        return parent::beforeAction($action);
    }
}
