<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Page;
use frontend\models\Destination;
use frontend\models\Category;
use frontend\models\Tour;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','img-delete','admin'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['admin'],
                        'allow' => true,
                        'roles' => ['userIndex'],
                    ],
                    [
                        'actions' => ['img-delete'],
                        'allow' => true,
                        'roles' => ['admin'],
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
     * {@inheritdoc}
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
        $this->layout='wide';
        //$page = Page::find()->where(['category'=>'main'])->one();
        $page = Yii::$app->cache->getOrSet('page-main', function () {
            return Page::find()->where(['category'=>'main'])->one();
        }, 0);
        $destinations = Yii::$app->cache->getOrSet('destination', function () {
            return Destination::find()->all();
        }, 0);
        $categories= Yii::$app->cache->getOrSet('category', function () {
            return Category::find()->all();
        }, 0);

        $tours=Tour::find()->orderBy('id DESC')->limit(12)->all();

        return $this->render('index',[
            'page'=>$page,
            'destinations'=>$destinations,
            'categories'=>$categories,
            'tours'=>$tours
        ]);
    }

    public function actionAdmin()
    {
        $this->layout='backend';
        return $this->render('admin');
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
            $model->password = '';

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
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
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
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

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
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionImgDelete($id,$model_name)
    {
        $key=Yii::$app->request->post('key');
        $webroot=Yii::getAlias('@webroot');
        if(is_dir($dir=$webroot."/images/{$model_name}/".$id))
        {
            if(is_file($dir.'/'.$key)){
                @unlink($dir.'/'.$key);
                @unlink($dir.'/s_'.$key);
                $dao=Yii::$app->db;
                $row = $dao->createCommand("SELECT images FROM {$model_name} WHERE id='{$id}'")->queryOne();
                $exp=explode(';',$row['images']);
                $newSet=[];
                foreach($exp as $img){
                    if($img!=$key){$newSet[]=$img;}
                }
                $newSetStr=implode(';',$newSet);
                Yii::$app->db->createCommand("UPDATE {$model_name} SET images='{$newSetStr}' WHERE id='{$id}'")->execute();
            }
        }
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return true;
    }

    public function actionImgSort(){
        $request=Yii::$app->request;
        $model=$request->post('model_name');
        $id=$request->post('model_id');
        $webroot=Yii::getAlias('@webroot');
        $dir=$webroot."/images/{$model}/".$id;
        $images=[];
        if($stacks=$request->post('stack')){
            foreach($stacks as $key=>$stack){
                if(is_file($file=$dir.'/'.$stack['key'])){
                    $images[]=$stack['key'];
                }
            }
        }
        if($images){
            $images_str=implode(';',$images);
            $dao=Yii::$app->db;
            $dao->createCommand("UPDATE {$model} SET images='{$images_str}' WHERE id='{$id}'")->execute();
        }
    }

    public function actionTest(){
        $webroot=Yii::getAlias('@webroot');
        $scan=scandir($dir=$webroot."/images/destination/3");
        print_r($scan);
    }

    public function actionLang($to){
        $session=Yii::$app->session;
        $cookies = Yii::$app->response->cookies;

        if($to=='en-US'){
            $session->remove('language');
            $cookies->remove('language');
        }
        else{
            Yii::$app->language=$to;
            $session->set('language', $to);
            $cookies->add(new \yii\web\Cookie(['name' => 'language','value' => $to]));
        }
        Yii::$app->cache->flush();
        $this->redirect(Yii::$app->request->referrer);

    }
}
