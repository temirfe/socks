<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(Yii::$app->user->can('adminAction')){
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary mr10']);

            echo Html::a(Yii::t('app', 'Update password'), ['update-password', 'id' => $model->id], ['class' => 'btn btn-primary mr10']);

            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
         ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'username',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    'email:email',
                    //'status',
                    [
                        'attribute'=>'created_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->created_at);
                        },
                    ],
                    [
                        'attribute'=>'updated_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->updated_at);
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
