<?php
namespace app\modules\merchant\controllers;
use app\models\MerchantProduct;
use yii\base\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/6 0006
 * Time: 下午 10:28
 */
class ProductController extends Controller{

    /**
     * 商户产品列表
     * @return \common\components\Response
     */
    public function actionList(){
        $mchId=\Yii::$app->user->getIdentity()->getMerchantId();
        $page=\Yii::$app->request->post('page',1);
        $pageSize=\Yii::$app->request->post('pageSize',10);
        $mchId=intval($mchId);
        if($mchId<=0){
            return \Yii::$app->response->error(ERROR_PARAM_WRONG);
        }else{
            return \Yii::$app->response->success(MerchantProduct::getProductListOfMch($mchId,$page,$pageSize));
        }
    }

    /**
     * 添加产品
     * @return \common\components\Response
     */
    public function actionAdd(){
        $product=new MerchantProduct();
        $product->user_id=\Yii::$app->user->getId();
        $product->mch_id=\Yii::$app->user->getIdentity()->getMerchantId();
        $product->code=MerchantProduct::productCode();
        $product->name=\Yii::$app->request->post('name');
        $product->price=\Yii::$app->request->post('price',0);
        $product->cover_img=\Yii::$app->request->post('coverImg');
        $product->create_time=time();
        if($product->insert()){
            return \Yii::$app->response->success($product->getAttributes());
        }else{
            return \Yii::$app->response->error(ERROR_DATABASE_SAVE_FAIL);
        }
    }

    /**
     * 编辑产品
     * @return \common\components\Response
     */
    public function actionEdit(){
        $mchId=\Yii::$app->user->getIdentity()->getMerchantId();
        $productId=\Yii::$app->request->post('productId');
        $product=MerchantProduct::findOne(['id'=>$productId,'mch_id'=>$mchId]);
        if(empty($product)){
            return \Yii::$app->response->error(ERROR_PRODUCT_NOT_FOUND);
        }
        $product->name=\Yii::$app->request->post('name');
        $product->price=\Yii::$app->request->post('price',0);
        $product->cover_img=\Yii::$app->request->post('coverImg');
        if($product->save()){
            return \Yii::$app->response->success();
        }else{
            return \Yii::$app->response->error(ERROR_DATABASE_SAVE_FAIL);
        }
    }

    /**
     * 删除商品失败
     * @return \common\components\Response
     */
    public function actionDelete(){
        $mchId=\Yii::$app->user->getIdentity()->getMerchantId();
        $productId=\Yii::$app->request->post('productId');
        $product=MerchantProduct::findOne(['id'=>$productId,'mch_id'=>$mchId]);
        if(empty($product)){
            return \Yii::$app->response->error(ERROR_PRODUCT_NOT_FOUND);
        }
        if($product->delete()){
            return \Yii::$app->response->success();
        }else{
            return \Yii::$app->response->error(ERROR_DATABASE_DELETE_FAIL);
        }
    }
}