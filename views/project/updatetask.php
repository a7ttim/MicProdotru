<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Редактировать задачу: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => \app\models\ProjectStatus::findOne(['status_id' => $project->status_id])->status_name, 'url' => ['list', 'status_id' => $project->status_id]];
$this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => ['info','project_id' => $project->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_taskform', [
        'model' => $model,
        'project' => $project,
        'start' => date('d.m.Y', strtotime($model->start_date)),
    ]) ?>

</div>