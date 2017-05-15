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
        <?= Html::a('К созданию задач', ['info', 'project_id' => $model->project_id], ['class' => 'btn btn-success']) ?>
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
            'project_id',
            'name',
            'department_id',
            'pm_id',
            'description',
            'start_date',
            'end_date',
//            'type',
            'status_id',
        ],
    ]) ?>

</div>
