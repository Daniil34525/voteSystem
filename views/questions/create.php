<?php

use app\models\Answers;
use yii\helpers\Html;

/** @var yii\web\View $this
 * @var app\models\Questions $model
 * @var Answers[] $answers
 */

$this->registerCssFile('@web/css/question_create.css');

$this->title = 'Создать вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'answers' => $answers,
    ]) ?>

</div>
