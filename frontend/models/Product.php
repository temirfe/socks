<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $images
 * @property int $public
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $price
 * @property int $sex
 * @property string $mainImg
 *
 * @property Category $category
 */
class Product extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $local= [
            [['title'], 'required'],
            [['public', 'category_id', 'price', 'sex'], 'integer'],
            [['description'], 'string'],
            [['images'], 'string', 'max' => 500],
            [['title'], 'string', 'max' => 500],
        ];
        return array_merge($local, parent::rules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $local=  [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Image'),
            'public' => Yii::t('app', 'Public'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category'),
            'price' => Yii::t('app', 'Price'),
            'sex' => Yii::t('app', 'Sex'),
        ];
        return array_merge($local, parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getMainImg(){
        if($this->images){
            return explode(';',$this->images)[0];
        }
        return '';
    }

    public static function getImg($images){
        if($images){
            return explode(';',$images)[0];
        }
        return '';
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->db->createCommand()->update('category',['has_product'=>1],['id'=>$this->category_id])->execute();
        Yii::$app->db->createCommand()->update('category',['has_product'=>1],['id'=>$this->category->parent_id])->execute();
    }
}
