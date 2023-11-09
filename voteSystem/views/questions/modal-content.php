<?php
/** @var Answers $model */

use app\models\Answers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'modal-form']); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= Html::activeHiddenInput($model, 'question_id') ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
