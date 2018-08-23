<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\User;
use api\modules\v1\models\UserAnswer;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * User Controller API
 */
class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';
    public $createScenario = 'create';
    public $updateScenario = 'update';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Adding Http Bearer Authentication
//        $behaviors['authenticator'] = [
//            'class' => HttpBearerAuth::className(),
//            'except' => ['options', 'create', 'login', 'email-exists']
//        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if (!in_array($action, ['index', 'create'])) {
            $identity = Yii::$app->user->identity;
            /** @type $model User */
            if (!empty($identity) && ($identity->getId() == $model->id))
                parent::checkAccess($action, $model, $params);
            else
                throw new ForbiddenHttpException('User has no access to this object');
        }
        else parent::checkAccess($action, $model, $params);
    }

    /**
     * Logs in the user and return it's model
     * @return User
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $user = User::findOne(['username' => $request->post('username')]);

        if (empty($user)) {
            throw new NotFoundHttpException('User not found');
        }

        if (Yii::$app->getSecurity()->validatePassword($request->post('password'), $user->encrypted_password)) {
            Yii::$app->user->login($user);
            return $user;
        }
        throw new ForbiddenHttpException();
    }

    /**
     * Logs in the user and return it's model
     * @return User
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionToken()
    {
        $request = Yii::$app->request;
        $user = User::findIdentityByAccessToken($request->post('access_token'));

        if (empty($user)) {
            throw new NotFoundHttpException('User not found');
        }
        Yii::$app->user->login($user);
        return $user;
    }

    /**
     * Check the email if it exists and sends HTTP status
     * if found or not.
     */
    public function actionEmailExists()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->getResponse();

        if ($request->post('email')) {
            $user = User::findOne(['email' => $request->post('email')]);
            if (empty($user)) $response->setStatusCode(404);
            else $response->setStatusCode(200);
        } else $response->setStatusCode(400);
    }
}