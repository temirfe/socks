<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;

?>


<p>
    <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php
    try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'tour_card x-md-33 x-sm-33 x-xs-50'],
            'emptyText' => Yii::t('app', 'No results found'),
            'summary' => '',
            'options' => ['class' => 'flex flex-wrap mr-30 xs-mr-15'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_view', ['tour' => $model]);
            },
        ]);
    } catch (Exception $e) {
    } ?>
    <?php Pjax::end(); ?>
</div>
