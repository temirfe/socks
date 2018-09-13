<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

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
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Price $price0
 */
class Book extends ActiveRecord
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
            [['price', 'tour_id', 'price_id', 'group_of', 'payment_method', 'status','created_at','updated_at'], 'integer'],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
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
