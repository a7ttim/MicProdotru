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
        'brandLabel' => 'МИКРАН',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-static-top m-b-0',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'nav navbar-top-links navbar-right pull-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
            ['label' => 'Авторизация', 'url' => ['/auth']]
            ) : (
            ['label' => 'Выйти', 'url' => ['/auth/logout']]
            ),
        ],
    ]);
    NavBar::end();
    ?>
    <div class="row header-fix">
        <div class="col-md-12 col-lg-12 api-content" id='page-wrapper'>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class='container-fluid'>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="pull-left" id='block2'>
            <p class='hh'>ПРИЕМНАЯ</p>
            <p class='hhh'>Телефоны:</p>
            <p class='tel'>+7 3822 90-00-29 (автосекретарь)</p>
            <p class='tel'>+7 3822 41-34-03</p>
            <p class='tel'>+7 3822 41-34-06</p>
            <p class='hhh'>Факс: (3822) 42-36-15</p>
            <p class='hhh'>Почта: mic@micran.ru</p>
        </div>
        <div class="pull-left" id='block2'>
            <p class='hh'>АДРЕС:</p>
            <p>АО «НПФ «Микран»,</p>
            <p>пр-т Кирова, 51д,</p>
            <p>г. Томск, Россия, 634041.</p>
        </div>
        <div class="pull-left" id='block2'>
            <p class='hh'>ОФИС В МОСКВЕ</p>
            <p class='hhh'>Телефон: +7 499 501-76-96</p>
            <p class='hhh'>Адрес для писем:</p>
            <p>Славянская площадь,</p>
            <p>дом 2/5/4 стр. 3</p>
            <p>Москва, 109074</p>
        </div>
        <div class="pull-left" id='block2'>
            <p class='hh'>ПРЕДСТАВИТЕЛЬСТВО В МОСКВЕ</p>
            <p class='hhh'>Адрес для писем:</p>
            <p>Электрический переулок, </p>
            <p>дом 3/10 строение 3, этаж 4</p>
            <p>Москва, 123557<p>
            <p class='hhh'>Почта:Телефон: +7 495 909-36-50 </p>
            <p class='hhh'>Почта: msk@micran.ru</p>
        </div>
    </div>
    <div class='container-fluid' id='ft'>
        <p>“Микран” © 1991-<?= date('Y') ?></p>
        <p>Сайт создан командой TeamLab - MicPro.ru, 2017г.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
