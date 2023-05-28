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
        if ($votingModel = Votings::find()->where(['id' => $id])->one())
            return $this->render('elections', ['votingModel' => $votingModel]);
        return $this->redirect('select', 301);
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

        $votersList = $user->voterLists;

        $enabled_votings = [];

        foreach ($votersList as $list) {
            $enabled_votings[] = $list->votings;
        }

        return $this->render('voting_select', ['votings' => $enabled_votings]);
    }
}
