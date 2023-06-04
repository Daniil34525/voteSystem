<?php

namespace app\controllers;

use app\models\Hiddens;
use app\models\HiddenSearch;
use app\models\LoginForm;
use app\models\Users;
use app\models\VotersList;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * HiddensController implements the CRUD actions for Hiddens model.
 */
class HiddensController extends Controller
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
                            'actions' => ['index', 'create', 'delete', 'choice-hiddens', 'create-hiddens-for-voters-list'], // действия, к которым разрешен доступ
                            'roles' => ['admin'], // разрешен доступ для авторизованных администраторов
                        ],
                        [
                            'allow' => true,
                            'actions' => ['login'],
                            'roles' => ['?'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Hiddens models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new HiddenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Creates a new Hiddens model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $count
     * @return Response
     */
    public function actionCreate(int $count = 1): Response
    {
        for ($i = 0; $i < $count; $i++) {
            $model = new Hiddens();
            $model->code = Hiddens::get_random_code();
            $model->save();
        }

        return $this->redirect('index', 301);
    }

    /**
     * Deletes an existing Hiddens model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Идентифактор анонимного участника
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();
        $user = Users::find()->where(['id' => $id])->one();
        $user->delete();

        return $this->redirect(['index']);
    }

    public function actionCreateHiddensForVotersList($count, $votersListId): Response
    {
        $voterModel = VotersList::find()->where(['id' => $votersListId])->one();
        for ($i = 0; $i < $count; $i++) {
            $model = new Hiddens();
            $model->code = Hiddens::get_random_code();
            $model->save();
            $model->link('voterLists', $voterModel);
        }
        return $this->asJson(['result' => 'ok']);
    }

    /**
     * @throws \Exception
     */
    public function actionLogin()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm(['typeUser' => 'hidden']);

            // Проверка, была ли отправлена форма
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                // Авторизация прошла успешно, перенаправление на другую страницу
                return $this->redirect(['site/index']);
            }

            return $this->render('login', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['/bulletins/index']);
    }

    public function actionChoiceHiddens($votersListId): Response
    {
        $data = [];
        $hiddens = Hiddens::find()->orderBy(['id' => SORT_DESC])->all();
        $model = VotersList::find()->where(['id' => $votersListId])->one();
        $hiddensIds = $model->getHiddens()->select('id')->column(); // Получить все ID анонимных пользователь
        foreach ($hiddens as $hidden) {
            $arrItem = [
                'id' => $hidden->id,
                'name' => 'hiddenIds',
                'title' => $hidden->code,
                'isChecked' => in_array($hidden->id, $hiddensIds) ? 'checked' : ''
            ];
            $data[] = $arrItem;
        }
        $hiddensPresence = !empty($hiddensIds);
        return $this->asJson(['result' => 'ok', 'type' => 'hiddens', 'hiddensPresence' => $hiddensPresence, 'data' => $data]);
    }

    /**
     * Finds the Hiddens model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Идентифактор анонимного участника
     * @return Hiddens the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Hiddens
    {
        if (($model = Hiddens::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
