<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\SwiperAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Destination */
/* @var $dataProvider yii\data\ActiveDataProvider */

SwiperAsset::register($this);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Destinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$isAdmin=Yii::$app->user->can('userIndex');
?>
<div class="destination-view">
    <p class="pull-right mr5a">
        <?php
        if($isAdmin){
            echo Html::a(Yii::t('app', 'Add tour'), ['tour/create', 'destination_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-sm btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if($model->images){
        $banners=explode(';',$model->images);
        if(count($banners)>1){
            ?>
            <div class="country_swiper swiper-container mb20" data-count="<?=count($banners)?>">
                <div class="swiper-wrapper">
                    <?php
                    foreach($banners as $banner){
                        echo "<div class='swiper-slide'>".Html::img('/images/destination/'.$model->id.'/'.$banner)."</div>";
                    }
                    ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <?php
        }
        else echo "<div class='swiper-container country_banner mb20'>".Html::img('/images/destination/'.$model->id.'/'.$model->images,['class'=>'img-responsive'])."</div>";
    }
    ?>

    <div class="country_desc readable">
        <?=$model->text?>
    </div>

    <h2 class="text-center mb25 mt35">Tours</h2>
    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'tour_card col-sm-4 col-xs-6'],
        'emptyText' => Yii::t('app', 'No results found'),
        'summary'=>'',
        'options'=>['class'=>'item-view row'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('/tour/_view',['tour' => $model]);
        },
    ]) ?>

</div>
