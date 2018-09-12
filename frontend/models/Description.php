<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "category_desc".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 * @property string $image
 * @property string $intro
 * @property string $intro_ru
 * @property string $intro_ko
 * @property string $description
 * @property string $description_ru
 * @property string $description_ko
 * @property int $category_id
 * @property int $destination_id
 *
 * @property Category $category
 * @property Destination $destination
 */
class Description extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_desc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description', 'description_ru', 'description_ko'], 'string'],
            [['category_id', 'destination_id'], 'integer'],
            [['title', 'title_ru', 'title_ko'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],
            [['intro', 'intro_ru', 'intro_ko'], 'string', 'max' => 500],
            [['imageFile'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destination::className(), 'targetAttribute' => ['destination_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title En'),
            'title_ru' => Yii::t('app', 'Title Ru'),
            'title_ko' => Yii::t('app', 'Title Ko'),
            'image' => Yii::t('app', 'Image'),
            'intro' => Yii::t('app', 'Intro'),
            'intro_ru' => Yii::t('app', 'Intro Ru'),
            'intro_ko' => Yii::t('app', 'Intro Ko'),
            'description' => Yii::t('app', 'Description'),
            'description_ru' => Yii::t('app', 'Description Ru'),
            'description_ko' => Yii::t('app', 'Description Ko'),
            'category_id' => Yii::t('app', 'Category'),
            'destination_id' => Yii::t('app', 'Destination'),
            'imageFile' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(Destination::className(), ['id' => 'destination_id']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveImage();
        //$this->optimizeImage();
        Yii::$app->cache->delete('descriptions'.$this->category_id);
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
                $imagine->thumbnail(new Box(1200, 800))->save($tosave.'/'.$imageName);
                $imagine->thumbnail(Page::myBox(400, 225,$imagine->getSize()))->save($tosave.'/s_'.$imageName);
                Image::thumbnail($tosave.'/s_'.$imageName,400, 225)->save($tosave.'/s_'.$imageName);

                Yii::$app->db->createCommand("UPDATE category_desc SET image='{$imageName}' WHERE id='{$this->id}'")->execute();
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

    function afterFind()
    {
        parent::afterFind();
        $curLang=Yii::$app->language;
        if($curLang=='ru-RU'){
            $this->title=$this->title_ru;
            $this->intro=$this->intro_ru;
            $this->description=$this->description_ru;
        }
        else if($curLang=='ko-KR'){
            $this->title=$this->title_ko;
            $this->intro=$this->intro_ko;
            $this->description=$this->description_ko;
        }
    }
}
