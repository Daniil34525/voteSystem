<?php

namespace app\controllers;

use app\models\Answers;
use app\models\Questions;
use app\models\QuestionSearch;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends Controller
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
                [
                    'allow' => true,
                    'actions' => ['index', 'update', 'create', 'delete'], // действия, к которым разрешен доступ
                    'roles' => ['admin'], // разрешен доступ для авторизованных администраторов
                ],
            ]
        );
    }

    /**
     * Lists all Questions models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Questions model.
     * @param int $id Идентификатор вопроса
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
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Questions();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $answersIds = $this->request->post()['answerIds'];
                $answerModels = Answers::find()->where(['question_id' => $model->id])->all();
                foreach ($answerModels as $answer) {
                    if (!array_key_exists($answer->id, $answersIds)) {
                        $answer->question_id = null;
                        $answer->save();
                    }
                    unset($answersIds[$answer->id]);
                }
                foreach ($answersIds as $key => $status) {
                    if ($status == 1) {
                        $answer = Answers::find()->where(['id' => $key])->one();
                        $answer->question_id = $model->id;
                        $answer->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        if (is_null($model->id))
            $answers = Answers::find()->where(['or', ['question_id' => null], ['question_id' => $model->id]])->select(['id', 'title', 'question_id'])->all();
        else
            $answers = Answers::find()->where(['question_id' => null])->select(['id', 'title', 'question_id'])->all();
        return $this->render('create', [
            'model' => $model,
            'answers' => $answers
        ]);
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Идентификатор вопроса
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $answersIds = $this->request->post()['answerIds'];
            $answerModels = Answers::find()->where(['question_id' => $model->id])->all();
            foreach ($answerModels as $answer) {
                if (!array_key_exists($answer->id, $answersIds)) {
                    $answer->question_id = null;
                    $answer->save();
                }
                unset($answersIds[$answer->id]);
            }
            foreach ($answersIds as $key => $status) {
                if ($status == 1) {
                    $answer = Answers::find()->where(['id' => $key])->one();
                    $answer->question_id = $model->id;
                    $answer->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $answers = Answers::find()->where(['or', ['question_id' => null], ['question_id' => $model->id]])->select(['id', 'title', 'question_id'])->all();
        return $this->render('update', [
            'model' => $model,
            'answers' => $answers
        ]);
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Идентификатор вопроса
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionModalContent()
    {
        // Получение id вопроса из метода post:
        $questionId = $this->request->post()['questionId'];
        $answer = new Answers();
        if ($this->request->isPost && $answer->load($this->request->post()) && $answer->save()) {
            $url = Url::to(['answer/view', 'id' => $answer->id]);
            $text = Html::a($answer->title, $url);
            $checkbox = Html::checkbox('answerIds[' . $answer->id . ']', true, ['class' => 'checkbox']);
            $divTitle = Html::tag('div', $text, ['style' => 'margin-left: 20px']);
            $html = Html::tag('div', $checkbox . $divTitle, ['style' => 'display: flex']);
            return $this->asJson(['result' => 'ok', 'html' => $html]);
        }
        if (!is_null($questionId))
            $answer->question_id = $questionId;
        return $this->renderAjax('modal-content', ['model' => $answer]);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Идентификатор вопроса
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): ActiveRecord
    {
        if (($model = Questions::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
