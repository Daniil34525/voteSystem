<?php

use app\models\Answers;
use app\models\Bulletins;
use app\models\Questions;
use yii\debug\models\timeline\DataProvider;

$this->title = $model->title;
$this->registerCssFile("@web/css/bulletins.css");
$this->title = 'Просмотр бюллетени: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Бюллетени', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Просмотр';
?>

<div class="main_container">
    <div class="bulletin_head">
        <h2> <?= $model->title ?></h2>
        <h6> <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i'); ?></h6>
    </div>

    <div class="content">
       

        <!-- // Получение списка вопросов, которые относятся к данной бюллетени: -->
        <?php $questions_for_bulletin = $model->getQuestions()->select(['id', 'question_title', 'overview'])->asArray()->all(); ?>
        <!-- Проверка того, что список вопрос для данной бюллети не пустой: -->
        <?php if (!is_null($questions_for_bulletin)) : ?>
            <!-- В цикле для каждого вопроса -->
            <?php foreach ($questions_for_bulletin as $question) : ?>
                <!-- Получение списка всех ответов на данный кокретный вопрос:  -->
                <?php $answers_arr = Answers::find()->select('title')->where(["question_id" => $question['id']])->column(); ?>
                <!-- Провека того, получилось ли достать вопросы из бд: -->
                <?php if (!is_null($answers_arr)) : ?>
                    <!-- Отображение заголовка вопроса: -->

                    <div class='qiestion_header'>
                        <p class='question_title'> <?= $question['question_title']; ?> </p>
                        <p> <?= $question['overview']; ?> </p>
                    </div>
                    
                    <p style="margin-left:20px;"> Варианты ответа: </p>
                    <ul class='answers'> <!-- Открываем наш список -->
                        <?php foreach ($answers_arr as $answer) : ?>
                            <li> <?= $answer ?> </li>
                        <?php endforeach; ?>
                    </ul>
                
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>