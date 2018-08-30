<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string $title
 * @property string $note
 * @property string $date_start
 * @property string $date_end
 * @property int $price
 * @property int $tour_id
 *
 * @property Tour $tour
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'note'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['price', 'tour_id'], 'integer'],
            [['title', 'note'], 'string', 'max' => 50],
            [['tour_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tour::className(), 'targetAttribute' => ['tour_id' => 'id']],
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
            'note' => Yii::t('app', 'Note'),
            'date_start' => Yii::t('app', 'Date Start'),
            'date_end' => Yii::t('app', 'Date End'),
            'price' => Yii::t('app', 'Price'),
            'tour_id' => Yii::t('app', 'Tour ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tour_id']);
    }
}
