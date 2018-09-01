<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 * @property string $note
 * @property string $note_ru
 * @property string $note_ko
 * @property string $date_start
 * @property string $date_end
 * @property int $price
 * @property string $currency
 * @property int $tour_id
 * @property int $group_of
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
            [['price'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['price', 'tour_id', 'group_of'], 'integer'],
            [['title', 'title_ru', 'title_ko', 'note', 'note_ru', 'note_ko'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 3],
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
            'title' => Yii::t('app', 'Title En'),
            'title_ru' => Yii::t('app', 'Title Ru'),
            'title_ko' => Yii::t('app', 'Title Ko'),
            'note' => Yii::t('app', 'Note En'),
            'note_ru' => Yii::t('app', 'Note Ru'),
            'note_ko' => Yii::t('app', 'Note Ko'),
            'date_start' => Yii::t('app', 'Date Start'),
            'date_end' => Yii::t('app', 'Date End'),
            'price' => Yii::t('app', 'Price'),
            'currency' => Yii::t('app', 'Currency'),
            'tour_id' => Yii::t('app', 'Tour'),
            'group_of' => Yii::t('app', 'Group Of'),
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
