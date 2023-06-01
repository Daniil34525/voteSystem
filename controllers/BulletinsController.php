<?php

namespace app\controllers;

use app\models\Bulletins;
use app\models\BulletinSearch;
use app\models\Votings;
use yii\behaviors\TimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BulletinsController implements the CRUD actions for Bulletins model.
 */
class BulletinsController extends Controller
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
                    ]
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'update', 'create', 'delete', 'select-bulletin'], // действия, к которым разрешен доступ
                            'roles' => ['admin'], // разрешен доступ для авторизованных администраторов
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view'], // действия, к которым разрешен доступ
                            'roles' => ['@', '?'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Bulletins models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new BulletinSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Bulletins model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Bulletins();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect('index', 302);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bulletins model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Код бюллетени
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect('index', 301);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bulletins model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Код бюллетени
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id = null)
    {
        if(is_null($id)) $id = $this->request->post()['questionId'];
        $model = $this->findModel($id);

        if ($this->request->isAjax)
            return $this->renderAjax('view', ['model' => $model]);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSelectBulletin(): Response
    {
        $votingId = $this->request->post()['votingId'];
        $voting = Votings::find()->where(['id' => $votingId])->one();
        foreach ($voting->bulletins as $bulletin) {
            if ($bulletin->is_selected) {
                $bulletin->is_selected = false;
                if (!$bulletin->save()) return $this->asJson(['result' => 'err']);
            }
        }
        $bulletinId = $this->request->post()['bulletinId'];
        $model = $this->findModel($bulletinId);
        $model->is_selected = true;
        if ($model->save())
            return $this->asJson(['result' => 'ok']);
        return $this->asJson(['result' => 'err']);
    }

    /**
     * Finds the Bulletins model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Код бюллетени
     * @return Bulletins the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bulletins::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
