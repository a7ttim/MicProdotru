<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Department;

/* @var $this yii\web\View */
/* @var $model app\models\project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_id')->dropDownList(ArrayHelper::map(Department::find()->andWhere('parent_department_id is null')->all(),
        'department_id', 'department_name'),['prompt'=> 'Выберете подразделение']) ?>

    <?= $form->field($model, 'pm_id')->dropDownList(ArrayHelper::map(User::find()->andWhere('user_id>1')->all(),
        'user_id', 'name')) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>
    <?//shirase55 datetime?>
    <?= $form->field($model, 'end_date')->textInput() ?>

<!--    --><?//= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'status_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
