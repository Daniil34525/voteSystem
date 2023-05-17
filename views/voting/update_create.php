<?php
/** @var yii\web\View $this
 * @var Votings $model
 */

use app\models\Votings;
use app\models\VotingTypes;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = "Создание голосования";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card" style="margin-bottom: 0">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'voting-model',
        ]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'voting_type_id')->dropDownList(VotingTypes::get_list_items()); ?>
        <?= Html::activeHiddenInput($model, 'id') ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
