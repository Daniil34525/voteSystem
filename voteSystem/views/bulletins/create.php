<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bulletins $model */

$this->title = 'Создание бюллетени';
$this->params['breadcrumbs'][] = ['label' => 'Бюллетени', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bulletins-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
