<?php

use app\models\Hiddens;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\BaseUrl;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\HiddenSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile("@web/css/hiddens.css");
$this->registerCssfile("@web/css/hiddens_index.css");

$this->title = 'Анонимные участники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hiddens-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr />

    <div class="creation_menue">
        <?= Html::a('Создать участника', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::input('number', 'hiddens_count', '1', ['max' => 100, 'min' => 1, 'class' => 'form-control', 'onchange' => 'myfunc(this.value)']) ?>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // Deleting comments from database in view:
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'code',
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<svg aria-hidden="true" style="height:24;width:24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>',
                            ['delete', 'id' => $key], 
                            [
                                'data' => [
                                    'confirm' => 'Вы действительно хотите удалить данного анонимного участника?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php

$url = Url::to(['create', 'count' => ''], true);

$js = <<< JS

function myfunc(value) {
  
    var create_hiddens = document.querySelector("#main > div > div > div.creation_menue > a"); 
    create_hiddens.href = "$url" + value;
}

JS;
$position = $this::POS_END;

$this->registerJs($js, $position);
?>