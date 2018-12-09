<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class MyModel extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $imageFiles=array();

    public $docFile;
    public $docFiles=array();

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveImage();
        //$this->optimizeImage();
        //$this->saveDoc();
    }

    /*public function afterFind()
    {
        parent::afterFind();
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
            [['imageFiles'], 'file', 'extensions' => 'jpg,jpeg,gif,png', 'maxSize'=>20*1024*1024, 'maxFiles'=>10],
            [['docFile'], 'file', 'extensions' => 'doc,docx,rtf,pdf,xls,xlsx'],
            [['docFiles'], 'file', 'extensions' => 'doc,docx,rtf,pdf,xls,xlsx', 'maxSize'=>20*1024*1024, 'maxFiles'=>10]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => Yii::t('app', 'Image File'),
            'imageFiles' => Yii::t('app', 'Image Files'),
            'docFile' => Yii::t('app', 'Document File'),
            'docFiles' => Yii::t('app', 'Document Files'),
        ];
    }

    protected function saveImage(){
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (Yii::$app->request->serverName=='noski.loc') {
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
                if($model_name=='banner'){
                    $imagine->thumbnail(new Box(1500, 1500))->save($tosave.'/'.$imageName,['quality'=>100]);
                    Image::thumbnail($tosave.'/'.$imageName,1400, 400)->save($tosave.'/'.$imageName,['quality'=>100]);
                }
                else{
                    $imagine->thumbnail(new Box(600, 600))->save($tosave.'/'.$imageName);
                }
                $imagine->thumbnail(new Box(300, 300))->save($tosave.'/s_'.$imageName);
                Image::thumbnail($tosave.'/s_'.$imageName,270, 270)->save($tosave.'/s_'.$imageName);

                Yii::$app->db->createCommand("UPDATE {$model_name} SET image='{$imageName}' WHERE id='{$this->id}'")->execute();
            }
            if($this->imageFiles){
                foreach($this->imageFiles as $image)
                {
                    $time=time().'s'.rand(1, 100);
                    $extension=$image->extension;
                    $imageName=$time.'.'.$extension;

                    $image->saveAs($tosave.'/' . $imageName);
                    $imagine=Image::getImagine()->open($tosave.'/'.$imageName);
                    $imagine->thumbnail(new Box(1500, 1000))->save($tosave.'/' .$imageName);
                    $imagine->thumbnail(new Box(400, 250))->save($tosave.'/s_'.$imageName);
                    //Image::thumbnail($tosave.'/'.$imageName,250, 250)->save($tosave.'/s_'.$imageName);
                    $images[]=$imageName;
                }
                if($model_name=='product'){
                    $images_str=implode(';',$images);
                    $images_str.=';'.$this->images;
                    Yii::$app->db->createCommand("UPDATE {$model_name} SET images='{$images_str}' WHERE id='{$this->id}'")->execute();
                }
            }
        }
    }

    protected function saveDoc(){
        $this->docFile = UploadedFile::getInstance($this, 'docFile');
        $this->docFiles = UploadedFile::getInstances($this, 'docFiles');

        if($this->docFile || $this->docFiles){
            $model_name=Yii::$app->controller->id;
            $dir=Yii::getAlias('@webroot')."/files/{$model_name}/";
            if (!file_exists($dir)) {mkdir($dir);}

            $tosave=$dir.$this->id;
            if (!file_exists($tosave)) {
                mkdir($tosave);
            }

            if($this->docFile){
                $this->docFile->saveAs($tosave.'/'.$this->docFile->name);
                //$this->word_size=round($this->docFile->size/1024,1); //kb
            }
            if($this->docFiles){
                foreach($this->docFiles as $file){
                    $fileName=str_replace(" ","",$file->name);
                    $file->saveAs($tosave.'/' . $fileName);
                }
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
}
