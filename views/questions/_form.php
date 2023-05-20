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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
        <?= Html::button('Создать ответ', ['id' => 'createAnswer', 'data-model-id' => $model->id]); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
Modal::begin([
    'title' => '<h4 class="modal-title">Создать вопрос</h4>',
    'id' => 'createAnswerModal',
]);
echo '<div id="modalContent"></div>';
Modal::end();
?>

<?php
$url = Url::to('modal-content');
// Регистрация JavaScript для открытия модального окна
$js = <<< JS
$('#createAnswer').click(function(){
    var modelId = $(this).data('model-id');
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
