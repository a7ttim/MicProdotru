<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 06.05.2017
 * Time: 23:01
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $model app\models\Task */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Task;

$this->title = 'Gantt';
$this->params['breadcrumbs'][] = $this->title;
?>
    <script src="/js/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/css/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">

    <style type="text/css">
        html, body{ height:100%; padding:0px; margin:0px; overflow: hidden;}
    </style>
    <body>
    <div id="gantt_here" style="width:100%; height: auto; min-height: 200px;"></div>
    <script type="text/javascript">
        var tasks =  {
            data:[
                {id: 1, text: "Project", start_date:"11-04-2013", duration:8, order:20, progress:0.6, open: true},
        <?
        foreach ($tasks as $task)
        {
        ?>
                {id: 2, text: "zasdf", start_date:"11-04-2013", duration:8, order:20, progress:0.6, parent:1},
        <?
        }
        ?>
            ],
            links:[
            ]
        };
        gantt.init("gantt_here");
        gantt.parse(tasks);
    </script>
    </body>
