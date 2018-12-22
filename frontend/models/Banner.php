<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $image
 * @property integer $public
 * @property integer $type
 * @property string $link
 * @property integer $weight
 * @property integer $component_id
 * @property string $title
 * @property string $component
 * @property string $description
 */
class Banner extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules= [
            [['public', 'type', 'weight','component_id'], 'integer'],
            [['image', 'link','component'], 'string', 'max' => 200],
            [['title','description'], 'string', 'max' => 500],
            [['weight'], 'default','value' => 0],
        ];

        return ArrayHelper::merge(parent::rules(),$rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $rules= [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Image'),
            'public' => Yii::t('app', 'Public'),
            'type' => Yii::t('app', 'Type'),
            'link' => Yii::t('app', 'Link'),
            'weight' => Yii::t('app', 'Weight'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];

        return ArrayHelper::merge(parent::attributeLabels(),$rules);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->link){
                $urlArr=parse_url($this->link);
                if(!empty($urlArr['host']) && $urlArr['host']!=Yii::$app->request->serverName){
                    //link to other site
                    $this->component="";
                    $this->component_id=0;
                }
                else{
                    if(!empty($urlArr['path'])){
                        $path=trim($urlArr['path'], '/');
                        $expl=explode('/',$path);
                        $components=['category','product','page'];
                        if(in_array($expl[0],$components) && !empty($expl[1])){
                            $this->component=$expl[0];
                            $this->component_id=$expl[1];
                            if(isset($urlArr['query'])){
                                $query=trim($urlArr['query'], '/');
                                $query_expl=explode('=',$query);
                                if($query_expl[0]=='category_id' && !empty($query_expl[1])){
                                    $this->component="category";
                                    $this->component_id=$query_expl[1];
                                }
                            }
                        }
                        else{
                            $rows=Yii::$app->db->createCommand("SELECT id, url FROM page")->queryAll();
                            foreach ($rows as $row) {
                                if($row['url']==$expl[0]){
                                    $this->component='page';
                                    $this->component_id=$row['id'];
                                }
                            }
                        }
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
