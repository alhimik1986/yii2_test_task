<?php

namespace app\modules\news\controllers;

use Yii;
use app\modules\news\models\News as Model;
use app\modules\news\models\NewsSearch as SearchModel;;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $model = Model::findOne(Yii::$app->request->get('id'));

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['viewNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createNews'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['editNews', 'editOwnNews'],
                        'roleParams' => ['model' => $model],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteNews', 'deleteOwnNews'],
                        'roleParams' => ['model' => $model],
                    ],
                ],
            ],
        ];
    }

    /**
     * Идентификатов, добавляемый в названия id элементов.
     */
    public $modelId = 'news';

    /**
     * @return mixed Список всех записей
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $this->modelId,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed Отображает информацию о модели
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', ['model' => $this->findModel($id), 'id' => $this->modelId]);
    }

    /**
     * @return mixed Создает запись
     */
    public function actionCreate()
    {
        $model = new Model();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'ok';
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'id' => $this->modelId,
            ]);
        }
    }

    /**
     * @param integer $id Редактирование
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'ok';
        } else {
            return $this->renderAjax('_form', ['model' => $model, 'id' => $this->modelId]);
        }
    }

    /**
     * @param integer $id Удаление
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return 'ok';
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
