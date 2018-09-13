<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Category */

?>

<table class="table table-condensed">
    <tr>
        <th>Country</th>
        <th>Title</th>
        <th></th>
    </tr>
    <?php
    foreach($model->descriptions as $desc){
        echo "<tr>";
        echo "<td width='120'>".$desc->destination->title."</td>";
        echo "<td>".$desc->title."</td>";
        echo "<td class='text-right'>";
        echo Html::a(Yii::t('app','Update'),['/description/update','id'=>$desc->id],['class'=>'font12 mr5']);
        echo Html::a(Yii::t('app','Delete'),['/description/delete','id'=>$desc->id],[
                'class'=>'font12 red2',
                'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post']
                ]);
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

