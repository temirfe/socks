<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $public
 * @property int $weight
 * @property string $title
 * @property string $description
 * @property string $image
 *
 * @property Product[] $product
 * @property Category[] $parent
 */
class Category extends MyModel
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
        $local= [
            [['title'], 'required'],
            [['parent_id','public','weight'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['image'], 'safe'],
        ];
        return array_merge($local, parent::rules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $local= [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'parent_id' => Yii::t('app', 'Parent'),
            'public' => Yii::t('app', 'Public'),
            'weight' => Yii::t('app', 'Weight'),
        ];
        return array_merge($local, parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public static function getList(){
        return ArrayHelper::map(Category::find()->select(['id','title'])->asArray()->all(),'id','title');
    }


    public static function withChildren($id){
        $children=Yii::$app->db->createCommand("Select id from category where parent_id='{$id}'")->queryAll();
        $ret=$id;
        if($children){
            $ret=[$id];
            foreach($children as $child){
                $ret[]=$child['id'];
            }
        }
        return $ret;
    }

    public function beforeSave($insert)
    {
        if(!$this->weight){$this->weight=0;}
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('category');
    }
}
