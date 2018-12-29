<?php

use yii\helpers\Html;
use frontend\models\Product;

/* @var $this yii\web\View */
/* @var $model frontend\models\Product */

$img=Product::getImg($model->images);
?>
<div class="pull-left box product_box rel">
    <div class="box_img_wrap"><img src="/images/product/<?=$model->id?>/s_<?=$img?>" class="img-responsive"></div>
    <div class="box_title"><?=$model->title?></div>
    <?php
    if($model->price){
        echo Html::tag('div',$model->price.' сом');
    }
    ?>
    <?=Html::a("<span class='false_link'></span>",['/product/view','id'=>$model->id])?>
</div>
