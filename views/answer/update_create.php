<?php
/** @var Answers $model */

use app\models\Answers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="card" style="margin-bottom: 0">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'answer-model',
        ]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= Html::activeHiddenInput($model, 'question_id') ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
