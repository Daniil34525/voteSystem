<?php

/** @var yii\web\View $this

 * @var Votings $model
 * @var $data [[voters_lists] => [votings]]
 */

use app\models\Votings;
use app\models\BulletinsList;
use app\models\Bulletins;
use app\models\VotingTypes;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Выбор текущего голосования';

$this->registerCssFile('@web/css/votings_list.css');

$this->params['breadcrumbs'][] = ['label' => 'Голосования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">

    <?php foreach ($data as $voters_list) : ?>
        <?php foreach ($voters_list as $voting) : ?>
            <div class="vote">
                <div class="vote_show">
                    <!-- Link to specified voting:-->
                    <a href=<?= "/voting/elections?id=" . $voting->id ?>>
                        <h4> <?php echo $voting->title; ?> </h4>
                        <?php echo Yii::$app->formatter->asDatetime($voting->created_at, 'php:d.m.Y H:i'); ?>
                    </a>
                </div>
                <div class="show_answers">
                    <!-- Link to show current user answers for this voting: -->
                    <a href=<?= "/voting/show-answers/?id=" . $voting->id ?>><svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path>
                        </svg> </a>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
