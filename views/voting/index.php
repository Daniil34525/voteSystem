<?php

/** @var yii\web\View $this
 * @var $searchModel VotingSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $title string
 */

use app\models\Votings;
use app\models\VotingSearch;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $title;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="voting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать голосование', ['voting/update-create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax_container']) ?>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-bordered table-sm table-hover cursor_pointer_inside',
            'data-pjax_selector' => '#pjax_container',
        ],
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'voting_type_id',
                'value' => function (Votings $model) {
                    return $model->type->title;
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Обновить', Url::to(['update-create', 'id' => $key]));
                    }
                ]
            ],
        ]
    ]); ?>

    <?php Pjax::end() ?>
 

</div>