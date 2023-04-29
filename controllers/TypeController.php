<?php

namespace app\controllers;

use app\models\QuestionTypes;
use Exception;
use Yii;
use yii\web\Controller;

class TypeController extends Controller
{
    /** @var string[] Обрабатываемые модели (короткое и полное имя класса) */
    const MODELS = [
        'QuestionType' => QuestionTypes::class,
    ];

    /** @var string Полное имя класса обрабатываемой модели. Вычисляется в init по значению гет-параметра $model */
    private string $modelClass;

    /**
     *  ВНИМАНИЕ!! Для всех экшенов должен приходить обязательный параметр GET[model] с коротким именем класса
     * обрабатываемой модели. См.const MODELS выше
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        $shortModelClass = Yii::$app->request->get('model');

        if (!$shortModelClass) {
            throw new Exception('Не найден обязательный параметр $model');
        }
        if (!in_array($shortModelClass, array_keys(self::MODELS))) {
            throw new Exception('Некорректное значение параметра $model');
        }

        $this->modelClass = self::MODELS[$shortModelClass];
    }

    public function actionCreate()
    {
        $modelObject = new $this->modelClass();

        if ($modelObject->load(Yii::$app->request->post()) && $modelObject->save()) {
            return $this->asJson(['success' => true]);
        }
        return $this->render('create_view', ['model' => $modelObject]);
    }

//    public function actionDelete(): string
//    {
//        return $this->render('delete');
//    }

    public function actionIndex(): string
    {
        return $this->render('index', ['model' => $this->modelClass]);
    }

    public function actionView(): string
    {
        return $this->render('create_view');
    }

}
