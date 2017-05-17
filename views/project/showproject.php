<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('К проекту', ['info', 'project_id' => $model->project_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Редактировать', ['updateproject', 'id' => $model->project_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['deleteproject', 'id' => $model->project_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'project_id',
            'name',

            //'department_id',
            [
                'label' => 'Подразделение',
                'value' => $model->department->department_name,
                'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
            ],

            //'pm_id',
            [
                'label' => 'Менеджер',
                'value' => $model->pm->name,
                'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
            ],

            'description',
            'start_date',
            'end_date',
//            'type',
            //'status_id',
            [
                'label' => 'Статус',
                'value' => $model->status->status_name,
                'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
            ],
        ],
    ]) ?>

</div>
