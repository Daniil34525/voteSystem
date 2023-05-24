<?php

use app\models\Answers;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Questions $model
 * @var Answers[] $answers
 */

$this->title = 'Редактирование вопроса: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'answers' => $answers
    ]) ?>

</div>
