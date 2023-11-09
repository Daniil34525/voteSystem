<?php

use app\models\Answers;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\QuestionTypes;
use app\models\Bulletins;

/** @var yii\web\View $this
 * @var app\models\Questions $model
 * @var yii\widgets\ActiveForm $form
 * @var Answers[] $answers
 */
?>
<div class="questions-form">
    <?php $form = ActiveForm::begin(); ?>

    <div id="save" class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?= $form->field($model, 'question_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bulletin_id')->dropDownList(Bulletins::get_list_items()); ?>

    <?= $form->field($model, 'overview')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(QuestionTypes::get_list_items()); ?>

    <div class="form-group" id="answers">
        <?php
        if (isset($answers))
            foreach ($answers as $answer) {
                $url = Url::to(['answer/view', 'id' => $answer->id]);
                $text = Html::a($answer->title, $url);
                $checkbox = Html::checkbox('answerIds[' . $answer->id . ']', !is_null($answer->question_id), ['class' => 'checkbox']);
                $divTitle = Html::tag('div', $text, ['style' => 'margin-left: 20px']);
                $result = Html::tag('div', $checkbox . $divTitle, ['style' => 'display: flex']);
                echo $result;
            }
        ?>
    </div>

    <div>
        <?= Html::button('Добавить ответ', ['id' => 'createAnswer', 'class' => 'btn btn-secondary', 'data-model-id' => $model->id]); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
// Формирование модельного окна, которое на данный момент скрыто от пользователя: 
Modal::begin([
    // Присвоение атрубутов модальному окну:
    'title' => '<h4 class="modal-title">Создать ответ</h4>',    // Заголовок
    'id' => 'createAnswerModal',                                // Присовоение id на странице данному окну.
]);

// Вывод в document странице div контейнера под данное модальное окно.
echo '<div id="modalContent"></div>';
Modal::end();
?>

<?php
$url = Url::to('modal-content');
// Регистрация JavaScript для открытия модального окна
$js = <<< JS
$(document).ajaxStart(function() {
  $('#loader').show();
});

// Скройте анимацию загрузки после завершения AJAX-запроса
$(document).ajaxStop(function() {
  $('#loader').hide();
});

// При нажатии на кнопку с id "createAnswer": 
$('#createAnswer').click(function(){
    // Тело метода-обработчика:
    // Инициализация переменной modelId значением из атрибута, который сохранен в кнопке и содержит id текущей модели:
    var modelId = $(this).data('model-id');

    // Данный мето 
    $('#createAnswerModal').modal('show')
        .find('#modalContent')
        .load('$url', {'questionId': modelId});
});

$(document).on('beforeSubmit', '#modal-form', function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: '$url',
        type: 'post',
        data: form.serialize(),
        success: function(data) {
            $('#createAnswerModal').modal('hide');
            $('#answers').append(data.html);
        },
        error: function() {
            alert('Ошибка сохранения ответа');
        }
    });
    return false;
});

JS;
$this->registerJs($js);
?>
