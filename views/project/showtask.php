<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Информация о задаче: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => \app\models\ProjectStatus::findOne(['status_id' => $project->status_id])->status_name, 'url' => ['list', 'status_id' => $project->status_id]];
$this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => ['info','project_id' => $project->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<!--//for comments (Anastasia added)-->
<?php
//$this->registerJs(
//    '$("document").ready(function(){
//        $("#new_note").on("pjax:end", function() {
//        $.pjax.reload({container:"#notes"});  //Reload GridView
//    });
//});'
//);
//?>

<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['updatetask', 'id' => $model->task_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['deletetask', 'id' => $model->task_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту задачу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'task_id',
            'name',
            //'project_id',
            'description',
            //'user_id',
            [                                                  // name свойство зависимой модели owner
                'label' => 'Исполнитель',
                'value' => $model->user->name,
                'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
            ],
            //'parent_task_id',
            //'previous_task_id',
            [
                'label' => 'Предыдущая задача',
                'value' => $model->previousTask->name,
                'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
            ],
            'start_date',
            'plan_duration',
            'fact_duration',
            'employment_percentage',
            //'status',
            [
                'label' => 'Статус',
                'value' => $model->status->status_name,
                'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
            ],
            'complete_percentage',
        ],
    ]) ?>
</div>

<div class="col-md-6">
    <table style="width: 100%">
        <thead>
        <tr>
            <th>
                Комментарии
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($comments))
        {
            foreach($comments as $comment)
            {?>
                <tr>
                    <td><?=$comment->user->name.", ".date('d.m.Y H:i',strtotime($comment->date_time))?></td>
                </tr>
                <tr>
                    <td><?=$comment->text?></td>
                </tr>
                <?php
            }
        }
        else
        {?>
            <tr>
                <td>Комментарии отсутствуют</td>
            </tr>
            <?php
        }?>
        </tbody>
    </table>
    <?= LinkPager::widget(['pagination' => $pagination]); ?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($modelcom, 'text')->textarea(['name'=>'text','maxlength' => true,'style'=>'resize:none;'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Добавить комментарий', ['class' =>  'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
