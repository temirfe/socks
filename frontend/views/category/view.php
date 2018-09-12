<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isAdmin=Yii::$app->user->can('userIndex');

/*$descs= Yii::$app->cache->getOrSet('descriptions'.$model->id, function () use($model) {
    return $model->descriptions;
}, 0);

foreach($descs as $desc){
    echo 'adf'.$desc->title."<br />";
}*/
?>
<div class="category-view">
    <p class="pull-right mr5a">
        <?php
        if($isAdmin){
            echo Html::a(Yii::t('app', 'Add tour'), ['tour/create', 'category_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
            echo Html::a(Yii::t('app', 'Add description'), ['description/create', 'category_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
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
