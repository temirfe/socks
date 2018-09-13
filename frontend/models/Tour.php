<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "tour".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_ko
 * @property string $images
 * @property string $slug
 * @property string $description
 * @property string $description_ru
 * @property string $description_ko
 * @property int $days
 * @property int $category_id
 * @property int $destination_id
 *
 * @property Price[] $prices
 * @property Day[] $day
 * @property Category $category
 * @property Destination $destination
 * @property Package $package
 */
class Tour extends \yii\db\ActiveRecord
{
    public $imageFiles=array();
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description', 'description_ru', 'description_ko','slug'], 'string'],
            [['days', 'category_id', 'destination_id'], 'integer'],
            [['title', 'title_ru', 'title_ko'], 'string', 'max' => 255],
            [['images'], 'string', 'max' => 500],
            [['imageFiles'], 'file', 'extensions' => 'jpg,jpeg,gif,png', 'maxSize'=>20*1024*1024, 'maxFiles'=>10],
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
            'images' => Yii::t('app', 'Images'),
            'description' => Yii::t('app', 'Description En'),
            'description_ru' => Yii::t('app', 'Description Ru'),
            'description_ko' => Yii::t('app', 'Description Ko'),
            'days' => Yii::t('app', 'Days'),
            'category_id' => Yii::t('app', 'Category'),
            'destination_id' => Yii::t('app', 'Destination'),
            'imageFiles' => Yii::t('app', 'Images'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['tour_id' => 'id']);
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
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['tour_id' => 'id']);
    }
    public function getDay()
    {
        return $this->hasMany(Day::className(), ['tour_id' => 'id']);
    }
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveImage();
        //$this->optimizeImage();
    }
    function beforeSave($insert)
    {
        $this->slug=Tour::slugify($this->title);
        return parent::beforeSave($insert);
    }

    protected function saveImage(){
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (Yii::$app->request->serverName=='oktour.loc') {
            Image::$driver = [Image::DRIVER_GD2];
        }

        $model_name=Yii::$app->controller->id;
        if($this->imageFiles){
            $dir=Yii::getAlias('@webroot')."/images/{$model_name}/";
            if (!file_exists($dir)) {mkdir($dir);}

            $tosave=$dir.$this->id;
            if (!file_exists($tosave)) {
                mkdir($tosave);
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
                    $imagine->thumbnail(Page::myBox(400, 225,$imagine->getSize()))->save($tosave.'/s_'.$imageName);
                    Image::thumbnail($tosave.'/s_'.$imageName,400, 225)->save($tosave.'/s_'.$imageName);
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
        return ArrayHelper::map(Tour::find()->select(['id','title'])->asArray()->all(),'id','title');
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function afterFind()
    {
        parent::afterFind();
        $curLang=Yii::$app->language;
        if(Yii::$app->controller->action->id!='update'){
            if($curLang=='ru-RU'){
                $this->title=$this->title_ru;
                $this->description=$this->description_ru;
            }
            else if($curLang=='ko-KR'){
                $this->title=$this->title_ko;
                $this->description=$this->description_ko;
            }
        }
    }
    public function getImage($size='s_',$class=''){
        if($this->images){
            $images=explode(';',$this->images);
            $image=Html::img('/images/tour/'.$this->id.'/'.$size.$images[0],['class'=>$class]);
        }
        else $image='';
        return $image;
    }

    public function getIntro(){
        return StringHelper::truncate($this->description,255,'...');
    }

    public function getLowestPrice(){
        $pr=0;
        foreach($this->prices as $price){
            if($price->price){
                if($pr && $price->price<$pr){
                    $pr=$price->price;
                }
                else{$pr=$price->price;}
                if($price->currency=='usd'){$pr='$'.$pr;}
                else {$pr=$pr.' '.strtoupper($price->currency);}
            }
        }
        return $pr;
    }
}
