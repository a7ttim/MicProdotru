<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
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
                'confirm' => 'Вы дейстительно хотите удалить эту заачу?',
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
            //'start_date',
            //'plan_end_date',
            //'fact_end_date',
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


<!--for comments (Anastasia added)-->
<!--<h2>Комментарии</h2>-->
<!--<div>-->
<!--        --><?php //yii\widgets\Pjax::begin(['id' => 'new_note']) ?>
<!--        --><?php //$form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
<!---->
<!--<!--    -->--><?////=$form->field($comments, 'text')->textarea(['rows' => 6]) ?>
<!---->
<!--        <div class="form-group">-->
<!--            --><?//= Html::submitButton('+', ['class' => 'btn btn-success']) ?>
<!--        </div>-->
<!---->
<!--        --><?php //ActiveForm::end(); ?>
<!--        --><?php //Pjax::end(); ?>
<!---->
<!---->
<!---->
<!--    --><?php //yii\widgets\Pjax::begin(['id' => 'notes']) ?>
<!--    --><?//= GridView::widget([
//        'dataProvider' => $comments,
//        'columns' => [
//            //['class' => 'yii\grid\SerialColumn'],
//
//            'text',
//            //'user_id',
//            [
//                'attribute' => 'user_id',
//                'value' => 'user.name',
//            ],
//            'date_time',
//        ],
//    ]); ?>
<!---->
<!--    --><?php //Pjax::end(); ?>
<!--</div>-->
