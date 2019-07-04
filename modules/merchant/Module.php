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

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

    }

    public function beforeAction($action)
    {
        if(\Yii::$app->user->getIsGuest()){
            \Yii::$app->response->error(ERROR_NOT_LOGIN);
            return false;
        }else if(!\Yii::$app->user->getIdentity(true)->hasRegisterMerchant()){
            \Yii::$app->response->error(ERROR_NOT_REGISTER_MERCHANT);
            return false;
        }
        return parent::beforeAction($action);
    }
}
