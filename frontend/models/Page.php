<?php

namespace frontend\models;

use Imagine\Image\BoxInterface;
use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\caching\TagDependency;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 * @property string $category
 * @property string $text
 * @property string $text_ru
 * @property string $text_ko
 * @property string $image
 */
class Page extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['title', 'title_ru', 'title_ko', 'category', 'text', 'text_ru', 'text_ko', 'image'], 'required'],
            [['text', 'text_ru', 'text_ko'], 'string'],
            [['title', 'title_ru', 'title_ko', 'image'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 20],
            [['imageFile'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
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
            'category' => Yii::t('app', 'Category'),
            'text' => Yii::t('app', 'Text'),
            'text_ru' => Yii::t('app', 'Text Ru'),
            'text_ko' => Yii::t('app', 'Text Ko'),
            'image' => Yii::t('app', 'Image'),
            'imageFile' => Yii::t('app', 'Image'),
        ];
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveImage();
        if($this->category=='main'){Yii::$app->cache->delete('page-main');}
        //$this->optimizeImage();
    }
    protected function saveImage(){
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if (Yii::$app->request->serverName=='oktour.loc') {
            Image::$driver = [Image::DRIVER_GD2];
        }

        $model_name=Yii::$app->controller->id;
        if($this->imageFile){
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
                $imagine->thumbnail(new Box(1500, 800))->save($tosave.'/'.$imageName);
                //$imagine->thumbnail(new Box(400, 300))->save($tosave.'/s_'.$imageName);
                $imagine->thumbnail(self::myBox(400, 225,$imagine->getSize()))->save($tosave.'/s_'.$imageName);
                Image::thumbnail($tosave.'/s_'.$imageName,400, 225)->save($tosave.'/s_'.$imageName);

                Yii::$app->db->createCommand("UPDATE {$model_name} SET image='{$imageName}' WHERE id='{$this->id}'")->execute();
            }
        }
    }

    public static function myBox( $targetWidth, $targetHeight, BoxInterface $orgSize)
    {
        // Box is Imagine Box instance
        if ($orgSize->getWidth() > $orgSize->getHeight()) {
            // Landscaped.. We need to crop image by horizontally
            $w = round($orgSize->getWidth() * ( $targetHeight / $orgSize->getHeight() ));
            $h =  $targetHeight;
            if($w<$targetWidth){
                $h=round(($targetHeight*$targetWidth)/$w);
                $w=$targetWidth;
            }
        } else {
            // Portrait..
            $w = $targetWidth; // Use target box's width and crop vertically
            $h = round($orgSize->getHeight() * ( $targetWidth / $orgSize->getWidth() ));
            if($h<$targetHeight){
                $w=round(($targetHeight*$targetWidth)/$h);
                $h=$targetHeight;
            }
        }

        return new Box($w, $h);
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

    function afterFind()
    {
        parent::afterFind();
        $curLang=Yii::$app->language;
        if(Yii::$app->controller->action->id!='update'){
            if($curLang=='ru-RU'){
                $this->title=$this->title_ru;
                $this->text=$this->text_ru;
            }
            else if($curLang=='ko-KR'){
                $this->title=$this->title_ko;
                $this->text=$this->text_ko;
            }
        }
    }
}
