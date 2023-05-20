<?php

namespace app\controllers;

use app\models\Hiddens;
use app\models\HiddenSearch;
use app\models\VotersList;
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
    public function behaviors()
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
     * Lists all Hiddens models.
     *
     * @return string
     */
    public function actionIndex()
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
     * @return string|\yii\web\Response
     */
    public function actionCreate($count = 1)
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
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCreateHiddensForVotersList($count, $votersListId){
        $voterModel = VotersList::find()->where(['id' => $votersListId])->one();
        for ($i = 0; $i < $count; $i++) {
            $model = new Hiddens();
            $model->code = Hiddens::get_random_code();
            $model->save();
            $model->link('voterLists', $voterModel);
        }
        return $this->asJson(['result' => 'ok']);
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
        return $this->asJson(['result' => 'ok', 'type' => 'hiddens',  'hiddensPresence' => $hiddensPresence, 'data' => $data]);
    }

    /**
     * Finds the Hiddens model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Идентифактор анонимного участника
     * @return Hiddens the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hiddens::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
