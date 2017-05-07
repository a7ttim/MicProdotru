<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Редактировать задачу: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['infoproject','project_id' =>$model->project_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['showtask', 'id' => $model->task_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_taskform', [
        'model' => $model,
    ]) ?>

</div>