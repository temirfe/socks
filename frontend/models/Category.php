<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 *
 * @property Description[] $Description
 * @property Tour[] $tours
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
            [['title','title_ru','title_ko'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title (en)'),
            'title_ru' => Yii::t('app', 'Title (ru)'),
            'title_ko' => Yii::t('app', 'Title (ko)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        return $this->hasMany(Description::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasMany(Tour::className(), ['category_id' => 'id']);
    }

    public static function getList(){
        return ArrayHelper::map(Category::find()->select(['id','title'])->asArray()->all(),'id','title');
    }

    function afterFind()
    {
        parent::afterFind();
        $curLang=Yii::$app->language;
        if($curLang=='ru-RU'){
            $this->title=$this->title_ru;
        }
        else if($curLang=='ko-KR'){
            $this->title=$this->title_ko;
        }
    }
}
