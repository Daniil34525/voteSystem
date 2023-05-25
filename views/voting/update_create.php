<?php

/** @var yii\web\View $this
 * @var Votings $model
 */

use app\models\VotersList;
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
        $checked_bulletins = BulletinsList::find()->select(['bulletin_id'])->where(['voting_id' => $model->id])->column();

        echo "<p style='margin-top:10px;'> Выбирите бюллетень(-ни): </p>";

        foreach ($bulletins as $key => $value) {
            echo "<input type='checkbox' id='bulletin[" . $key . "]' name='bulletins[" . $key . "]' value='$key' " .
                ((in_array($key, $checked_bulletins)) ? 'checked' : '') . ">" .
                "<lable for='bulletin[$key]'> <a href='/bulletins/view?id=$key'>$value</a> </lable><br/>";
        }

        echo "<p style='margin-top:10px;'> Выбирите список избирателей: </p>";
        $userLists = VotersList::find()->orderBy(['id' => SORT_DESC])->all();
        foreach ($userLists as $list) {
            $array[$list->id] = $list->title;
        }?>
        <?= $form->field($model, 'voters_list_id')->dropDownList($array); ?>
        <?= Html::activeHiddenInput($model, 'id') ?>
        <div class="form-group" style='margin-top:10px;'>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>