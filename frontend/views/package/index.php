<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Packages');
$this->params['breadcrumbs'][] = $this->title;
$dao=Yii::$app->db;
$tourRows = $dao->createCommand("SELECT id,title FROM tour ORDER BY id DESC")->queryAll();
$tours=ArrayHelper::map($tourRows,'id','title');
?>
<div class="package-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Package'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            [
                'attribute'=>'tour_id',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->tour->title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'tour_id', $tours,['class'=>'form-control','prompt' => Yii::t('app','All')]),
            ],
            //'included:ntext',
            //'included_ru:ntext',
            //'included_ko:ntext',
            //'not_included:ntext',
            //'not_included_ru:ntext',
            //'not_included_ko:ntext',
            //'tour_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
