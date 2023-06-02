<?php

/**
 * @var yii\web\View $this
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

$this->registerCssFile('@web/css/voting_index.css');
$this->title = $title;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="voting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr />
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
                'template' => '{control} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<svg aria-hidden="true" style="height:24;width:24;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>', ['update-create', 'id' => $key]);
                    },
                    'control' => function ($url, $model, $key) {
                        return  Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M1914 1539q6 30 6 61t-6 61l124 51l-49 119l-124-52q-35 51-86 86l52 124l-119 49l-51-124q-30 6-61 6t-61-6l-51 124l-119-49l52-124q-51-35-86-86l-124 52l-49-119l124-51q-6-30-6-61t6-61l-124-51l49-119l124 52q35-51 86-86l-52-124l119-49l51 124q30-6 61-6t61 6l51-124l119 49l-52 124q51 35 86 86l124-52l49 119l-124 51zm-314 253q40 0 75-15t61-41t41-61t15-75q0-40-15-75t-41-61t-61-41t-75-15q-40 0-75 15t-61 41t-41 61t-15 75q0 40 15 75t41 61t61 41t75 15zM1152 640V128H256v1792h896v128H128V0h1115l549 549v475h-128V640h-512zm128-128h293l-293-293v293z"/></svg>', ['control', 'id' => $key]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<svg aria-hidden="true" style="height:24;width:24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>',
                            ['delete', 'id' => $key],
                            [
                                'data' => [
                                    'confirm' => 'Вы действительно хотите удалить данное голосование?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ]
            ],
        ]
    ]); ?>

    <?php Pjax::end() ?>
</div>