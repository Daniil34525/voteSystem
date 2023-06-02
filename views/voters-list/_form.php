<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/create_voters.css')
/** @var yii\web\View $this */
/** @var app\models\VotersList $model */
/** @var yii\widgets\ActiveForm $form */
?>
    <div class="voters-list-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id')->hiddenInput(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

        <div class="card" id="first">
            <label for="choice">Выбор типа пользователя</label>
            <select id="choice" class="form-select">
                <option value="default" disabled <?= $model->status == null ? 'selected' : '' ?>>
                    Выберите тип пользователя
                </option>
                <option value="users">Пользователь</option>
                <option value="hiddens">Анонимный пользователь</option>
            </select>
        </div>
        <div class="card" id="userChoice">
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

    </div>
<?php
$urlUser = Url::to(['users/choice-user']);
$urlHiddens = Url::to(['hiddens/choice-hiddens']);
$modelId = $model->id;
$status = $model->status;
$urlCreateHiddens = Url::to(['/hiddens/create-hiddens-for-voters-list']);
$js = <<<JS
$(document).ajaxStart(function() {
  $('#loader').show();
});

// Скройте анимацию загрузки после завершения AJAX-запроса
$(document).ajaxStop(function() {
  $('#loader').hide();
});

$(document).ready(function() {
    let choice = $('#choice');
    choice.val('$status');
    choice.trigger('change');
});

$('#choice').on('change', function() {
    if($(this).val() === 'users') createContent('$urlUser');
    else if($(this).val() === 'hiddens') createContent('$urlHiddens');
});

function createContent(url) {
    $.get(url, {'votersListId': '$modelId'}, function(data) {
        if(data.result === 'ok') {
            let output = '';
            if (data.type === 'users'){
                data.data.forEach(function(item) {
                    output += '<div class="card-body" style="display: flex">'
                + '<input type="checkbox" class="checkbox" name="userIds[' + item.id + ']"' + item.isChecked + '>'
                + '<div style="margin-left: 20px">';
                    if(url in item) output += '<a href="' + item.url + '">' + item.title + '</a>'; 
                    else output += item.title;
                    output += '</div></div>';
                })
            } 
            else {
                if(data.type === 'hiddens') {
                    if(data.hiddensPresence) {
                        data.data.forEach(function(item) {
                            output += '<div class="card-body" style="display: flex">'
                            + '<input type="checkbox" class="checkbox" name="hiddenIds[' + item.id + ']"' + item.isChecked + '>'
                            + '<div style="margin-left: 20px">';
                            if(url in item) output += '<a href="' + item.url + '">' + item.title + '</a>'; 
                            else { output += item.title; }
                            output += '</div></div>';
                        });
                    }
                    else {
                        output = '<p><div class="btn btn-success">Create Hiddens</div>'
                        +'<input type="number" class="form-control" name="hiddens_count" value="1" max="100" min="1">'
                        +'</p>'
                    }
                }
            }
            $('#userChoice').html(output);
        }
    })
}

$('#userChoice').on('click', '.btn-success', function() {
    let url = '$urlCreateHiddens';
    let count = $('input[name=hiddens_count]').val();
    $.get(url, {'votersListId': '$modelId', 'count': count}, function (responce){
        if(responce.result === 'ok'){
            $('#choice').trigger('change');
        }
    });
})
JS;
$this->registerJs($js, $this::POS_READY);
