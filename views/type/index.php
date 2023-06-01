<?php

/** @var yii\web\View $this
 * @var $searchModel TypeSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $title string
 * @var $modelClass string
 */

use app\models\TypeSearch;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->registerCssFile('@web/css/types_index.css');
$this->title = $title;

$this->params['breadcrumbs'][] = $this->title;

$shortClassName = basename(str_replace('\\', '/', $modelClass));
//Предполагалось сделать модалки под создание и обновление одной модели в списке, и ajax-ом обновлять.
//Решил отложить для экономии времени, не работало корректно только обновление.
//Первый раз ничего не прогружалось, во второй прогрузилось то что должно быть в первом, в 3 раз то что во 2 и т.д.
//echo ModalAjax::widget([
//    'id' => 'create_type_model',
//    'title' => 'Добавить запись',
//    'toggleButton' => [
//        'label' => 'Добавить запись',
//        'class' => 'btn btn-primary mr-2'
//    ],
//    'url' => Url::to(['update-create', 'model' => $shortClassName]),
//    'ajaxSubmit' => true,
//    'size' => Modal::SIZE_DEFAULT,
//    'pjaxContainer' => '#pjax_container',
//]);
//
//
?>
<div class="types-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr />
    <p>
        <?= Html::a('Создать тип', ['type/update-create', 'model' => $shortClassName], ['class' => 'btn btn-success']) ?>
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
                'class' => ActionColumn::class,
                'template' => '{updated} {delete}',
                'buttons' => [
                    //                                'update-a' => [
                    //                                    'class' => 'update-ingrid-button',
                    //                                    'title' => 'Редактировать',
                    //                                    'data-url' => $model->id ? Url::to(['update', 'id' => $modelId]) : null,
                    //                                ],
                    'updated' => function ($url, $model, $key) {
                        $fullClassName = $model::className();
                        $shortClassName = basename(str_replace('\\', '/', $fullClassName));

                        //                                    return ModalAjax::widget([
                        //                                        'id' => 'update_type_model:' . $key,
                        //                                        'title' => 'Добавить запись',
                        //                                        'toggleButton' => [
                        //                                            'label' => 'Добавить запись',
                        //                                            'class' => 'btn btn-primary mr-2'
                        //                                        ],
                        //                                        'url' => Url::to(['update-create', 'model' => $shortClassName, 'id' => $key]),
                        //                                        'ajaxSubmit' => true,
                        //                                        'size' => Modal::SIZE_DEFAULT,
                        //                                        'pjaxContainer' => '#pjax_container',
                        //                                    ]);
                        return Html::a(
                            '<svg aria-hidden="true" style="height:24;width:24;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>',
                            ['update-create', 'model' => $shortClassName, 'id' => $key],
                            //                                        [
                            //                                            'class' => 'update-ingrid-button',
                            //                                            'data-url' => Url::to(['update-create', 'model' => $shortClassName, 'id' => $key, 'r' => rand(0, 1000000)]),
                            ////                                            'data-toggle' => "modal",
                            ////                                            'data-target' => "#update_model_modalform",
                            //                                        ]
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        $fullClassName = $model::className();
                        $shortClassName = basename(str_replace('\\', '/', $fullClassName));
                        return Html::a(
                            '<svg aria-hidden="true" style="height:24;width:24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>',
                            ['type/delete', 'model' => $shortClassName, 'id' => $key]
                        );
                    }
                ]
            ],
        ]
    ]); ?>

    <?php Pjax::end() ?>

</div>