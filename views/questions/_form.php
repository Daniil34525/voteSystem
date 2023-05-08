<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\QuestionTypes; 
use app\models\Bulletins;

/** @var yii\web\View $this */
/** @var app\models\Questions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bulletin_id')->dropDownList(Bulletins::get_list_items()); ?>

    <?= $form->field($model, 'overview')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(QuestionTypes::get_list_items()); ?>

    <?= $form->field($model, 'answer')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
