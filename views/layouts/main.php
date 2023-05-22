<?php

/** @var yii\web\View $this
 * @var string $content
 */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            [
                'label' => 'Голосование',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/voting/index']],
            [
                'label' => 'Пользователи',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/users/index']
            ],
            [
                'label' => 'Ответы',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/answer/index']
            ],
            [
                'label' => 'Бюллетени',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/bulletins/index']
            ],
            [
                'label' => 'Анонимы',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/hiddens/index']
            ],
            [
                'label' => 'Вопросы',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/questions/index']
            ],
            [
                'label' => 'Список голосующих',
                'visible' => Yii::$app->user->can('createAll'),
                'url' => ['/voters-list/index']
            ],
            [
                'label' => 'Типы',
                'url' => '#',
                'visible' => Yii::$app->user->can('createAll'),
                'items' => [
                    ['label' => 'Тип вопроса', 'url' => ['/type/index?model=QuestionTypes']],
                    ['label' => 'Тип голосования', 'url' => ['/type/index?model=VotingTypes']],
                    ['label' => 'Роль', 'url' => ['/type/index?model=RoleTypes']],
                ]
            ],
            [
                'label' => 'Войти',
                'visible' => Yii::$app->user->isGuest,
                'url' => ['/site/login']
            ],
            [
                'label' => 'Выйти',
                'visible' => !Yii::$app->user->isGuest,
                'url' => ['/site/logout']
            ],
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; The Best Voting <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
