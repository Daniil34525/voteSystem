<?php

namespace app\controllers;

use app\models\VotersList;
use app\models\VotersListSearch;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VotersListController implements the CRUD actions for VotersList model.
 */
class VotersListController extends Controller
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
            ]
        );
    }

    /**
     * Lists all VotersList models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new VotersListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new VotersList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // New model creation:
        $model = new VotersList();
        
        // Checking the request type:
        if ($this->request->isPost) {
            # Loading data from form where data from post to model and make a save operation:
            if ($model->load($this->request->post()) && $model->save()) {
                # Create the redirect to the index page with the status code 302:
                return $this->redirect('index', 302);
            }
        } else {
            # Create model with the default data from database schema:
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VotersList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Идентификатор списка избирателей
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect('index', 302);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VotersList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Идентификатор списка избирателей
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VotersList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Идентификатор списка избирателей
     * @return VotersList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) : ActiveRecord
    {
        if (($model = VotersList::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
