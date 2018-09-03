<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Day */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Days'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="day-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'title_ru',
            'title_ko',
            'itinerary:ntext',
            'itinerary_ru:ntext',
            'itinerary_ko:ntext',
            'meals',
            'meals_ru',
            'meals_ko',
            'accommodation',
            'accommodation_ru',
            'accommodation_ko',
            'tour_id',
        ],
    ]) ?>

</div>
