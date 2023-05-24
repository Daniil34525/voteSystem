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
                            'Обновить',
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
                        return Html::a('Удалить', ['type/delete', 'model' => $shortClassName, 'id' => $key]);
                    }
                ]
            ],
        ]
    ]); ?>

    <?php Pjax::end() ?>

</div>