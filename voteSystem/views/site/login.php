<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/css/main_log.css');
$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class='cont'>
    <div class='main_box'>
        <h2 style="margin-bottom:20px;"> Выберите тип пользователя </h2>
        <div class='choice_box' style="margin-bottom:20px;">
            <div class='user_buttons'>
                <?= Html::a("<h4>Пользователь</h4>  <p> Вход осуществляется по логину и паролю</p>", Url::to('/users/login'), ['class' => 'btn btn-success']) ?>
                <?= Html::a("<h4>Анонимный участник</h4> <p> Вход осуществляется по полученному ключ-паролю</p> ", Url::to('/hiddens/login'), ['class' => 'btn btn-danger']) ?>
            </div>
        </div>
        <h2 style="margin-bottom:20px;"> Или </h2>
        <div>
            <a class="btn btn-primary" href="/users/create">
                <h4> Создать пользователя </h4>
            </a>
        </div>
    </div>
</div>


<!--<div class="site-login">-->
<!--    <h1>--><? //= Html::encode($this->title) 
                ?><!--</h1>-->
<!---->
<!--    <p>Please fill out the following fields to login:</p>-->
<!---->
<!--    --><?php //$form = ActiveForm::begin([
            //        'id' => 'login-form',
            //        'layout' => 'horizontal',
            //        'fieldConfig' => [
            //            'template' => "{label}\n{input}\n{error}",
            //            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            //            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            //            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            //        ],
            //    ]); 
            ?>
<!---->
<!--        --><? //= $form->field($model, 'username')->textInput(['autofocus' => true]) 
                ?>
<!---->
<!--        --><? //= $form->field($model, 'password')->passwordInput() 
                ?>
<!---->
<!--        --><? //= $form->field($model, 'rememberMe')->checkbox([
                //            'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                //        ]) 
                ?>
<!---->
<!--        <div class="form-group">-->
<!--            <div class="offset-lg-1 col-lg-11">-->
<!--                --><? //= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) 
                        ?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    --><?php //ActiveForm::end(); 
            ?>
<!---->
<!--    <div class="offset-lg-1" style="color:#999;">-->
<!--        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>-->
<!--        To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
<!--    </div>-->
<!--</div>-->