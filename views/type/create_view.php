<?php
/** @var yii\web\View $this
 * @var Type $model
 */

use app\models\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$attribute = $model->title;
$isActionView = (Yii::$app->controller->action->id == 'view');
?>

<div class="card" style="margin-bottom: 0">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'form-one-field-model',
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>

        <?php $label = $model->getAttributeLabel($attribute) ?>
        <?php $input = Html::activeTextInput($model, $attribute, ['class' => 'form-control']) ?>

        <?= Html::activeHiddenInput($model, 'id') ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
