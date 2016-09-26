<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/24
 * Time: 21:35
 */
namespace frontend\controllers;

use common\models\base\Course;
use common\models\base\CourseParticipants;
use common\models\base\CourseTeacher;
use common\models\base\Profile;
use dosamigos\datepicker\DatePicker;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CourseController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','course-list','viewer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['editor','teacher-index'],
                        'allow' => true,
                        'roles' => ['Teacher'],
                    ],
                    [
                        'actions' => ['my-courses'],
                        'allow' => true,
                        'roles' => ['Student'],
                    ],
                    [
                        'actions' => ['class'],
                        'allow' => true,
                        'roles' => ['Teacher', 'Student'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect('/course/my-courses');
    }


    public function actionEditor($id='')
    {
        $classModel = new CourseParticipants();
        $classes = [];
        if($id=='' || ($model=Course::findOne($id))==null) {
            $model = new Course();
        }
        else {
            $classModel->user_id = Yii::$app->user->id;
            $classModel->course_id = $model->id;
            if($classModel->load(Yii::$app->request->post()) && $classModel->validate())
                $classModel->save();
            $classes = CourseParticipants::findAll(['course_id'=>$model->id]);
        }
        if(isset($model->teacher_id) && $model->teacher_id!=Yii::$app->user->id)
            throw new ForbiddenHttpException();
        else
            $model->teacher_id = Yii::$app->user->id;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->save()){
                $type = $model->isNewRecord?'creation':'modification';
                Yii::$app->session->setFlash('success','Course '.$type.' succeeds.');
                return $this->redirect('/course/');
            }
            Yii::$app->session->setFlash('error','Something wrong happened with database. Please wait for a minute and retry or contact the admin.');
        }
        return $this->render('editor',[
            'model' => $model,
            'classModel' => $classModel,
            'classes' => $classes
        ]);
    }

    public function actionViewer($id='')
    {
        $model = Course::findOne($id);
        if($model==null)
            throw new NotFoundHttpException();
        return $this->render('viewer',[
            'model' => $model
        ]);
    }

    public function actionMyCourses()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Yii::$app->user->can("Teacher")?Course::find()->where(['teacher_id'=>Yii::$app->user->id]):Yii::$app->user->identity->profile->getCourses(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('course-list',[
            'dataProvider' => $dataProvider,
            'itemView' => 'course-view',
            'viewParams' => [
                'edit' => Yii::$app->user->can("Teacher"),
            ],
        ]);
    }

    public function actionCourseList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Course::find()->orderBy('start_at desc'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('course-list',[
            'dataProvider' => $dataProvider,
            'itemView' => 'course-view',
            'viewParams' => [
                'edit' => false,
            ],
        ]);
    }

    public function actionClass($course_id,$name)
    {
        if(!Yii::$app->user->can('Teacher'))
        {
            if(CourseParticipants::findOne(['course_id'=>$course_id,'name'=>$name])==null)
                throw new NotFoundHttpException();
            CourseParticipants::deleteAll(['course_id'=>$course_id, 'user_id'=>Yii::$app->user->id]);
            $cp = new CourseParticipants();
            $cp->course_id = $course_id;
            $cp->name = $name;
            $cp->user_id = Yii::$app->user->id;
            $cp->save()?Yii::$app->session->setFlash('success','Welcome to new class.'):Yii::$app->session->setFlash('warning','Oops...Something wrong.');
            return $this->redirect('/course/my-courses');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => CourseParticipants::find()->where(['course_id'=>$course_id,'name'=>$name])->with('user'),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
        return $this->render('class',[
            'course_id' => $id,
            'name' => $name,
            'dataProvider' => $dataProvider
        ]);
    }

}