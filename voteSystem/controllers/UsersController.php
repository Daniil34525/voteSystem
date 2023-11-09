<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Users;
use app\models\UserSearch;
use app\models\VotersList;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'view', 'update', 'delete', 'choice-user'], // действия, к которым разрешен доступ
                            'roles' => ['admin'], // разрешен доступ для авторизованных пользователей
                        ],
                        [
                            'allow' => true,
                            'actions' => ['login', 'create'],
                            'roles' => ['?'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param int $id Идентификтор пользователя
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()))
                $model->password_hash = password_hash($model->password_hash,PASSWORD_ARGON2ID);
                if ($model->save()) {
                    if (Yii::$app->user->isGuest)
                        $this->redirect('/users/login');
                    else
                        return $this->redirect(['view', 'id' => $model->id]);
                }
        } else {
            $model->loadDefaultValues();
        }

        if (Yii::$app->user->isGuest)
            $model->role_type_id = 2;

        return $this->render('create', [
            'model' => $model,
            'isGuest' => Yii::$app->user->isGuest
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Идентификтор пользователя
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Идентификтор пользователя
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Метод используется для выбора пользователей при редактировании списка голосующих
     * @param $votersListId
     * @return Response
     */
    public function actionChoiceUser($votersListId): Response
    {
        $data = [];
        $users = Users::find()->all();
        $model = VotersList::find()->where(['id' => $votersListId])->one();
        $userIds = $model->getUsers()->select('id')->column(); // Получить все ID пользователей
        foreach ($users as $user) {
            $arrItem = [
                'id' => $user->id,
                'name' => 'userIds',
                'url' => Url::to(['users/view', 'id' => $user->id]),
                'title' => $user->MiddleNameAndInitials,
                'isChecked' => in_array($user->id, $userIds) ? 'checked' : ''
            ];
            $data[] = $arrItem;
        }
        return $this->asJson(['result' => 'ok', 'type' => 'users', 'data' => $data]);
    }

    public function actionLogin()
    {
        $model = new LoginForm(['typeUser' => 'user']);

        // Проверка, была ли отправлена форма
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Авторизация прошла успешно, перенаправление на другую страницу
            return $this->redirect(['site/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Идентификтор пользователя
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Users
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
