<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $image
 * @property int $public
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $price
 * @property int $sex
 */
class Product extends \yii\db\ActiveRecord
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
        return [
            [['image', 'title'], 'required'],
            [['public', 'category_id', 'price', 'sex'], 'integer'],
            [['description'], 'string'],
            [['image'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Image'),
            'public' => Yii::t('app', 'Public'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category ID'),
            'price' => Yii::t('app', 'Price'),
            'sex' => Yii::t('app', 'Sex'),
        ];
    }
}
