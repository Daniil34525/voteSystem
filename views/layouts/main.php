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
    <?php $css = <<<CSS
    .loader {
        border: 10px solid #1983c9; /* Цвет обводки */
        border-top: 10px solid #ffffff; /* Цвет верхней границы */
        border-radius: 50%;
        width: 100px;
        height: 100px;
        animation: spin 2s linear infinite; /* Анимация вращения */
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
CSS;
    $this->registerCss($css); ?>
</head>
<body>
<div class="loader" id="loader"></div>
<?php

NavBar::begin([
    'brandLabel' => 'Голосование КГУ',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-md navbar-dark fixed-top']
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        [
            'label' => 'Голосования',
            'visible' => Yii::$app->user->can('vote'),
            'url' => ['/voting/select']
        ],
        [
            'label' => 'Компоненты',
            'visible' => Yii::$app->user->can('createAll'),
            'url' => '#',
            'options' => ['class' => 'nav-item dropdown'],
            'items' => [
                ['label' => 'Голосование', 'url' => ['/voting/index']],
                ['label' => 'Пользователи', 'url' => ['/users/index']],
                ['label' => 'Анонимы', 'url' => ['/hiddens/index']],
                ['label' => 'Вопросы', 'url' => ['/questions/index']],
                ['label' => 'Ответы', 'url' => ['/answer/index']],
                ['label' => 'Бюллетени', 'url' => ['/bulletins/index']],
                ['label' => 'Списки избирателей', 'url' => ['/voters-list/index']],
            ]
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


<main id="main" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])) : ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer">
    <h5> Система электронного голосования КГУ </h5>
</footer>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
