<?php

namespace app\controllers;

use app\models\Votings;
use app\models\VotingSearch;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class VotingController extends Controller
{
    public function actionUpdateCreate($id = null)
    {
        if (!is_null($id)) {
            $model = Votings::findOne($id);
        } else $model = new Votings();

        $title = 'Редактирование';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update_create', ['model' => $model, 'title' => $title]);
    }

    public function actionDelete($id): Response
    {
        $model = Votings::findOne($id);

        if (!is_null($model)) $model->delete();

        return $this->redirect(['index']);
    }

    public function actionIndex(): string
    {
        $searchModel = new VotingSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
