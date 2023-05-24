<?php

use app\models\Bulletins;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\BulletinSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */



$this->title = 'Бюллетени';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="bulletins-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/> 
    <p>
        <?= Html::a('Создать бюллетень', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'created_at:date',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete} {view}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    
</div>
