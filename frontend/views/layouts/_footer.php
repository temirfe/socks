<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\models\Lookup;

$lookups = Yii::$app->cache->getOrSet('lookup', function () {
    return Lookup::find()->all();
}, 0);
?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-xs-12">
                <ul class="fa-ul">
                    <?php
                    foreach($lookups as $lookup){
                        if($lookup->text && in_array($lookup->title,['phone','email','address'])){
                            if($lookup->title=='address'){$fas='map-marker-alt';$ftitle=Html::a($lookup->text,'https://2gis.kg/search/'.$lookup->text,['target'=>'_blank']);}
                            else if($lookup->title=='phone'){$fas='phone';$ftitle=Html::a($lookup->text,'tel:'.$lookup->text);}
                            else if($lookup->title=='email'){$fas='at';$ftitle=Html::a($lookup->text,'mailto:'.$lookup->text);}
                            echo "<li><span class='fa-li'><i class='fas fa-{$fas} fa-lg'></i></span>".$ftitle."</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm-4 col-xs-12">
                <ul class="fa-ul">
                    <?php
                    foreach($lookups as $lookup){
                        if($lookup->text && in_array($lookup->title,['instagram','youtube','twitter','facebook'])){
                            if($lookup->title=='instagram'){$ftitle=Html::a(ucfirst($lookup->title),'https://instagram.com/'.$lookup->text,['target'=>'_blank']);}
                            else if($lookup->title=='youtube'){$ftitle=Html::a(ucfirst($lookup->title),'https://youtube.com/user/'.$lookup->text,['target'=>'_blank']);}
                            else if($lookup->title=='facebook'){$ftitle=Html::a(ucfirst($lookup->title),'https://facebook.com/'.$lookup->text,['target'=>'_blank']);}
                            else if($lookup->title=='twitter'){$ftitle=Html::a(ucfirst($lookup->title),'https://twitter.com/'.$lookup->text,['target'=>'_blank']);}

                            echo "<li><span class='fa-li'><i class='fab fa-{$lookup->title} fa-lg'></i></span>".$ftitle."</li>";
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="col-sm-4 col-xs-12">
                <?=Html::img('/images/ok_logo_white.png',['class'=>'logo_footer'])?>
                <?php
                if(!$user->id){echo Html::a(Yii::t('app','Log in'),['/site/login']);}

                ?>
            </div>
        </div>
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </div>
</footer>
