<?php
/** @var yii\web\View $this
 * @var Type $model
 */

use app\models\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = $title; 
$this->params['breadcrumbs'][] = ['label' => $title, 'url' => ['index']];
$this->params['breadcrumbs'][] = "Создание";
?>

<div class="card" style="margin-bottom: 0">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'type-model',
            // 'options' => ['enctype' => 'multipart/form-data']
        ]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= Html::activeHiddenInput($model, 'id') ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
