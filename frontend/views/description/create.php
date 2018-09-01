<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Description */

$this->title = Yii::t('app', 'Create Description');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Descriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="description-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
