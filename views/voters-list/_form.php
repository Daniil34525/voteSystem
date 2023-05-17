<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VotersList $model */
/** @var yii\widgets\ActiveForm $form */
?>
    <div class="voters-list-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

        <div class="card">
            <label for="choice">Выбор типа пользователя</label><select id="choice">
                <option value="default" disabled <?= $model->status == null ? 'selected' : '' ?>>
                    Выберите тип пользователя
                </option>
                <option value="users">Пользователь</option>
                <option value="hiddens">Анонимный пользователь</option>
            </select>
        </div>
        <div class="card" id="userChoice"></div>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$urlUser = Url::to(['users/choice-user']);
$urlHiddens = Url::to(['hiddens/choice-hiddens']);
$modelId = $model->id;
$status = $model->status;
$js = <<<JS
$(document).ready(function() {
    let choice = $('#choice');
    choice.val('$status');
    choice.trigger('change');
});
$('#choice').on('change', function() {
    if($(this).val() === 'users')
        createContent('$urlUser');
    else
        createContent('$urlHiddens')
});

function createContent(url) {
    $.get(url, {'votersListId': '$modelId'}, function(data) {
        if(data.result === 'ok'){
            let output = '';
            data.data.forEach(function(item) {
                output += '<div class="card-body" style="display: flex">'
            + '<input type="checkbox" class="checkbox" name="' + item.name + '[' + item.id + ']"' + item.isChecked + '>'
            + '<div style="margin-left: 20px">';
            if(url in item) output += '<a href="' + item.url + '">' + item.title + '</a>';
            else output += item.title;
            output += '</div></div>';
            })
        $('#userChoice').html(output);
        }
    })
}
JS;
$this->registerJs($js, $this::POS_READY);
