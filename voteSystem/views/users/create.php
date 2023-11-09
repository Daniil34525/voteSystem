<?php

use yii\helpers\Html;

/** @var yii\web\View $this
 * @var app\models\Users $model
 * @var bool $isGuest
 */

$this->title = 'Создание пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'isGuest' => $isGuest,
    ]) ?>

</div>
