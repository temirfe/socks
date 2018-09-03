<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $note
 * @property string $admin_note
 * @property string $date_start
 * @property string $birthday
 * @property int $price
 * @property string $currency
 * @property int $tour_id
 * @property int $price_id
 * @property int $group_of
 * @property int $payment_method
 * @property int $status
 *
 * @property Price $price0
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email'], 'required'],
            [['date_start', 'birthday'], 'safe'],
            [['price', 'tour_id', 'price_id', 'group_of', 'payment_method', 'status'], 'integer'],
            [['name', 'surname', 'email'], 'string', 'max' => 50],
            [['note', 'admin_note'], 'string', 'max' => 250],
            [['currency'], 'string', 'max' => 3],
            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => Price::className(), 'targetAttribute' => ['price_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'email' => Yii::t('app', 'Email'),
            'note' => Yii::t('app', 'Note'),
            'admin_note' => Yii::t('app', 'Admin Note'),
            'date_start' => Yii::t('app', 'Date Start'),
            'birthday' => Yii::t('app', 'Birthday'),
            'price' => Yii::t('app', 'Price'),
            'currency' => Yii::t('app', 'Currency'),
            'tour_id' => Yii::t('app', 'Tour ID'),
            'price_id' => Yii::t('app', 'Price ID'),
            'group_of' => Yii::t('app', 'Group Of'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceRel()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }

    function beforeSave($insert)
    {
        $price=$this->priceRel;
        $this->tour_id=$price->tour_id;
        $this->price=$price->price;
        $this->currency=$price->currency;
        $this->group_of=$price->group_of;
        if($price->date_start){$this->date_start=$price->date_start;}
        return parent::beforeSave($insert);
    }
}
