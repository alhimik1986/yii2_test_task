<?php

namespace app\modules\news\controllers;

use Yii;
use app\modules\news\models\News as Model;
use app\modules\news\models\PreviewNewsSearch as ModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * ListController implements the CRUD actions for News model.
 */
class ListController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['detail', 'i-know'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function afterAction($action, $result)
    {
        // Событие (авторизованный пользователь посетил страницу новостей)
        if ( ! Yii::$app->user->isGuest) {
            if ($action->id == 'index' OR $action->id == 'detail') {
                Yii::$app->newsEvents->trigger(Yii::$app->newsEvents::EVENT_NEWS_LIST_VISITED);
            }
        }
        return parent::afterAction($action, $result);
    }

    /**
     * @return mixed Список новостей
     */
    public function actionIndex()
    {
        $searchModel = new ModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed Полный текст новости
     */
    public function actionDetail($id)
    {
        return $this->render('detail', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionIKnow()
    {
        \app\modules\notifications\models\NewsNotifier::setLastNews();
        \app\modules\notifications\models\SpecialNotifier::resetUserNotifications();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Поиск модели по первичному ключу
     * Если модель не найдена, то выбрасывается исключение 404 HTTP .
     * @param integer $id
     * @return Модель
     * @throws NotFoundHttpException Если модель не найдена
     */
    protected function findModel($id)
    {
        if (($model = Model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
