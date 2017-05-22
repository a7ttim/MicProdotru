<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

namespace app\controllers;

use app\models\Comment;
use app\models\Project;
use app\models\Task;
use app\models\User;
use Faker\Provider\DateTime;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class ProjectController extends Controller
{
    // Статусы
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (!\Yii::$app->user->can('pm')) {
				throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
			}
			return true;
		} else {
			return false;
		}
	}

    public function actionCreateproject()
    {
        $model = new project();
        $model->pm_id=Yii::$app->user->identity->user_id;
        $model->status_id =5;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['showproject', 'id' => $model->project_id]);
        } else {
            return $this->render('createproject', [
                'model' => $model,
            ]);
        }
    }

    public function actionShowproject($id)
    {
        return $this->render('showproject', [
            'model' => $this->findProjectModel($id),
        ]);
    }

    public function actionUpdateproject($id)
    {
        $model = $this->findProjectModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['showproject', 'id' => $model->project_id]);
        } else {
            return $this->render('updateproject', [
                'model' => $model,
            ]);
        }
    }


    public function actionList()
    {
        $model = new Project();
        $status_id = Yii::$app->request->get('status_id');
        if(!($status_id > 0)) $status_id = 1;
        $dataProvider = new ActiveDataProvider([
            'query' => Project::find()->where(['and',['pm_id' => Yii::$app->user->identity->user_id],['status_id'=> $status_id]]),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('list', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'status_id' => $status_id,
        ]);
    }


    public function actionInfo()    {
        $model = new Task();
        $proj_id=Yii::$app->request->get('project_id');
        $project = Project::findOne(['project_id' => $proj_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $project->getTasks()->with('user'),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        //Actions for project (move status)
        if (Yii::$app->request->post('move')) {

            if ($project->status_id==5) //На разработке
            {
                $project->status_id=1; //На согласовании
                //here will be the logic for mail
                // emailto();

            }
            elseif ($project->status_id==1){$project->status_id=2;} //На исполнение
            elseif ($project->status_id==2){$project->status_id=3;} //В завершенные
            else {$project->status_id=5;} //Удаленные или завершенные восстановить - в разработку

            $project->save();
            return $this->redirect(['list','status_id' =>$project->status_id]);
        }


        return $this->render('info', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'project' => $project, // breadcrumbs
        ]);
    }

    public function actionGantt($project_id)
    {
        $project = Project::findOne(['project_id' => $project_id]);

        return $this->render('gantt', [
            'project' => $project,
            'tasks' => $project->getTasks()->all(),
            'users' => $project->getUsers()->all(),
            'links' => $project->getTasks()->where(['not',['parent_task_id'=>null]])->all(),
        ]);
    }

    public function actionCreatetask()
    {
        $model = new Task();
        $model->status_id=5;
        $model->complete_percentage=0;
        $model->project_id= Yii::$app->request->get('project_id');

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['showtask', 'id' => $model->task_id]);
        } else {
            return $this->render('createtask', [
                'model' => $model,
                'project' => Project::findOne(['project_id' => Yii::$app->request->get('project_id')]), // Для breadcrumbs, в $model->project_id пусто :C
            ]);
        }
    }

    protected function findTaskModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShowtask($id)
    {
        $modelcom = new Comment();
        $comments = Comment::find()->where(['task_id'=>$id]);
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
            $modelcom->task_id=$id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }


        return $this->render('showtask', [
            'model' => $this->findTaskModel($id),
            'modelcom' => $modelcom,
            'comments'=> $comments,
            'pagination' => $pagination,
            'project' => Project::findOne(['project_id' => $this->findTaskModel($id)->project_id]), // Для breadcrumbs
        ]);
    }

    public function actionUpdatetask($id)
    {
        $model = $this->findTaskModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['info','project_id' =>$model->project_id]);
        } else {
            return $this->render('updatetask', [
                'model' => $model,
                'project' => Project::findOne(['project_id' => $model->project_id]), // Для breadcrumbs
            ]);
        }
    }

    public function actionDeletetask($id)
    {
        $model = $this->findTaskModel($id);

        $comment= new Comment();
        $comment->user_id=1;
        $comment->task_id=$model->task_id;
        $comment->date_time=time();
        //$user=User::findOne(Yii::$app->user->identity->user_id);
        //$user_name=
        $comment->text='Задача удалена';
        $comment->save();
        $model->status_id=4;
        $model->save();
        return $this->redirect(['info','project_id' =>$model->project_id]);
    }

    protected function findProjectModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteproject($id)
    {
        $model=$this->findProjectModel($id);
        $model->status_id=4;
        $model->save();

        return $this->redirect(['list']);
    }

    public function actionIndex(){
        return $this->actionList();
    }
}