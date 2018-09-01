<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "destination".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 * @property string $images
 * @property string $intro
 * @property string $intro_ru
 * @property string $intro_ko
 * @property string $text
 * @property string $text_ru
 * @property string $text_ko
 *
 * @property Description[] $categoryDescs
 * @property Tour[] $tours
 */

class Destination extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $imageFiles=array();

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
            [['title'], 'required'],
            [['text','text_ru','text_ko','images'], 'string'],
            [['title','title_ru','title_ko'], 'string', 'max' => 255],
            [['intro','intro_ru','intro_ko'], 'string', 'max' => 500],
            [['imageFile'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
            [['imageFiles'], 'file', 'extensions' => 'jpg,jpeg,gif,png', 'maxSize'=>20*1024*1024, 'maxFiles'=>10],
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
            'images' => Yii::t('app', 'Images'),
            'intro' => Yii::t('app', 'Intro'),
            'intro_ru' => Yii::t('app', 'Intro'),
            'intro_ko' => Yii::t('app', 'Intro'),
            'text' => Yii::t('app', 'Text (en)'),
            'text_ru' => Yii::t('app', 'Text (ru)'),
            'text_ko' => Yii::t('app', 'Text (ko)'),
            'imageFile' => Yii::t('app', 'Main image'),
            'imageFiles' => Yii::t('app', 'Images'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        return $this->hasMany(Description::className(), ['destination_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasMany(Tour::className(), ['destination_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveImage();
        //$this->optimizeImage();
    }

    protected function saveImage(){
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (Yii::$app->request->serverName=='oktour.loc') {
            Image::$driver = [Image::DRIVER_GD2];
        }

        $model_name=Yii::$app->controller->id;
        if($this->imageFile || $this->imageFiles){
            $dir=Yii::getAlias('@webroot')."/images/{$model_name}/";
            if (!file_exists($dir)) {mkdir($dir);}

            $tosave=$dir.$this->id;
            if (!file_exists($tosave)) {
                mkdir($tosave);
            }

            if($this->imageFile){
                $time=time();
                $extension=$this->imageFile->extension;
                $imageName=$time.'.'.$extension;
                $this->imageFile->saveAs($tosave.'/' . $imageName);

                $imagine=Image::getImagine()->open($tosave.'/'.$imageName);
                $imagine->thumbnail(new Box(1200, 800))->save($tosave.'/'.$imageName);
                $imagine->thumbnail(new Box(400, 300))->save($tosave.'/s_'.$imageName);
                //Image::thumbnail($tosave.'/s_'.$imageName,270, 270)->save($tosave.'/s_'.$imageName);

                Yii::$app->db->createCommand("UPDATE {$model_name} SET image='s_{$imageName}' WHERE id='{$this->id}'")->execute();
            }
            if($this->imageFiles){
                $images=[];
                if($this->images){$images=explode(';',$this->images);}
                foreach($this->imageFiles as $key=>$image)
                {
                    $time=time().rand(1000, 100000);
                    $extension=$image->extension;
                    $imageName=$time.'.'.$extension;

                    $image->saveAs($tosave.'/' . $imageName);
                    $imagine=Image::getImagine()->open($tosave.'/'.$imageName);
                    $imagine->thumbnail(new Box(1500, 1000))->save($tosave.'/' .$imageName);
                    $imagine->thumbnail(new Box(400, 300))->save($tosave.'/s_'.$imageName);
                    //Image::thumbnail($tosave.'/'.$imageName,250, 250)->save($tosave.'/s_'.$imageName);
                    /*if($key==0 && !$this->image){
                        Yii::$app->db->createCommand("UPDATE {$model_name} SET image='{$imageName}' WHERE id='{$this->id}'")->execute();
                    }*/
                    $images[]=$imageName;
                }
                $images_str=implode(';',$images);

                Yii::$app->db->createCommand("UPDATE {$model_name} SET images='{$images_str}' WHERE id='{$this->id}'")->execute();
            }
        }
    }

    protected function optimizeImage(){
        $webroot=Yii::getAlias('@webroot');
        $model_name=Yii::$app->controller->id;
        $folder=$webroot."/images/{$model_name}/".$this->id;
        if(is_dir($folder)){
            $scaned=scandir($folder);
            foreach($scaned as $scan){
                if($scan!='.'&& $scan!='..'){
                    $exp=explode('.',$scan);
                    if(isset($exp[1])){
                        $ext=strtolower($exp[1]);
                        $file=$folder.'/'.$scan;
                        if($ext=='jpg' || $ext=='jpeg'){
                            $command ='jpegoptim '.$file.' --strip-all --all-progressive';
                            shell_exec($command);
                        }
                        elseif($ext=='png'){
                            $command ='optipng '.$file;
                            shell_exec($command);
                        }
                    }
                }
            }
        }
    }
    public function afterDelete(){
        parent::afterDelete();
        $webroot=Yii::getAlias('@webroot');
        $model_name=Yii::$app->controller->id;
        if(is_dir($dir=$webroot."/images/{$model_name}/".$this->id)){
            $scaned_images = scandir($dir, 1);
            foreach($scaned_images as $file )
            {
                if(is_file($dir.'/'.$file)) @unlink($dir.'/'.$file);
            }
            @rmdir($dir);
        }
    }

    public static function getList(){
        return ArrayHelper::map(Destination::find()->select(['id','title'])->asArray()->all(),'id','title');
    }
}
