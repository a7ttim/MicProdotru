<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Task;
use app\models\Project;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form" id="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'project_id')->textInput() ?>

<!--    --><?//= $form->field($model, 'user_id')->textInput() ?>

    <?//= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($project->getUsers()->all(), 'user_id', 'name'),['prompt'=> 'Выберите исполнителя']) ?>
    <?= $form->field($model, 'user_id' )->widget(Select2::classname(), [
        'attribute' => 'users', // метод для получения пользователей в модели project
        'language' => 'ru', // выбор языка
        'data' => \yii\helpers\ArrayHelper::map($project->users, 'user_id', 'name'),  // метод для получения пользователей в модели project
        'options' => ['placeholder' => 'Выбрать исполнителя ...', 'multiple' => false],  // Множественная выборка
        'pluginOptions' => [
        ],
        // http://demos.krajee.com/widget-details/select2
    ])->label('Исполнитель'); ?>

<!--    --><?//= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->andWhere('user_id>1')->orderBy('name')->all(),
//        'user_id', 'name'),['prompt'=> 'Выберите исполнителя']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'style'=>'resize:vertical;']) ?>

    <?= $form->field($model, 'employment_percentage')->textInput() ?>

    <?= $form->field($model, 'parent_task_id')->textInput()->dropDownList(ArrayHelper::map(Task::find()->where(
            ['and',['parent_task_id'=>null],['project_id'=>$model->project_id]])->orderBy('start_date')->all(),
            'task_id', 'name'),['prompt'=> 'Выберите родительскую задачу']) ?>

<!--    --><?//= $form->field($model, 'previous_task_id')->textInput() ?>
    <?= $form->field($model, 'previous_task_id')->textInput()->dropDownList(ArrayHelper::map(Task::find()->where(
       ['project_id'=>$model->project_id])->orderBy('start_date')->all(),
        'task_id', 'name'),['prompt'=> 'Выберите предыдущую задачу']) ?>
    <label class="control-label">Дата начала</label>
    <div style = "margin-bottom: 1%">
    <?php
    $layout = <<< HTML
{input1}
HTML;

    echo DatePicker::widget([
        'type' => DatePicker::TYPE_INPUT,
        'name' => 'start_date',
        'value' => $start,
        'layout' => $layout,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);
    ?>
    </div>
    <?= $form->field($model, 'plan_duration')->textInput() ?>

    <?= $form->field($model, 'fact_duration')->textInput() ?>

<!--    --><?//= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'complete_percentage')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
