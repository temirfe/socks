<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tour".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property int $days
 * @property int $category_id
 * @property int $destination_id
 *
 * @property Price[] $prices
 * @property Category $category
 * @property Destination $destination
 */
class Tour extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'image', 'description'], 'required'],
            [['description'], 'string'],
            [['days', 'category_id', 'destination_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],
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
            'description' => Yii::t('app', 'Description'),
            'days' => Yii::t('app', 'Days'),
            'category_id' => Yii::t('app', 'Category ID'),
            'destination_id' => Yii::t('app', 'Destination ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['tour_id' => 'id']);
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
