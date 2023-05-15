<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\VotersList $model */
/** @var integer[] $userIds */

$this->title = 'Update Voters List: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Voters Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="voters-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userIds' => $userIds
    ]) ?>

</div>
