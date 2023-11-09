<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\RoleTypes;

/** @var yii\web\View $this
 * @var app\models\Users $model
 * @var yii\widgets\ActiveForm $form
 * @var bool $isGuest
 */
$isGuest = is_null($isGuest) ? true : $isGuest;
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_type_id')->dropDownList(RoleTypes::get_list_items(), $isGuest ? ['disabled' => 'disabled'] : []); ?>

    <?php
    if ($isGuest)
        echo $form->field($model, 'role_type_id')->hiddenInput(['value' => 2])->label(false);
    ?>

    <div class="form-group" style="padding-top: 10px;">
        <?= Html::submitButton($isGuest ? 'Зарегистрироваться' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
