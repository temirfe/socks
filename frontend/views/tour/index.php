<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\Category;
use frontend\models\Destination;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TourSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tours');
$this->params['breadcrumbs'][] = $this->title;
$categories = Yii::$app->cache->getOrSet('category', function () {
    return Category::find()->all();
}, 0);
$destinations = Yii::$app->cache->getOrSet('destination', function () {
    return Destination::find()->all();
}, 0);
$ctgs=ArrayHelper::map($categories,'id','title');
$dsts=ArrayHelper::map($destinations,'id','title');
?>
<div class="tour-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tour'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            'title',
            //'title_ru',
            //'title_ko',
            //'description:ntext',
            //'description_ru:ntext',
            //'description_ko:ntext',
            'days',
            [
                'attribute'=>'category_id',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->category->title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'category_id', $ctgs,['class'=>'form-control','prompt' => Yii::t('app','All')]),
            ],
            [
                'attribute'=>'destination_id',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->destination->title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'destination_id', $dsts,['class'=>'form-control','prompt' => Yii::t('app','All')]),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{addPrice} &nbsp;{view}&nbsp; {update}&nbsp; {delete}',
                'buttons' => [
                    'addPrice' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-plus-sign"></span>',
                            ['price/create', 'tour_id' => $model->id],
                            [
                                'title' => 'Add price',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
