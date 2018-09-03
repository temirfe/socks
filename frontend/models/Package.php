<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property string $included
 * @property string $included_ru
 * @property string $included_ko
 * @property string $not_included
 * @property string $not_included_ru
 * @property string $not_included_ko
 * @property int $tour_id
 *
 * @property Tour $tour
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['included'], 'required'],
            [['included', 'included_ru', 'included_ko', 'not_included', 'not_included_ru', 'not_included_ko'], 'string'],
            [['tour_id'], 'integer'],
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
            'included' => Yii::t('app', 'Included'),
            'included_ru' => Yii::t('app', 'Included Ru'),
            'included_ko' => Yii::t('app', 'Included Ko'),
            'not_included' => Yii::t('app', 'Not Included'),
            'not_included_ru' => Yii::t('app', 'Not Included Ru'),
            'not_included_ko' => Yii::t('app', 'Not Included Ko'),
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
