<?php

namespace app\controllers;

use app\models\Answers;
use app\models\Bulletins;
use app\models\Votings;
use app\models\VotingSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use app\models\BulletinsList;
use app\models\Users;
use app\models\VotersList;
use app\models\UsersList;


class VotingController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'update-create', 'delete', 'control'], // действия, к которым разрешен доступ
                            'roles' => ['admin'], // разрешен доступ для авторизованных администраторов
                        ],
                        [
                            'allow' => true,
                            'actions' => ['elections', 'show-answers'], // действия, к которым разрешен доступ
                            'roles' => ['@'], // разрешен доступ для авторизованных
                        ],
                        [
                            'allow' => true,
                            'actions' => ['select', 'selected-bulletin'],
                            'roles' => ['user'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionUpdateCreate($id = null)
    {
        // UPDATE:
        if (!is_null($id)) {
            $model = Votings::findOne($id);
        } else $model = new Votings();

        $title = 'Редактирование';

        // В модель загружаются данные из формы через POST:
        if ($model->load(Yii::$app->request->post())) {

            // Из POST получаем массив отмеченных бюллетеней (их id);
            $bulletins_id = $_POST['bulletins'];

            // Если записи в BulletinsList с id текущего голосования существуют:
            if (!is_null($id) and BulletinsList::find()->where(['voting_id' => $id])->exists()) {
                BulletinsList::deleteAll(['voting_id' => $id]);
            }

            if (!is_null($bulletins_id)) {
                // ПИСАЛ ГЕНИЙ - НЕ ТРОГАТЬ !
                foreach ($bulletins_id as $bull_id) {
                    $bulletins_list = new BulletinsList();
                    $bulletins_list->voting_id = $model->id;
                    $bulletins_list->bulletin_id = $bull_id;
                    $bulletins_list->save();
                }
            }
            // Сохраненине voting:
            $model->save();

            return $this->redirect('index');
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

        $title = 'Голосования';

        return $this->render('index', ['title' => $title, 'dataProvider' => $dataProvider]);
    }

    /**
     * Экшен позволяет работать с процессом голосования
     * @param int|null $id Пользователя
     * @return string|Response
     */
    public function actionElections(int $id = null)
    {
        if ($this->request->isPost) {
            $post = $this->request->post();
            $answersIds = $post['answer'];
            if (is_iterable($answersIds))
                foreach ($answersIds as $key => $ids) {
                    $answer = Answers::find()->where(['id' => $key])->one();
                    $voters = $answer->voters;
                    $userId = Yii::$app->user->id;
                    $a = Yii::$app->authManager->getRolesByUser($userId);
                    $voters[array_key_first($a)][] = $userId;
                    $answer->voters = $voters;
                    $answer->save();
                }
            return $this->redirect('index');
        }
        $votingModel = Votings::find()->where(['id' => $id])->one();
        return $this->render('elections', ['votingModel' => $votingModel]);
    }

    /**
     * Экшен позволяет показать ответы на вопросы
     * @param $id
     * @return string
     */
    public function actionShowAnswers($id = null)
    {
        if ($votingModel = Votings::find()->where(['id' => $id])->one())
            return $this->render('answers', ['votingModel' => $votingModel]);
        else $this->redirect('select');
    }



    /**
     * Экшен позволяет выбирать из доступных голосований
     * @return string
     */
    public function actionSelect(): string

    {
        /**
         * @var Users $user
         * @var VotersList[] $votersList
         */


        $user = Users::find()->where(['id' => Yii::$app->user->id])->one();

        // Получение массива списков участников голосований, к которым относится текущеий пользователь:
        $votersList = $user->voterLists; // Массив моделей VotersList:

        $enabled_votings = [];

        // Для каждого элемента из массива моделей VotersList:
        foreach ($votersList as $list) {


            $enabled_votings[] = $list->votings;
        }
        // $enabled_votings = {
        // [0] => [массив голосований для первого списка голосущих]
        // }

        return $this->render('voting_select', ['data' => $enabled_votings]);
    }

    public function actionControl($id)
    {
        if ($model = Votings::find()->where(['id' => $id])->one())
            return $this->render('control', ['model' => $model]);
        else return $this->redirect('index');
    }

    public function actionSelectedBulletin($votingId, $bulletinId): Response
    {
        $modelBulletin = Bulletins::find()->where(['id' => $bulletinId])->one();

        if ($modelBulletin->is_selected) return $this->asJson(['result' => 'no']);
        $voting = Votings::find()->where(['id' => $votingId])->one();
        if (!is_iterable($voting->bulletins)) return $this->asJson(['result' => 'no']);
        foreach ($voting->bulletins as $bulletin) {
            if ($bulletin->is_selected) $modelBulletin = $bulletin;
        }
        $divQuestion = '';
        if (!is_iterable($modelBulletin->questions)) $divQuestion = 'В этой бюллетени нет вопросов!';
        else foreach ($modelBulletin->questions as $question) {
            $title = $question->question_title;
            $divOverview = Html::tag('div', Html::tag('p', $question->overview), ['class' => 'card-body']);
            $divAnswer = '';
            if (!is_iterable($question->answers)) $divAnswer = 'В этом вопросе нет представленных ответов!';
            else foreach ($question->answers as $answer) {
                $checkbox = Html::checkbox("answer[$answer->id]", false, ['id' => 'answer' . $answer->id]);
                $label = Html::label($answer->title, 'answer[' . $answer->id . ']');
                $divAnswer .= Html::tag('div', $checkbox . $label);
            }
            $divAnswers = Html::tag('div', $divAnswer, ['class' => 'card']);
            $divQuestion .= Html::tag('div', $title . $divOverview . $divAnswers, ['class' => 'card', 'style' => 'margin-bottom:10px;']);
        }
        $divQuestions = Html::tag('div', $divQuestion, ['class' => 'card']);
        $resultDiv = Html::tag('div', Html::tag('p', $modelBulletin->title) . $divQuestions, ['class' => 'card']);
        return $this->asJson(['result' => 'ok', 'html' => $resultDiv, 'id' => $modelBulletin->id]);
    }
}
