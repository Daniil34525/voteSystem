<?php

use app\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var LoginForm $model
 * @var ActiveForm $form
 */
?>
<h1>Login</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'code')->textInput(['autofocus' => true]) ?>

<div class="form-group" style="padding-top: 10px;">
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
