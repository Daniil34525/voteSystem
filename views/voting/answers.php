<?php

use app\models\Votings;
use yii\widgets\ActiveForm;

/**
 * @var Votings $votingModel
 */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="card-group">
    <?php foreach ($votingModel->bulletins as $bulletin) : ?>
        <div class="card">
            <p><?= $bulletin->title; ?></p>
            <div class="card">
                <?php foreach ($bulletin->questions as $question) : ?>
                    <div class="card" style='margin-bottom:10px;'>
                        <?= $question->question_title; ?>
                        <div class="card-body"><p><?= $question->overview; ?></p></div>
                        <div class="card">
                            <?php foreach ($question->answers as $answer) : ?>
                                <?php
                                $userId = Yii::$app->user->id;
                                $role = Yii::$app->authManager->getRolesByUser($userId);
                                if (in_array($userId, $answer->voters[array_key_first($role)])) : ?>
                                    <div class="btn-primary"> <?= $answer->title; ?></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php ActiveForm::end(); ?>
