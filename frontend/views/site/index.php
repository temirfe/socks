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
$banners=$dao->createCommand("SELECT * FROM banner WHERE `type`=0 AND `public`=1 ORDER BY weight DESC")->queryAll();
$categories=$dao->createCommand("SELECT * FROM category WHERE `parent_id` IS NULL AND `public`=1 ORDER BY weight DESC")->queryAll();
/*$socks=$dao->createCommand("SELECT * FROM product WHERE `category_id`=1 AND `public`=1 ORDER BY id DESC LIMIT 4")->queryAll();
$underwear=$dao->createCommand("SELECT * FROM product WHERE `category_id`=3 AND `public`=1 ORDER BY id DESC LIMIT 4")->queryAll();
$singlets=$dao->createCommand("SELECT * FROM product WHERE `category_id`=2 AND `public`=1 ORDER BY id DESC LIMIT 4")->queryAll();*/
?>
<style type="text/css">
    .mynav {margin-bottom:0; }
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
                            $bdesc='';
                            $btitle="<div>".$banner['title']."</div>";
                            if($banner['description']){
                                $bdesc=Html::tag('span',$banner['description']);
                            }
                            echo Html::tag('div',$btitle.$bdesc,['class'=>'banner_text']);
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

    <div class="ctg_menu oh">
        <?php
        foreach($categories as $category){
            $img=Html::img('/images/category/'.$category['id'].'/'.$category['image'],['class'=>'img-responsive']);
            $link=['/product/index','category_id'=>$category['id']];
            $img_link=Html::a($img,$link);
            $title_link=Html::a($category['title'],$link);
            $title_div=Html::tag('div',$title_link,['class'=>'ctg_box_title']);

            if($category['has_product']){$soon='';}
            else{
                $soon=Html::tag('div','Скоро..',['class'=>'soon']);
            }

            echo Html::beginTag('div',['class'=>'col-sm-4']);
            echo Html::tag('div',$img_link.$soon,['class'=>'ctg_box_img_wrap oh']);
            echo Html::tag('div',$title_div,['class'=>'ctg_box_info mb20  oh']);
            echo Html::endTag('div');
            ?>
            <?php
        }
        ?>
    </div>
</div>
