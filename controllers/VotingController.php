<?php

namespace app\controllers;

use app\models\Answers;
use app\models\Votings;
use app\models\VotingSearch;
use Yii;
use yii\filters\AccessControl;
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
                            'actions' => ['index', 'update-create', 'delete'], // действия, к которым разрешен доступ
                            'roles' => ['admin'], // разрешен доступ для авторизованных администраторов
                        ],
                        [
                            'allow' => true,
                            'actions' => ['elections', 'show-answers', 'select'], // действия, к которым разрешен доступ
                            'roles' => ['@'], // разрешен доступ для авторизованных
                        ],
                        [
                            'allow' => true,
                            'actions' => ['select'],
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

    public function actionElections($id = null)
    {
        if ($this->request->isPost) {
            $post = $this->request->post();
            $answersIds = $post['answer'];
            if (is_iterable($answersIds))
                foreach ($answersIds as $key => $id) {
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

    public function actionShowAnswers($id = null): string
    {
        $votingModel = Votings::find()->where(['id' => $id])->one();
        return $this->render('answers', ['votingModel' => $votingModel]);
    }

    // Метод для получения всех голсований, которе оносятся к текущему пользователю:
    public function actionSelect($user_id = null)
    {
        /**
         * @var Users $user
         * @var VotersList[] $votersList
         */
        // Получение самного пользователя:
        $user = Users::find()->where(['id' => $user_id])->one();

        // Получение массива списков участников голосований, к которым относится текущеий пользователь:
        $votersList = $user->voterLists; // Массив моделей VotersList:

        $enabled_votings = [];

        // Для каждого элемента из массива моделей VotersList:
        foreach ($votersList as $list) {
            // Получаем опредленное количество голований,
            // в которые может входить один и тоже VotersList (список голосующих):
            $enabled_votings[] = $list->votings;
        }
        // $enabled_votings = {
        // [0] => [массив голосований для первого списка голосущих]
        // }

        return $this->render('voting_select', ['data' => $enabled_votings]);
    }
}
