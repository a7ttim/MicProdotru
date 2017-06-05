<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = 'Новый проект';
$this->params['breadcrumbs'][] = ['label' => \app\models\ProjectStatus::findOne(['status_id' => 5])->status_name, 'url' => ['list', 'status_id' => 5]];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['info','project_id' => $model->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_projectform', [
        'model' => $model,
        'start' => $start,
        'end' => $end
    ]) ?>

</div>
