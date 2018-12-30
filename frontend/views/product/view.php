<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\SwiperAsset;
use frontend\assets\PhotoSwipeAsset;
use yii\widgets\ListView;

SwiperAsset::register($this);
PhotoSwipeAsset::register($this);

$webroot=Yii::getAlias('@webroot');
include_once($webroot.'/photoswipe/_swipe.php');

/* @var $this yii\web\View */
/* @var $model frontend\models\Product */
/* @var $relatedProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$imgs=explode(';',$model->images);
?>
<div class="product-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a(Yii::t('app', 'Products'), ['admin'], ['class' => 'btn btn-default pull-right']) ?>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success pull-right mr10 mob_hidden']) ?>
        <?= Html::a('+', ['create'], ['class' => 'btn btn-success pull-right mr10 mob_visible']) ?>
    </p>
    <div class="row mb25">
        <div class="col-sm-12">
            <div class="white_box oh mob_pad_0">
                <?php
                if($imgs){
                    ?>
                    <div class="col-sm-6 view_img_wrap">

                        <?php
                        if(count($imgs)>0){
                            ?>

                            <div class='thumbs_wrap pull-left mob_hidden'>
                                <ul>
                                    <?php
                                    $img_index = 0;
                                    foreach ($imgs as $img){
                                        if($img_index==0){$thumb_class='active_thumb js_prevent_default';}else{$thumb_class='js_open_thumb';}
                                        $thumb=Html::img("@web/images/product/".$model->id.'/s_'.$img,['class'=>'img-responsive js_img']);
                                        echo '<li>'.Html::a($thumb,'#',['class'=>$thumb_class, 'data-big'=>'/images/product/'.$model->id.'/'.$img, 'data-index'=>$img_index]).'</li>';
                                        $img_index++;
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="real_img_wrap swiper-container" data-count="<?=count($imgs)?>">
                            <!--<div class='abs open_gallery'><?/*=Html::a("<span class='glyphicon glyphicon-zoom-in'></span>", '#', ['class' => 'js_photo_swipe', 'data-index' => '0']);*/?></div>-->
                            <div class="swiper-wrapper">
                                <?php
                                foreach($imgs as $img){
                                    echo Html::img('/images/product/'.$model->id.'/'.$img,['class'=>'img-responsive swiper-slide js_img_swiper_item']);
                                }
                                ?>
                            </div>
                            <div class="swiper-pagination mob_visible"></div>
                            <div class="swiper-button-next mob_hidden"></div>
                            <div class="swiper-button-prev mob_hidden"></div>
                        </div>

                    </div>
                    <?php
                }
                ?>

                <div class="col-sm-6">
                    <h2 class="mt0 mob_mt_25 mob_mb_20 mob_bold"><?= Html::encode($this->title) ?></h2>
                    <?php if($model->price){echo Html::tag('h1 ',$model->price. ' сом');}?>
                    <?=$model->description?>
                </div>
            </div>
        </div>
    </div>


    <div class="clear mb25 oh mt20"></div>
    <?php
        if($related_count=$relatedProvider->getTotalCount())
        {
            ?>
            <h2>Похожие товары</h2>
            <div class="swiper-container related-container related_swiper" data-count="<?=$related_count?>">
                <?php
                try {
                    echo ListView::widget([
                        'dataProvider' => $relatedProvider,
                        'itemOptions' => ['class' => 'oh mb20 gridbox swiper-slide'],
                        'emptyText' => Yii::t('app', 'No results found'),
                        'summary' => '',
                        'options' => ['class' => "item-view swiper-wrapper"],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('/product/_view', ['model' => $model]);
                        },
                    ]);
                } catch (Exception $e) {
                } ?>
                <div class="swiper-pagination"></div>
            </div>
    <?php
        }

        ?>

</div>

<div style="overflow: hidden; height:1px;">
    <?php
    //so that photoswiper knows size of each big image
    foreach ($imgs as $img){
        echo Html::img("@web/images/product/".$model->id.'/'.$img,['class'=>'img-responsive']);
    }
    ?>
</div>
