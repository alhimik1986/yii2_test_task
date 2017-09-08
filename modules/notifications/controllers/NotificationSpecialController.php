<?php

namespace app\modules\notifications\controllers;

use Yii;
use app\modules\notifications\models\NotificationSpecial;
use app\modules\notifications\models\NotificationSpecialSearch;
use app\modules\notifications\notifications\Notification;
use app\modules\notifications\models\Notification as NotificationModel;
use app\modules\users\models\UserModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * NotificationSpecialController implements the CRUD actions for NotificationSpecial model.
 */
class NotificationSpecialController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [ // Разрешено только создавать записи, смотреть и редактировать запрещено
                    [
                        'allow' => true,
                        'actions' => ['create', 'success'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all NotificationSpecial models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new NotificationSpecialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single NotificationSpecial model.
     * @param integer $id
     * @return mixed
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new NotificationSpecial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NotificationSpecial();

        $model->users = Yii::$app->request->post('users');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Запускаю выбранное уведомление
            $this->runNotification($model);
            return $this->redirect(['success', 'id' => $model->id]);
        } else {
            $model->body = $model->body ? $model->body : 'Уважаемый, {username}! На нашем сайте {site_url} добавлена новая новость: <a href="{new-link}">{new-title}</a> <br> {new-description}';
            return $this->render('create', [
                'model' => $model,
                'users' => NotificationSpecial::getUsers(),
            ]);
        }
    }

    public function actionSuccess($id)
    {
        return $this->render('success', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing NotificationSpecial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing NotificationSpecial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the NotificationSpecial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationSpecial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NotificationSpecial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Запуск выбранного уведомления
     */
    protected function runNotification($model)
    {
        $user_ids = array_keys($model->users);
        $users = UserModel::find()->andWhere(['id'=>$user_ids])->all();

        $notification = NotificationModel::findOne(['id'=>$model->notification_type_id]);
        $instance = new $notification->class_name();
        $instance->run($model->body, [
            'users' => UserModel::getUsersByRole('user'),
            'newsModel' => null,
        ]);
    }
}
