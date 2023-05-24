<?php

namespace app\controllers;

use app\models\QuestionTypes;
use app\models\RoleTypes;
use app\models\TypeSearch;
use app\models\VotingTypes;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\Response;

class TypeController extends Controller
{
    /** @var string[] Обрабатываемые модели (короткое и полное имя класса) */
    const MODELS = [
        'QuestionTypes' => QuestionTypes::class,
        'RoleTypes' => RoleTypes::class,
        'VotingTypes' => VotingTypes::class
    ];
    /** @var string[] Названия модели (полное имя и название класса) */
    const TITLE = [
        QuestionTypes::class => 'Типы вопросов',
        RoleTypes::class => 'Типы ролей',
        VotingTypes::class => 'Типы голосований'
    ];

    /** @var string Полное имя класс обрабатываемой модели. Вычисляется в init по значению гет-параметра $model */
    private string $modelClass;

    /** @var string Короткое имя класса. См в init */
    private string $shortModelClass;

    /** {@inheritdoc} */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(),
            [
//            'ajax' => [
//                'class' => AjaxFilter::class,
//                'only' => [
//                    'create',
//                    'update',
//                ],
//            ],
                [
                    'allow' => true,
                    'actions' => ['index', 'update-create', 'delete'], // действия, к которым разрешен доступ
                    'roles' => ['admin'], // разрешен доступ для авторизованных администраторов
                ],
            ]
        );
    }

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

        $this->shortModelClass = $shortModelClass;
        $this->modelClass = self::MODELS[$shortModelClass];
    }

    public function actionUpdateCreate($id = null)
    {
        if (!is_null($id)) {
            $modelObject = Yii::createObject($this->modelClass);
            $model = $modelObject->findOne($id);
        } else $model = new $this->modelClass();

        $title = self::TITLE[$this->modelClass];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'model' => $this->shortModelClass]);
            //return $this->asJson(['success' => true]);
        }
        return $this->render('update_create', ['model' => $model, 'title' => $title]);
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionDelete($id): Response
    {
        $modelObject = Yii::createObject($this->modelClass);

        $model = $modelObject->findOne($id);

        if (!is_null($model)) $model->delete();

        return $this->redirect(['index', 'model' => $this->shortModelClass], 302);
    }

    public function actionIndex(): string
    {
        $searchModel = new TypeSearch(['modelClass' => $this->modelClass]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $title = self::TITLE[$this->modelClass];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'modelClass' => $this->modelClass
        ]);
    }

//    public function actionUpdate(int $id)
//    {
//        try {
//            /** @var $modelClass Type */
//            $modelClass = $this->modelClass;
//            $modelObject = $modelClass::findOne($id);
//
//            if ($modelObject->load(Yii::$app->request->post()) && $modelObject->save()) {
//                return $this->asJson(['success' => true]);
//            }
//
//            return $this->renderAjax('update_create', ['model' => $modelObject]);
//
//        } catch (Exception $e) {
//            return $this->asJson(['result' => 'err', 'message' => $e->getMessage()]);
//        }
//    }
}
