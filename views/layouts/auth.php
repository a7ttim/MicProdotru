<?php use yii\helpers\Html; 
use yii\bootstrap;
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
<body style='background: url(/web/images/company.jpg) no-repeat fixed; background-size: cover; overflow: hidden;'>
<?php $this->beginBody() ?>

<div id='logodiv'>
    <?= $content ?>
</div>
			
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>