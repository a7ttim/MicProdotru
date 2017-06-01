<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Employment;
use yii\data\ActiveDataProvider;

$this->title = 'Список ресурсов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='snn'>
<h1><?= Html::encode($this->title) ?></h1>
<?= Html::a('Визуализация', Url::to('gantt'),['class' =>'btn btn-primary btn-md']);?>
</div>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user.name',
                'value' => 'user.name',
            ],
            [
                'attribute' => 'department.department_name',
				'value' => 'department.department_name',
            ],
			[
                'attribute' => 'post.post_name',
                'value' => 'post.post_name',
            ],
			[
                'value' => function (Employment $emp) {
                    return Html::a('Подробнее', Url::to(['info', 'user_id' => $emp->user_id]),['class' =>'btn btn-info btn-xs']);
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>
<?php Pjax::end();?>