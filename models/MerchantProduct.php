<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant_product".
 *
 * @property int $id 产品id
 * @property int $user_id 发布账号id
 * @property int $mch_id 商户id
 * @property string $code 产品编号
 * @property string $name 产品名称
 * @property string $price 产品单价
 * @property string $cover_img 产品封面图
 * @property int $create_time 创建时间
 */
class MerchantProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'mch_id', 'create_time'], 'integer'],
            [['price'], 'number'],
            [['code', 'name'], 'string', 'max' => 100],
            [['cover_img'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'mch_id' => 'Mch ID',
            'code' => 'Code',
            'name' => 'Name',
            'price' => 'Price',
            'cover_img' => 'Cover Img',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * 获取商家的产品列表
     * @param int $mchId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getProductListOfMch(int $mchId,int $page,int $pageSize):array{
        return self::find()
            ->where([
                'mch_id'=>$mchId,
            ])
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->asArray()->all();
    }
}
