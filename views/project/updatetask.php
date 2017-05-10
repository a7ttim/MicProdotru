<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Редактировать задачу: '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => ['info','project_id' => $project->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_taskform', [
        'model' => $model,
    ]) ?>

</div>