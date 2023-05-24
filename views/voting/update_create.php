<?php

/** @var yii\web\View $this
 * @var Votings $model
 */

use app\models\Votings;
use app\models\BulletinsList;
use app\models\Bulletins;
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

         <?php

        // Получение списка всех бюллетений:
        $bulletins = Bulletins::get_list_items();

        // Получения списка бюллетений из bulletins_list для текущего голосования (если они уже были выбраны; в случае обновления)
        $checked_bulletins = BulletinsList::find()->select(['bulletin_id'])->where(['voting_id' => $model->id ])->column();
        
        echo "<p style='margin-top:10px;'> Вибирите бюллетень(-ни): </p>";
       
        for($i = 1; $i <= count($bulletins); $i++) {
            if (in_array($i, $checked_bulletins)){
                echo "<input type='checkbox' id='$i' name='bulletins[$i]' value='$i' checked>";
            }else {
                echo "<input type='checkbox' id='$i' name='bulletins[$i]' value='$i'>";
            }
            echo "<lable for='$i'> $bulletins[$i] </lable><br/>";
        }
        ?> 

        <?= Html::activeHiddenInput($model, 'id') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>