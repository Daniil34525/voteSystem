<?php

use app\models\Votings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var Votings $votingModel
 */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="card-group" id="bulletin_select" data-val="4"></div>
    <div>
        <?= Html::submitButton('Сохранить ответы'); ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$url = Url::to('selected-bulletin');
$js = <<<JS
$(document).ready(function() {
    getSelectionBulletin()
    //setInterval(getSelectionBulletin, 5000)
});

function getSelectionBulletin() {
    let a = $('#bulletin_select').attr('data-val');
    $.get("$url", { 'votingId': "$votingModel->id", 'bulletinId': a }, function(data) {
        if(data.result === 'ok') {
            $('#bulletin_select').html(data.html)
            $('#bulletin_select').attr('data-val', data.id)
        }
        setTimeout(getSelectionBulletin, 2000);
}).fail(function() {
    setTimeout(getSelectionBulletin, 2000);
  })
}  
JS;
$this->registerJs($js);
