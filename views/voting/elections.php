<?php

use app\models\Votings;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Votings $votingsModel
 */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="card-group">
    <?php foreach ($votingsModel->bulletins as $bulletin) : ?>
        <div class="card">
            <p><?= $bulletin->title; ?></p>
            <div class="card">
                <?php foreach ($bulletin->questions as $question) : ?>
                    <div class="card" style='margin-bottom:10px;'>
                        <?= $question->question_title; ?>
                        <div class="card-body"><p><?= $question->overview; ?></p></div>
                        <div class="card">
                            <?php foreach ($question->answers as $answer) : ?>
                                <div>
                                    <?= Html::checkbox("answer[$answer->id]", false, ['id' => 'answer' . $answer->id]); ?>
                                    <label for="<?= 'answer' . $answer->id ?>"> <?= $answer->title; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div>
    <?= Html::submitButton('Сохранить ответы',); ?>
</div>
<?php ActiveForm::end(); ?>
