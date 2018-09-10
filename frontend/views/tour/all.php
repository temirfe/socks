<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TourSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tours');
$this->params['breadcrumbs'][] = $this->title;
$isAdmin=Yii::$app->user->can('userIndex');
?>
<div class="tour-index">
    <p class="pull-right">
        <?php if($isAdmin) echo Html::a(Yii::t('app', 'Create Tour'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'tour_card col-sm-4 col-xs-6'],
        'emptyText' => Yii::t('app', 'No results found'),
        'summary'=>'',
        'options'=>['class'=>'item-view row'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_view',['tour' => $model]);
        },
    ]) ?>
    <?php Pjax::end(); ?>
</div>
