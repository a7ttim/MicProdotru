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
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Project;
use app\models\Task;
use app\models\Department;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = $project->name;
$this->params['breadcrumbs'][] = ['label' => \app\models\ProjectStatus::findOne(['status_id' => $project->status_id])->status_name, 'url' => ['list', 'status_id' => $project->status_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-info">
    <?php Pjax::begin(); ?>
    <h1>
        <?= $project->name ?>
    </h1>
    <p>
        <?= $project->description ?>
    </p>
    <p>
        <?php if($project->status_id==5) {echo Html::a('Редактировать',['updateproject', 'id' => $project->project_id],['class' => 'btn btn-info']);} ?>
        <?= Html::a('&#8801; Визуализация', ['gantt', 'project_id' => $project->project_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('+ Новая задача', ['createtask', 'project_id' => $project->project_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('+ Новая задача (Modal)', ['#'], ['data-toggle' => 'modal', 'data-target' => '#search', 'class' =>  'btn btn-success']) ?>
        <?
        Modal::begin([
            'options' => [
                'id' => 'search'
            ],
            'size' => 'modal-lg',
            'header' => '<h2>Новая задача</h2>',
            'footer' => 'MicPro.ru'
        ]);
        $model = new Task();

        if($project->status_id == 5)//на разработке
        {
            $model->status_id = 5;
        }
        else
        {
            $model->status_id = 1; //на согласовании
        }

        $model->complete_percentage = 0;

        $model->project_id = $project->project_id;
        ?>
        <?= $this->render('_taskform', [
            'model' => $model,
            'project' => $project,
        ]) ?>
    <?
    Modal::end();
    ?>
    <?= Html::a('Удалить', ['deleteproject', 'id' => $project->project_id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы дейстительно хотите удалить этот проект?',
            'method' => 'post',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>



    <?//= Html::beginForm('', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>

    <?= Html::submitButton(($project->status_id==5) ? '> На согласование': (($project->status_id==1) ? '> На исполнение':
        (($project->status_id==2) ? 'Завершить':'На разработку')),
        [
            'data' => (($project->status_id==2)&&($incompleted_tasks>0)) ? ['confirm' => 'Проект содердит '.$incompleted_tasks.' незавершенныых(ые) задач(и). Вы действительно хотите завершить проект?']:'',//надо как-то перенести наличие незавершенных задач из контроллера
            'name'=>'move',
            'value' => $project->project_id,
            'class' => 'btn btn-success btn-info',

        ]) ?>

    <?//= Html::endForm() ?>

    <?php ActiveForm::end(); ?>

    <?//= Html::a('> На исполнение', ['gantt', 'project_id' => $project->project_id], ['class' => 'btn btn-info']) ?>
    <!--        --><?php //echo CHtml::submitButton('Publish',array('disabled'=>($model->status==1)?true:false)); ?>




    </p>
    <div style="display:flex">
        <h4>Задачи на исполнении
            <span class="pull-right label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$count_isp?></span>
        </h4>
        <h4 style="margin-left: 1%">Задачи на согласовании
            <span class="pull-right label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$count_sogl?></span>
        </h4>
        <h4 style="margin-left: 1%">Завершенные задачи
            <span class="pull-right label label-pill label-success label-as-badge" style="margin-left:10px"><?=$count_compl?></span>
        </h4>
        <h4 style="margin-left: 1%">Отклоненные задачи
            <span class="pull-right label label-pill label-danger label-as-badge" style="margin-left:10px"><?=$count_cansl?></span>
        </h4>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'attribute' => 'status_id',
                'value' => 'status.status_name',
            ],

            [
                'attribute' => '',
                'value' => function (Task $task) {
                    return Html::a('<span class="fa fa-search"></span>Подробнее', Url::to(['showtask', 'id' => $task->task_id]), [
                        'title' => Yii::t('app', 'Подробнее'),
                        'class' =>'btn btn-info btn-xs',
                    ]);
                },
                'format' => 'raw',
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
