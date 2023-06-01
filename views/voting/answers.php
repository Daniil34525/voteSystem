<?php

use app\models\Votings;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Votings $votingModel
 */

$this->registerCssFile('@web/css/show_voting_answers.css');

?>
<?php $form = ActiveForm::begin(); ?>
<div class="bulletins_card_container">

    <?php foreach ($votingModel->bulletins as $bulletin) : ?>

        <div class="bulletin_card">
            <div class="bulletin_card_header">
                <h4> <?= $bulletin->title; ?> </h4>
            </div>
            <div class="bulletin_card_body">
                <?php foreach ($bulletin->questions as $question) : ?>


                    <div class='qiestion_header'>
                        <p class='question_title'> <?= $question->question_title; ?> </p>
                        <p><?= $question->overview; ?> </p>
                    </div>
                    
                    <p> Полученные ответы: </p>
                    <ul class="answers_container">

                        <?php foreach ($question->answers as $answer) : ?>
                            <?php
                            $userId = Yii::$app->user->id;
                            $role = Yii::$app->authManager->getRolesByUser($userId);
                            if (!is_null($answer->voters[array_key_first($role)])) :
                                if (in_array($userId, $answer->voters[array_key_first($role)])) : ?>
                                    <li> <?= $answer->title; ?></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </ul>


                <?php endforeach; ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>
<?php ActiveForm::end(); ?>