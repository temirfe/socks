<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use frontend\models\Destination;

/* @var $this yii\web\View */
/* @var $model frontend\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isAdmin=Yii::$app->user->can('userIndex');

?>
<div class="category-view">
    <p class="pull-right mr5a xs-block">
        <?php
        if($isAdmin){
            echo Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-default']);
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

    <h1 class="container"><?= Html::encode($this->title) ?></h1>

</div>
