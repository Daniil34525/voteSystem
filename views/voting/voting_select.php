<?php

/** @var yii\web\View $this
 * @var Votings $model
 */

use app\models\Votings;
use app\models\BulletinsList;
use app\models\Bulletins;
use app\models\VotingTypes;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Выбор текущего голосования';
$this->params['breadcrumbs'][] = ['label' => 'Голосования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">
    <?php foreach ($votings as $voting) : ?>
        <?php foreach ($voting as $vot) : ?>
            <div class="card">

                <a href=<?= "/voting/elections?id=" . $vot->id ?>>
                    <div class="card-body">
                        <h4> <?php echo $vot->title; ?> </h4>
                        <p> <?php echo Yii::$app->formatter->asDatetime($vot->created_at, 'php:d.m.Y H:i'); ?> </p>
                    </div>
                </a>
                <a href=<?= "/voting/show-answers/?id=" . $vot->id ?>> Просмотр </a>
            </div>

        <?php endforeach; ?>
    <?php endforeach; ?>
</div>