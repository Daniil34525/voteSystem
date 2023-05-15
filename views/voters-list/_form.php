<?php

use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VotersList $model */
/** @var yii\widgets\ActiveForm $form */
/** @var integer[] $userIds */
?>

<div class="voters-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

    <div class="card">
        <?php
        $users = Users::find()->all();
        foreach ($users as $user) {
            $text = in_array($user->id, $userIds) ? 'checked' : '';
            $block = '<div class="card-body" style="display: flex">'
            . '<input type="checkbox" class="checkbox" name="userIds['. $user->id .']"'. $text .'>'
            . '<div style="margin-left: 20px">'
            . '<a href="' . Url::to(['users/view', 'id' => $user->id]) . '">' . $user->middle_name . '</a>'
            . '</div>'
            . '</div>';
            echo $block;
        }
        ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
