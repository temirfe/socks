<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\models\Lookup;

$lookups = Yii::$app->cache->getOrSet('lookup', function () {
    return Lookup::find()->all();
}, 0);
$phone='';$email='';$fa_email='';$fa_phone=''; $slogan='';
foreach($lookups as $lookup){
    if($lookup->title=='phone'){
        $phones=explode(',',$lookup->text);
        foreach($phones as $ph){
            $phone.="<a href='tel:".preg_replace("/[^\+\d]/", "", $ph)."'>".$ph."</a>";
            $fa_phone.="<a href='tel:".preg_replace("/[^\+\d]/", "", $ph)."'><span class='fas fa-phone mr5'></span></a>";
        }
    }
    else if($lookup->title=='email'){
        $emails=explode(',',$lookup->text);
        foreach($emails as $em){
            $email.="<a href='mailto:".$em."'>".$em."</a>";
            $fa_email="<a href='mailto:".$em."'><span class='fas fa-envelope mr5'></span></a>";
        }
    }
    else if($lookup->title=='slogan'){
        $slogan=' - '.$lookup->text;
    }
}
