<?php

namespace app\modules\users\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\modules\users\models\LoginForm;
use app\modules\users\models\RegistrationForm;
use app\modules\users\models\UserModel as User;

class SignController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['out'],
                'rules' => [
                    [
                        'actions' => ['out'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'out' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Авторизация
     */
    public function actionIn()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('in', [
            'model' => $model,
        ]);
    }

    /**
     * Выход из системы
     */
    public function actionOut()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Регистрация
     */
    public function actionUp()
    {
        $model = new RegistrationForm;
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->getSession()->setFlash('success', 'Вы успешно зарегистрированы. Пожалуйста, зайдите в электронную почту и подтвердите свой аккаунт.');
            return $this->goHome();
        }
        return $this->render('up', [
            'model' => $model,
        ]);
    }

    /**
     * Подтверждение электронной почты
     */
    public function actionConfirmEmail($email_hash)
    {
        if (User::confirmEmail($email_hash)) {
            Yii::$app->getSession()->setFlash('success', 'Ваша аккаунт подтвержден.');
            return $this->redirect(Yii::$app->user->loginUrl);
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Неверная ссылка подтверждения аккаунта.');
            return $this->goHome();
        }
    }
}
