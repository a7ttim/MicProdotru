<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 01.05.2017
 * Time: 18:12
 */


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $model app\models\project */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Project;
use app\models\Task;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = $project->name;
$this->params['breadcrumbs'][] = ['label' => \app\models\Status::findOne(['status_id' => $project->status_id])->status_name, 'url' => ['list', 'status_id' => $project->status_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>
    <?= $project->name ?>
</h1>
<p>
    <?= $project->description ?>
</p>
<p>
    <?= Html::a('&#8801; Визуализация', ['gantt', 'project_id' => $project->project_id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('+ Новая задача', ['createtask', 'project_id' => $project->project_id], ['class' => 'btn btn-success']) ?>
    <?= Html::a('> На исполнение', ['gantt', 'project_id' => $project->project_id], ['class' => 'btn btn-info']) ?>
</p>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'task_id',
        'name',
        //'project_id',
//        [
//            'attribute' => 'project_id',
//            'value' => 'project.name',
//        ],
        //'user_id',
        [
            'attribute' => 'user_id',
            'value' => 'user.name',
        ],
        [
            'attribute' => 'description',
            'format' => 'text',
            'value' => function ($model){
                return StringHelper::truncate($model->description, 25);
            }
        ],
        // 'parent_task_id',
        // 'previous_task_id',
        // 'start_date',
        // 'plan_end_date',
        // 'fact_end_date',
//        'employment_percentage',
        [
            'attribute' => 'employment_percentage',
            'value' => function (Task $task) {
                return Html::decode(\app\components\ProgressBarWidget::widget([
                    'value' => $task->employment_percentage,
                ]));
            },
            'format' => 'html',
        ],
//       'status_id',
//            [
//                'attribute' => 'status',
//                'value' => 'status.status_name',
//            ],
//        [
//            'attribute' => 'status',
//            'filter' => array("1"=>"На согласовании","2"=>"На исполнении","3"=>"Завершена","4"=>"Удалена","5"=>"На исполнении"),
//        ],

//        'complete_percentage',
        [
            'attribute' => 'complete_percentage',
            'value' => function (Task $task) {
                return Html::decode(\app\components\ProgressBarWidget::widget([
                        'value' => $task->complete_percentage,
                ]));
            },
            'format' => 'html',
            'contentOptions' => ['style' => 'width:200px;'],
        ],

        [
            'attribute' => 'Подробнее',
            'value' => function (Task $task) {
                return Html::a('Подробнее', Url::to(['showtask', 'id' => $task->task_id]));
            },
            'format' => 'raw',
        ],

    ],
]); ?>