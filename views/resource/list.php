<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Employment;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Department;
use app\models\Post;

$this->title = 'Список ресурсов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='snn'>
<h1><?= Html::encode($this->title) ?></h1>
    <?php if($tasks!=null) echo  Html::a('Визуализация', Url::to('gantt'),['class' =>'btn btn-primary btn-md']);?>
</div>
<?php
$id = Yii::$app->user->identity->user_id;
$dep = Department::findOne(['head_id' => $id]);
$deps = Department::find()
    ->select(['department.department_id'])
    ->where(['parent_department_id' => $dep->department_id])
    ->asArray()->all();
$deps_ar[] = $dep->department_id;
for($i = 0; $i < count($deps); ++$i){
    $deps_ar[] = $deps[$i]['department_id'];
}
?>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value' => 'user.name',
                'filter'=>ArrayHelper::map(Employment::find()
                    ->select(['user.name', 'user.user_id'])
                    ->joinWith('department')
                    ->joinWith('user')
                    ->joinWith('post')
                    ->where(['in', 'department.department_id', $deps_ar])
                    ->andWhere(['not', ['employment.user_id' => $id]])
                    ->asArray()
                    ->all(),
                    'user_id', 'name'),
                'label'=>'ФИО'
            ],
            [
                'attribute' => 'department_id',
				'value' => 'department.department_name',
                'filter'=>ArrayHelper::map(Employment::find()
                    ->select(['department.department_name', 'department.department_id'])
                    ->joinWith('department')
                    ->joinWith('user')
                    ->joinWith('post')
                    ->where(['in', 'department.department_id', $deps_ar])
                    ->andWhere(['not', ['employment.user_id' => $id]])
                    ->asArray()
                    ->all(),
                    'department_id', 'department_name'),
                'label'=>'Отдел'
            ],
			[
                'attribute' => 'post_id',
                'value' => 'post.post_name',
                'filter'=>ArrayHelper::map(Employment::find()
                    ->select(['post.post_name', 'post.post_id'])
                    ->joinWith('department')
                    ->joinWith('user')
                    ->joinWith('post')
                    ->where(['in', 'department.department_id', $deps_ar])
                    ->andWhere(['not', ['employment.user_id' => $id]])
                    ->asArray()
                    ->all(),
                    'post_id', 'post_name'),
                'label'=>'Должность'
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