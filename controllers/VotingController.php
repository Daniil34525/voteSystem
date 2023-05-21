<?php

namespace app\controllers;

use app\models\Votings;
use app\models\VotingSearch;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\BulletinsList;

class VotingController extends Controller
{
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
                foreach($bulletins_id as $bull_id) {
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

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
