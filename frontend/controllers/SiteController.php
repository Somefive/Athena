<?php
namespace frontend\controllers;

use common\models\base\Message;
use common\models\base\Profile;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Console;
use yii\rbac\Role;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'profile','validate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['students'],
                        'allow' => true,
                        'roles' => ['Teacher'],
                    ],
                    [
                        'actions' => ['chat-to'],
                        'allow' => true,
                        'roles' => ['Teacher','Student'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout = "main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        $this->layout = "main-login";
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
        $this->layout = "main-login";
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }
        $this->layout = "main-login";
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        /* @var $model Profile */
        /* @var $user User */
        $user = Yii::$app->user->identity;
        $model = $user->profile;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save()?Yii::$app->session->setFlash('success','Profile update succeeds.'):Yii::$app->session->setFlash('error','Something wrong happened with database. Please wait for a minute and retry or contact the admin.');
        }

        return $this->render('profile',[
            'model' => $model,
        ]);
    }

    public function actionValidate()
    {
        if(Yii::$app->user->can("Teacher"))
        {
            $orimsg = Message::findOne(Yii::$app->request->get('id'));
            $op = Yii::$app->request->get('type');
            if(!empty($orimsg)){
                $responseMsg = new Message([
                    'from' => Yii::$app->user->id,
                    'to' => $orimsg->from,
                    'type' => Message::TYPE_PLAIN_TEXT,
                ]);
                if ($op == 'agree') {
                    $responseMsg->content = "Your validation request has been accepted.";
                    Yii::$app->authManager->assign(Yii::$app->authManager->createRole('Student'),$orimsg->from);
                    $orimsg->delete();
                    $responseMsg->save();
                } else if ($op == 'disagree') {
                    $responseMsg->content = "Your validation request has been rejected.";
                    $orimsg->delete();
                    $responseMsg->save();
                }
                Yii::$app->session->setFlash('success','Response sent.');
            }

            $requests = Message::findAll(['type'=>Message::TYPE_VALIDATION_REQUEST]);
            $data = [];
            foreach($requests as $request){
                $profile = Profile::findOne($request->from);
                if(empty($profile)) continue;
                array_push($data,[
                    'message_id' => $request->id,
                    'created_at' => $request->created_at,
                    'school_id' => $profile->school_id,
                    'name' => $profile->full_name,
                    'gender' => $profile->gender,
                    'department' => $profile->department,
                    'class' => $profile->class,
                    'contact' => $profile->contact,
                ]);
            }
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort' => [
                    'attributes' => ['created_at', 'school_id'],
                ],
            ]);
            return $this->render('validate',[
                'dataProvider' => $dataProvider
            ]);
        }
        else if(Yii::$app->user->can("Student"))
        {
            Yii::$app->session->setFlash('primary','You have already been validated.');
            return $this->goBack();
        }
        else
        {
            if(Message::findOne(['from'=>Yii::$app->user->id,'type'=>Message::TYPE_VALIDATION_REQUEST]))
                Yii::$app->session->setFlash('success','Your request has already been sent. Please wait.');
            else {
                $msg = new Message();
                $msg->from = Yii::$app->user->id;
                $msg->to = 0;
                $msg->type = Message::TYPE_VALIDATION_REQUEST;
                $msg->save()?Yii::$app->session->setFlash('success','Your request has already been sent successfully! Please wait.'):Yii::$app->session->setFlash('error','Oops. Sorry, something wrong happened.');
            }
            return $this->goBack();
        }
    }

    public function actionStudents()
    {
        Yii::$app->user->setReturnUrl('/site/students');
        $profiles = Profile::find()->all();
        $data = [];
        foreach($profiles as $profile) {
            /* @var $profile Profile */
            if(Yii::$app->authManager->checkAccess($profile->id,'Student'))
                array_push($data,[
                    'user_id' => $profile->id,
                    'school_id' => $profile->school_id,
                    'name' => $profile->full_name,
                    'nickname' => $profile->nickname,
                    'gender' => $profile->gender,
                    'department' => $profile->department,
                    'class' => $profile->class,
                    'contact' => $profile->contact
                ]);
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'attributes' => ['school_id', 'department', 'name'],
            ],
        ]);
        return $this->render('students',[
            'dataProvider' => $dataProvider,
            'message' => new Message(),
        ]);
    }

    public function actionChatTo()
    {
        $msg = new Message();
        if($msg->load(Yii::$app->request->post()) && ($msg->from=Yii::$app->user->id) && $msg->validate())
            $msg->save()?Yii::$app->session->setFlash('success','message sent.'):Yii::$app->session->setFlash('error','message failed');
        return $this->goBack();
    }

}
