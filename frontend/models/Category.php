<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 *
 * @property Product[] $product
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public static function getList(){
        return ArrayHelper::map(Category::find()->select(['id','title'])->asArray()->all(),'id','title');
    }


    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('category');
    }
}
