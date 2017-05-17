<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Список ресурсов';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
        ],
    ]); ?>
<?php Pjax::end(); ?>
