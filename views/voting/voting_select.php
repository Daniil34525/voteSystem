<?php

/** @var yii\web\View $this
 * @var Votings $votings
 */

use app\models\Votings;

$this->title = 'Выбор текущего голосования';
$this->params['breadcrumbs'][] = ['label' => 'Голосования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">
    <?php foreach ($votings as $voting) : ?>
        <?php foreach ($voting as $vote) : ?>
            <div class="card">

                <a href=<?= "/voting/elections?id=" . $vote->id ?>>
                    <div class="card-body">
                        <h4> <?php echo $vote->title; ?> </h4>
                        <p> <?php echo Yii::$app->formatter->asDatetime($vote->created_at, 'php:d.m.Y H:i'); ?> </p>
                    </div>
                </a>
                <a href=<?= "/voting/show-answers/?id=" . $vote->id ?>> Просмотр ответов</a>
            </div>

        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
