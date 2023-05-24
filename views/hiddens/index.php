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
$this->title = 'Анонимные участники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hiddens-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>

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
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php

$url = Url::to(['create', 'count' => ''], true);

$js = <<< JS

var count = 0
function myfunc(value) {
  
    var create_hiddens = document.querySelector("#main > div > div > p > a"); 
    create_hiddens.href = "$url" + value;
}

JS;
$position = $this::POS_BEGIN;
$this->registerJs($js, $position);
?>