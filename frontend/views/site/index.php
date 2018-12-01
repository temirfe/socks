<?php

/* @var $this yii\web\View */
/* @var $slogan string from Lookup */

use yii\helpers\Html;
use frontend\assets\SwiperAsset;
use frontend\models\Product;

$frontend=Yii::getAlias('@frontend');
require_once($frontend.'/views/layouts/_lookups.php');
SwiperAsset::register($this);

$this->title = 'Prestige Socks'.$slogan;
$alias=Yii::getAlias('@web');
//$banner=Html::img($file,['class'=>'img-responsive']);
$lang=Yii::$app->language;
$dao=Yii::$app->db;
$banners=Yii::$app->db->createCommand("SELECT * FROM banner WHERE `type`=0 AND `public`=1 ORDER BY weight DESC")->queryAll();
$socks=Yii::$app->db->createCommand("SELECT * FROM product WHERE `category_id`=1 AND `public`=1 ORDER BY id DESC")->queryAll();
?>
<style type="text/css">
    .the_logo_wrap {
        background-color: #ee1c25;
    }
    .mynav {
        margin-bottom: 0;
    }
</style>
<div class="site-index">

    <?php
    if($banners){
        ?>
        <div class="banner-container swiper-container mb20" data-count="<?=count($banners)?>">
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
        <div class="flex flex-wrap mr-8">
            <?php
                foreach($socks as $sock){
                    $img=Product::getImg($sock['images']);
                    ?>
                    <div class="pull-left box">
                        <div class="box_img_wrap"><img src="/images/product/<?=$sock['id']?>/s_<?=$img?>" class="img-responsive"></div>
                        <div class="box_title"><?=$sock['title']?></div>
                        <div class="box_price"><?=$sock['price']?> сом</div>
                    </div>
            <?php
                }
            ?>
        </div>

        <!--<h2 class="text-center mb25 mt35"><?/*=Yii::t('app','Underwear');*/?></h2>-->

    </div>
</div>
