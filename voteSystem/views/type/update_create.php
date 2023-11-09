<?php
/** @var yii\web\View $this
 * @var Type $model
 */

use app\models\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/types.css'); 

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

        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Введите наименование']) ?>
        <?= Html::activeHiddenInput($model, 'id') ?>
        <div id="save" class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
