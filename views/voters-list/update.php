<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\VotersList $model */
/** @var integer[] $userIds */

$this->title = 'Редактирование списка избирателей: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Списки избирателей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="voters-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userIds' => $userIds
    ]) ?>

</div>
