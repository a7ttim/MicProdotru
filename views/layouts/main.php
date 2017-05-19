<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
    'brandLabel' => 'MicPro.ru',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
    'class' => 'navbar-inverse navbar-fixed-top',
    ],
    ]);

    echo Yii::$app->user->can('pm') ? Nav::widget([
        'items' => [
            [
                'label' => 'Проекты',
                'items' => [
                    //'<li class="dropdown-header">Dropdown Header</li>',
                    ['label' => 'В разработке', 'url' => ['/project/list', 'status_id' => 5]],
                    ['label' => 'На согласовании', 'url' => ['/project/list', 'status_id' => 1]],
                    ['label' => 'На исполнении', 'url' => ['/project/list', 'status_id' => 2]],
                    ['label' => 'Завершенные', 'url' => ['/project/list', 'status_id' => 3]],
                    '<li class="divider"></li>',
                    ['label' => 'Корзина', 'url' => ['/project/list', 'status_id' => 4]],
                ],
            ],
        ],
        'options' => ['class' =>'navbar-nav'],
    ]): '';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
            ['label' => 'Авторизация', 'url' => ['/auth']]
            ) : (
            ['label' => 'Выход '. Yii::$app->user->identity->name, 'url' => ['/auth/logout']]
            ),
        ],
    ]);
    NavBar::end();
    ?>
    <div class="row header-fix">
<div id="secondary" class='col-md-2' role="complementary">
<?
	if(!Yii::$app->user->isGuest) {
		$items;
		if(Yii::$app->user->can('pe')) {
			$items[] = ['label' => 'Мои задачи', 'url' => ['/task/list'], 'linkOptions'=>['class'=>'main_li']];
			$items[] = ['label' => 'На согласовании', 'url' => ['/task/sogl']];
			$items[] = ['label' => 'На исполнении', 'url' => ['/task/isp']];
            $items[] = ['label' => 'Завершенные', 'url' => ['/task/compl']];
            $items[] = ['label' => 'Статистика', 'url' => ['/task/stat']];
		}
		if(Yii::$app->user->can('pm')) {
			$items[] = ['label' => 'Мои проекты', 'url' => ['project/list'], 'linkOptions'=>['class'=>'main_li']];
			$items[] = ['label' => 'В разработке', 'url' => ['/project/list', 'status_id' => 5]];
			$items[] = ['label' => 'На согласовании', 'url' => ['/project/list', 'status_id' => 1]];
			$items[] = ['label' => 'На исполнении', 'url' => ['/project/list', 'status_id' => 2]];
			$items[] = ['label' => 'Завершенные', 'url' => ['/project/list', 'status_id' => 3]];
            $items[] = ['label' => 'Корзина', 'url' => ['/project/list', 'status_id' => 4]];
		}
		if(Yii::$app->user->can('dh')) {
			$items[] = ['label' => 'Мои ресурсы', 'url' => ['resource/list'],'linkOptions'=>['class'=>'main_li']];
			$items[] = ['label' => 'Статистика', 'url' => ['resource/stat'],'linkOptions'=>['class'=>'main_li']];
		}
		echo Nav::widget([
            'options' => ['class' => 'clearfix nav-pills nav-stacked', 'id'=>'main-menu'], // стили ul
            'items' => $items,   
        ]);
	}
?>
</div>


    <div class="col-md-9 api-content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Created by MicTeam with love <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
