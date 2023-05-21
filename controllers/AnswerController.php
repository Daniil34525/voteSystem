<?php

namespace app\controllers;

use app\models\Answers;
use app\models\AnswerSearch;
use Yii;
use yii\web\Controller;
use yii\web\Response;

// TODO: Временное решение, пока нет контроллера к вопросам, к которым будут создаваться ответы
class AnswerController extends Controller
{
    public function actionUpdateCreate($id = null, $questionId = null)
    {
        if (!is_null($id)) {
            $model = Answers::findOne($id);
        } else $model = new Answers();
        if (!is_null($questionId)) $model->question_id = $questionId;

        $title = 'Редактирование';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update_create', ['model' => $model, 'title' => $title]);
    }

    /**
     * TODO: пока временный вариант, используется в редактировании вопроса
     * @param $id
     * @return string|Response
     */
    public function actionView($id)
    {
        if (!is_null($id)) {
            $model = Answers::findOne($id);
        } else $model = new Answers();

        $title = 'Редактирование';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update_create', ['model' => $model, 'title' => $title]);
    }

    public function actionDelete($id): Response
    {
        $model = Answers::findOne($id);

        if (!is_null($model)) $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id int|null ID вопроса(при переходе от вопроса к редакции ответов, планируется список всех ответов на вопросы с
     * выводом наименования самого вопроса), нужно подумать нужен ли такой функционал
     * @return string
     */
    public function actionIndex(int $id = null): string
    {
//        $models = Answers::find()->andFilterWhere(['id' => $id])->all();
        $searchModel = new AnswerSearch();
        $params = array_merge(Yii::$app->request->queryParams, ['id' => $id]);
        $dataProvider = $searchModel->search($params);

        $title = 'просмотр ответов к конкретному вопросу';

        return $this->render('index', ['title' => $title, 'dataProvider' => $dataProvider]);
    }
}
