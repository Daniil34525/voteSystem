<?php

use app\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var LoginForm $model
 * @var ActiveForm $form
 */

$this->registerCssFile('@web/css/login.css')
?>

<div class='login'>
    <a href="/site/login"> <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="m9 14l-4-4l4-4" />
                <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
            </g>
        </svg>
    </a>
    <h1> Авторизация</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['class' => 'form-control', 'autofocus' => true, 'placeholder' => 'Ключ-пароль'])->label('') ?>

    <div class="form-group" style="padding-top: 10px;">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>