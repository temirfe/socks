<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Package */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'included')->widget(Widget::className(), [
        'settings' => [
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'not_included')->widget(Widget::className(), [
        'settings' => [
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]); ?>

    <div class="form_wrap wrap_ru">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ru">
            <img src="/images/blank.gif" class="flag flag-ru" alt="Russian" />
            <span class="dotted_link arrow_toggle">Text in Russian</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ru">
            <?= $form->field($model, 'included_ru')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
                    ],
                ],
            ]); ?>

            <?= $form->field($model, 'not_included_ru')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="form_wrap wrap_ko">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ko">
            <img src="/images/blank.gif" class="flag flag-kr" alt="Korean" />
            <span class="dotted_link arrow_toggle">Text in Korean</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ko">
            <?= $form->field($model, 'included_ko')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
                    ],
                ],
            ]); ?>

            <?= $form->field($model, 'not_included_ko')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'tour_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
