<?php
/** @var yii\web\View $this
 * @var $searchModel VotingSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $title string
 */

use app\models\VotingSearch;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = $title;

$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::a('Создать голосование', ['voting/update-create'], ['class' => 'btn btn-primary']) ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
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
                        ],
                    ]
                ]); ?>

                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>
