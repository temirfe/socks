<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Descriptions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="description-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Description'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'title_ru',
            'title_ko',
            'image',
            //'intro',
            //'intro_ru',
            //'intro_ko',
            //'description:ntext',
            //'description_ru:ntext',
            //'description_ko:ntext',
            //'category_id',
            //'destination_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
