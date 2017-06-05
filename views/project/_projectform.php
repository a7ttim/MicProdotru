<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Department;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_id')->dropDownList(ArrayHelper::map(Department::find()->andWhere('parent_department_id is null')
        ->orderBy('department_name')->all(),
        'department_id', 'department_name'),['prompt'=> 'Выберите подразделение']) ?>

    <?= $form->field($model, 'pm_id')->dropDownList(ArrayHelper::map(User::find()->andWhere('user_id>1')->orderBy('name')->all(), 'user_id', 'name')) ?>

    <?= $form->field($model, 'users_array' )->widget(Select2::classname(), [
        'attribute' => 'users', // метод для получения пользователей в модели project
        'language' => 'ru', // выбор языка
        'data' => \yii\helpers\ArrayHelper::map(User::find()->where(('user_id != :user_id and user_id !=1'), ['user_id' => [$model->pm_id, 1]])->all(), 'user_id', 'name'),  // метод для получения пользователей в модели project
        'options' => ['placeholder' => 'Выбрать исполнителей ...', 'multiple' => true],  // Множественная выборка
        'pluginOptions' => [
        ],
        // http://demos.krajee.com/widget-details/select2
    ])->label('Исполнители'); ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'style'=>'resize:vertical;']) ?>

    <?php
    $layout = <<< HTML
    <span class="input-group-addon">С</span>
    {input1}
    <span class="input-group-addon">По</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

        echo DatePicker::widget([
            'type' => DatePicker::TYPE_RANGE,
            'name' => 'start_date',
            'value' => $start,
            'name2' => 'end_date',
            'value2' => $end,
            'layout' => $layout,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]);
?>

<!--    --><?//= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'status_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'style' => 'margin-top: 1%']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
