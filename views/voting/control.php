<?php

/**
 * @var yii\web\View $this
 * @var Votings $model
 */

use app\models\Votings;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

?>
    <div class="card-title">
        <p class="bd-title">Голосование №<?= $model->id ?></p>
    </div>
    <div class="card">
        <?php
        foreach ($model->bulletins as $bulletin) {
            $link = Html::a($bulletin->title, '#', ['class' => 'viewBulletin', 'data-model-id' => $bulletin->id]);
            $radio = Html::radio('bulletin', false, ['value' => $bulletin->id]);
            echo Html::tag('div', $link . $radio, ['style' => 'display: flex;align-items: center;justify-content: space-evenly;']);
        }
        ?>
    </div>
<hr>
<?php
// Формирование модельного окна, которое на данный момент скрыто от пользователя:
Modal::begin([
    // Присвоение атрубутов модальному окну:
    'title' => '<h4 class="modal-title">Создать ответ</h4>',    // Заголовок
    'id' => 'viewBulletinModal',                                // Присовоение id на странице данному окну.
]);

// Вывод в document странице div контейнера под данное модальное окно.
echo '<div id="modalContent"></div>';
Modal::end();

$urlSelect = Url::to(['/bulletins/select-bulletin']);
$urlView = Url::to(['/bulletins/view']);
$js = <<<JS
$(document).ajaxStart(function() {
  $('#loader').show();
});

// Скройте анимацию загрузки после завершения AJAX-запроса
$(document).ajaxStop(function() {
  $('#loader').hide();
});

$('input[type=radio][name=bulletin]').on('change', function () {
    let radioVal = $('input[type=radio][name=bulletin]:checked').val();

    $.ajax({
        url: '$urlSelect',
        type: 'post',
        data: {
            'bulletinId': radioVal,
            'votingId': '$model->id'
            },
        success: function(data) {
            
        }
    })
})
$('.viewBulletin').click(function() {
    // Тело метода-обработчика:
    // Инициализация переменной modelId значением из атрибута, который сохранен в кнопке и содержит id текущей модели:
    var modelId = $(this).data('model-id');

    // Данный метод заполняет модалку
    $('#viewBulletinModal').modal('show')
        .find('#modalContent')
        .load('$urlView', {'questionId': modelId});
});
JS;
$this->registerJs($js);
