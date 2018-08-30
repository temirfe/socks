<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category_desc".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $intro
 * @property string $description
 * @property int $category_id
 * @property int $destination_id
 *
 * @property Category $category
 * @property Destination $destination
 */
class Description extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_desc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'image', 'intro', 'description'], 'required'],
            [['description'], 'string'],
            [['category_id', 'destination_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],
            [['intro'], 'string', 'max' => 500],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destination::className(), 'targetAttribute' => ['destination_id' => 'id']],
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
            'image' => Yii::t('app', 'Image'),
            'intro' => Yii::t('app', 'Intro'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category ID'),
            'destination_id' => Yii::t('app', 'Destination ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(Destination::className(), ['id' => 'destination_id']);
    }
}
