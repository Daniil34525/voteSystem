<?php

use app\models\Users;

/** @var yii\web\View $this */

$this->registerCssFile('@web/css/start_page.css');
$this->title = 'My Yii Application';
?>
<div class="content">


    <div class="hello">
        <?php if (Yii::$app->user->isGuest) : ?>
            <h1>Система электронного голосования КГУ.</h1>
            <br />
            <p> Требуется выполнить вход в систему. </p>
        <?php else : ?>
            <h1>Система электронного голосования КГУ.</h1>
            <?php $current_user = Users::find()->where(["id" => Yii::$app->user->id])->one(); ?>
            </br>
            <h2> Здравствуйте, <?= $current_user->name ?> <?= $current_user->middle_name ?>!</h2>
    </div>

    <div class='algorithm'>
        <h4> Алгоритм работы с системой:</h4>
        <ol>
            <li> Формирование вопросов и ответов </li>
            <li> Создание бюллетений. </li>
            <li> Формирование списка голосующий: пользователи/анонимные участники. </li>
            <li> Создание голосования, в котором происходит выбор бюллетений на голосования, а также списка голосующих. </li>
        </ol>
    </div>
<?php endif; ?>
</div>