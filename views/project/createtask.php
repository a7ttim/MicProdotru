<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Новая задача';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['info','project_id' =>$model->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_taskform', [
        'model' => $model,
    ]) ?>

</div>
