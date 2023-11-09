<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bulletins $model */

$this->title = 'Редактирование бюллетени: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Бюллетени', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="bulletins-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
