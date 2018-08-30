<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "destination".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $intro
 * @property string $text
 *
 * @property CategoryDesc[] $categoryDescs
 * @property Tour[] $tours
 */
class Destination extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destination';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'image', 'intro', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],
            [['intro'], 'string', 'max' => 500],
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
            'text' => Yii::t('app', 'Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryDescs()
    {
        return $this->hasMany(CategoryDesc::className(), ['destination_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasMany(Tour::className(), ['destination_id' => 'id']);
    }
}
