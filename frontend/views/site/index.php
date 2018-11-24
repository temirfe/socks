<?php

/* @var $this yii\web\View */
/* @var $slogan string from Lookup */

use yii\helpers\Html;
use frontend\assets\SwiperAsset;
$frontend=Yii::getAlias('@frontend');
require_once($frontend.'/views/layouts/_lookups.php');
SwiperAsset::register($this);

$this->title = 'Prestige Socks'.$slogan;
$alias=Yii::getAlias('@web');
//$banner=Html::img($file,['class'=>'img-responsive']);
$lang=Yii::$app->language;
$dao=Yii::$app->db;
$banners=Yii::$app->db->createCommand("SELECT * FROM banner WHERE `type`=0 AND `public`=1 ORDER BY weight DESC")->queryAll();
?>
<div class="site-index">

    <?php
    if($banners){
        ?>
        <div class="banner-container swiper-container" data-count="<?=count($banners)?>">
            <div class="swiper-wrapper">
                <?php
                foreach($banners as $banner){
                    ?>
                    <div class="swiper-slide">
                        <?php $img=Html::img('/images/banner/'.$banner['id'].'/'.$banner['image']);
                        echo $img;
                        if($banner['title']){
                            echo Html::tag('div',$banner['title'],['class'=>'banner_text']);
                        }
                        if($link=$banner['link']){
                            echo Html::a(Html::tag('span','',['class'=>'false_link']),$link);
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <?php
    }
    ?>

    <div class="body-content container">
        <h2 class="text-center mb25"><?=Yii::t('app','Destinations')?></h2>
        <div class="flex flex-wrap mr-8">

        </div>
        <h2 class="text-center mb25 mt35"><?=Yii::t('app','Adventures');?></h2>
        <div class="xrow">
        </div>

        <h2 class="text-center mb25 mt35"><?=Yii::t('app','Tours')?></h2>
        <div class="flex flex-wrap mr-30 xs-mr-15">
        </div>
    </div>
</div>
