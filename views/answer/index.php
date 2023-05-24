<?php
/** @var yii\web\View $this
 * @var $searchModel TypeSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $title string
 * @var $modelClass string
 */

use app\models\Answers;
use app\models\TypeSearch;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answers-index">

<h1><?= Html::encode($this->title) ?></h1>

<p>
<?= Html::a('Создать ответ', ['answer/update-create'], ['class' => 'btn btn-success']) ?>
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
                            'attribute' => 'question_id',
                            'value' => function (Answers $model) {
                                return $model->question->question_title;
                            }
                        ],
                        [
                            // TODO: Надо будет обсудить вывод тех, кто проголосовал
                            'format' => 'html',
                            'attribute' => 'voters',
                            'value' => function (Answers $model) {
                                $result = '';
                                // Вывод ID пользователей
                                if (isset($model['voters']['users'])) {
                                    foreach ($model['voters']['users'] as $userId) {
                                        $result .= "User ID: " . $userId . "<br>";
                                    }
                                }

                                // Вывод ID скрытых элементов
                                if (isset($model['voters']['hiddens'])) {
                                    foreach ($model['voters']['hiddens'] as $hiddenId) {
                                        $result .= "Hidden ID: " . $hiddenId . "<br>";
                                    }
                                }
                                return $result;
                            }
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>',
                                        ['update-create', 'id' => $key],
                                    );
                                },
                            ]
                        ]
                    ],
                ]); ?>

                <?php Pjax::end(); ?>

</div>
