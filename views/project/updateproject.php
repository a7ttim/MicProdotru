<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\project */

//$this->title = 'Update Project: ' . $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->project_id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
    <div class="project-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_projectform', [
            'model' => $model,
            'start' => date('d.m.Y', strtotime($model->start_date)),
            'end' => date('d.m.Y', strtotime($model->end_date)),
        ]) ?>

    </div>
