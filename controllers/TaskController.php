<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Task;
use app\models\Comment;
use app\models\Project;
use app\models\User;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class TaskController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can('pe')) {
                throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
            }
            return true;
        } else {
            return false;
        }
    }

    public function actionSogl()
    {
        $model = new Task();
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['user_id' => Yii::$app->user->identity->user_id ,'status_id' => 3]),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        return $this->render('sogl', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSoglinfo()    {
        $model = new Task();
        $modelcom = new Comment();
        $tasks = Task::findOne(Yii::$app->request->get('task_id'));
        $previous_task=Task::findOne($tasks->previous_task_id);
        $comments = Comment::find()->where(['task_id'=>Yii::$app->request->get('task_id')]);
        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $comments->count(),
        ]);

        $comments = $comments->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (Yii::$app->request->post('ok')) {
            $tasks->status_id=Yii::$app->request->post('ok');
            $tasks->save();
            return $this->goBack();
        }

        if (Yii::$app->request->post('cancel')) {
            $tasks->status_id=Yii::$app->request->post('cancel');
            $tasks->user_id=$tasks->project->pm_id;
            $tasks->save();
            $modelcom->text=Yii::$app->request->post('mtext');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->goBack();
        }

        if (Yii::$app->request->post('text')) {
            $modelcom->text=Yii::$app->request->post('text');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }

        return $this->render('soglinfo', [
            'model' => $model,
            'modelcom' => $modelcom,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'comments'=>$comments,
            'pagination' => $pagination,
        ]);
    }

    public function actionIsp()
    {
        $model = new Task();
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['user_id' => Yii::$app->user->identity->user_id ,'status_id' => 3]),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        return $this->render('isp', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIspinfo()    {
        $model = new Task();
        $modelcom = new Comment();
        $tasks = Task::findOne(Yii::$app->request->get('task_id'));
        $previous_task=Task::findOne($tasks->previous_task_id);
        $comments = Comment::find()->where(['task_id'=>Yii::$app->request->get('task_id')]);
        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $comments->count(),
        ]);

        $comments = $comments->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (Yii::$app->request->post('complete')) {
            $tasks->status_id=Yii::$app->request->post('complete');
            $tasks->save();
            return $this->goBack();
        }

        if (Yii::$app->request->post('cp')) {
            $tasks->complete_percentage=Yii::$app->request->post('cp');
            $tasks->save();
            return $this->refresh();
        }

        if (Yii::$app->request->post('text')) {
            $modelcom->text=Yii::$app->request->post('text');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }

        return $this->render('ispinfo', [
            'model' => $model,
            'modelcom' => $modelcom,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'comments'=>$comments,
            'pagination' => $pagination,
        ]);
    }

    public function actionCompl()
    {
        $model = new Task();
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['user_id' => Yii::$app->user->identity->user_id ,'status_id' => 3]),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        return $this->render('compl', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionComplinfo()    {
        $model = new Task();
        $modelcom = new Comment();
        $tasks = Task::findOne(Yii::$app->request->get('task_id'));
        $previous_task=Task::findOne($tasks->previous_task_id);
        $comments = Comment::find()->where(['task_id'=>Yii::$app->request->get('task_id')]);
        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $comments->count(),
        ]);

        $comments = $comments->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (Yii::$app->request->post('text')) {
            $modelcom->text=Yii::$app->request->post('text');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }

        return $this->render('complinfo', [
            'model' => $model,
            'modelcom' => $modelcom,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'comments'=>$comments,
            'pagination' => $pagination,
        ]);
    }

    public function actionIndex(){
        return $this->actionSogl();
    }
}