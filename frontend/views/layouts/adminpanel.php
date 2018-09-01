<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<div class="admin_panel">
    <div class="container">
        <?php
        echo Html::a('Users','/user');
        echo Html::a('Countries','/destination');
        echo Html::a('Tour types','/category');
        echo Html::a('Tours','/tour');
        echo Html::a('Prices','/price');
        echo Html::a('Pages','/page');
        ?>
    </div>
</div>
