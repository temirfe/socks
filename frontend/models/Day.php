<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "day".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 * @property string $itinerary
 * @property string $itinerary_ru
 * @property string $itinerary_ko
 * @property string $meals
 * @property string $meals_ru
 * @property string $meals_ko
 * @property string $accommodation
 * @property string $accommodation_ru
 * @property string $accommodation_ko
 * @property int $tour_id
 *
 * @property Tour $tour
 */
class Day extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['itinerary', 'itinerary_ru', 'itinerary_ko'], 'string'],
            [['tour_id'], 'integer'],
            [['title', 'title_ru', 'title_ko'], 'string', 'max' => 50],
            [['meals', 'meals_ru', 'meals_ko'], 'string', 'max' => 255],
            [['accommodation', 'accommodation_ru', 'accommodation_ko'], 'string', 'max' => 250],
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
            'title_ru' => Yii::t('app', 'Title Ru'),
            'title_ko' => Yii::t('app', 'Title Ko'),
            'itinerary' => Yii::t('app', 'Itinerary'),
            'itinerary_ru' => Yii::t('app', 'Itinerary Ru'),
            'itinerary_ko' => Yii::t('app', 'Itinerary Ko'),
            'meals' => Yii::t('app', 'Meals'),
            'meals_ru' => Yii::t('app', 'Meals Ru'),
            'meals_ko' => Yii::t('app', 'Meals Ko'),
            'accommodation' => Yii::t('app', 'Accommodation'),
            'accommodation_ru' => Yii::t('app', 'Accommodation Ru'),
            'accommodation_ko' => Yii::t('app', 'Accommodation Ko'),
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

    function afterFind()
    {
        parent::afterFind();
        $curLang=Yii::$app->language;
        if(Yii::$app->controller->action->id!='update'){
            if($curLang=='ru-RU'){
            $this->title=$this->title_ru;
            $this->itinerary=$this->itinerary_ru;
            $this->accommodation=$this->accommodation_ru;
            $this->meals=$this->meals_ru;
            }
            else if($curLang=='ko-KR'){
                $this->title=$this->title_ko;
                $this->itinerary=$this->itinerary_ko;
                $this->accommodation=$this->accommodation_ko;
                $this->meals=$this->meals_ko;
            }
        }
    }
}
