<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \stmswitcher\flipclock\FlipClock;
use \lo\widgets\SlimScroll;

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
        'brandLabel' => Html::img('@web/images/logo_rus_Micran.png', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-static-top m-b-0',
        ],
    ]);

//Таймер
    if (\Yii::$app->user->can('pe')) {
    $Y = date('Y');
    $m = date('m');
    $d = date('d');
    $H = date('H');
    $i = date('i');
    $s = date('s');
    $plans = \app\models\Task::find()->where(['user_id'=>Yii::$app->user->identity->user_id,'status_id'=>2])->all();
    $min[]=array();
    foreach($plans as $plan){
        $date = date_create($plan->start_date);
        date_add($date, date_interval_create_from_date_string($plan->plan_duration.' days'));
        array_push($min,date_format($date, 'd.m.Y'));
    }
    $warning_date=min($min);

    $wY = date('Y',strtotime($warning_date));
    $wm = date('m',strtotime($warning_date));
    $wd = date('d',strtotime($warning_date));

    \stmswitcher\flipclock\assets\FlipClockAsset::register($this);
    $script = <<< JS
var clock;
$(document).ready(function() {
var currentDate = new Date($Y,$m,$d,$H,$i,$s);
var warningDate = new Date($wY,$wm,$wd);
var diff = warningDate.getTime() / 1000 - currentDate.getTime() / 1000;
var clock = $('.clockwrapper').FlipClock(diff, {
clockFace: 'DailyCounter',
countdown: true
});
});
JS;
    $this->registerJs($script);
    ?>
    <div class="clockwrapper" title="Осталось до ближайшего крайнего срока одной из задач"></div>
   <?php }?>
    <?php
    if (\Yii::$app->user->can('pm')&&!\Yii::$app->user->can('pe')) {
        $Y = date('Y');
        $m = date('m');
        $d = date('d');
        $H = date('H');
        $i = date('i');
        $s = date('s');
        $plan = \app\models\Project::find()->where(['pm_id'=>Yii::$app->user->identity->user_id,'status_id'=>2])->min('end_date');

        $wY = date('Y',strtotime($plan));
        $wm = date('m',strtotime($plan));
        $wd = date('d',strtotime($plan));

        \stmswitcher\flipclock\assets\FlipClockAsset::register($this);
        $script = <<< JS
var clock;
var time;
$(document).ready(function() {
var currentDate = new Date($Y,$m,$d,$H,$i,$s);
var warningDate = new Date($wY,$wm,$wd);
var diff = warningDate.getTime() / 1000 - currentDate.getTime() / 1000;
if(diff>0) time=diff;
else time=0;
var clock = $('.clockwrapper').FlipClock(time, {
clockFace: 'DailyCounter',
countdown: true,
callbacks: {
stop: function() {
alert("Время выполнения какой-то задачи истекло!");
}}
});
});
JS;
        $this->registerJs($script);
        ?>
        <div class="clockwrapper" title="Осталось до завершения проекта"></div>
    <?php }?>
    ?>
    <!--    Таймер (конец)-->

    <?php echo Nav::widget([
        'options' => ['class' => 'nav navbar-top-links navbar-right pull-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
            ['label' => 'Авторизация', 'url' => ['/auth']]
            ) : (
            ['label' => Yii::$app->user->identity->login,
                'items' => [
                    [
                        'label' => 'Выйти',
                        'url' => ['/auth/logout'],
                    ],
                ],
            ]),
        ],
    ]);
    NavBar::end();
    ?>
    <div class="row header-fix">
        <div id="secondary"  role="complementary">
            <?
            if(!Yii::$app->user->isGuest) {
                if(Yii::$app->user->can('pe')) {
                    $items[] = ['label' => 'Задачи на согласовании', 'url' => ['/task/sogl']];
                    $items[] = ['label' => 'Задачи на исполнении', 'url' => ['/task/isp']];
                    $items[] = ['label' => 'Завершенные задачи', 'url' => ['/task/compl']];
                    $items[] = ['label' => 'Статистика', 'url' => ['/task/stat']];
                }
                if(Yii::$app->user->can('pm')) {
                    $items[] = '<hr>';
                    $items[] = ['label' => 'Проекты в разработке', 'url' => ['project/list', 'status_id' => 5]];
                    $items[] = ['label' => 'Проекты на согласовании', 'url' => ['project/list', 'status_id' => 1]];
                    $items[] = ['label' => 'Проекты на исполнении', 'url' => ['project/list', 'status_id' => 2]];
                    $items[] = ['label' => 'Завершенные проекты', 'url' => ['project/list', 'status_id' => 3]];
                    $items[] = ['label' => 'Корзина', 'url' => ['project/list', 'status_id' => 4]];
                }
                if(Yii::$app->user->can('dh')) {
                    $items[] = '<hr>';
                    $items[] = ['label' => 'Список ресурсов', 'url' => ['resource/list'],'linkOptions'=>['class'=>'main_li']];
                    $items[] = ['label' => 'Статистика', 'url' => ['resource/stat'],'linkOptions'=>['class'=>'main_li']];
                }

                echo SlimScroll::widget([
                    'options'=>[
                        'height' => '100%',
                        'alwaysVisible' => false,
                    ]
                ]);

                echo Nav::widget([
                    'options' => ['class' => 'navbar-default sidebar',
                        'id'=>'main-menu', 'role' => 'navigation'], // стили ul
                    'items' => $items,
                ]);

                echo SlimScroll::end();
            }
            ?>
        </div>

        <div class="col-md-12 col-lg-12 api-content" id='page-wrapper'>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class='container-fluid' id='whitediv'>
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
            <p class='hhh'>Телефон: +7 495 909-36-50 </p>
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
