<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

Pjax::begin();
?>
<div id="gantt_here" style='width:1500px; height:400px;'></div>
<?php
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS

var tasks = {
  data:[
     {id:1, text:"Проект 1", start_date:"07.05.2017", duration:14, executor:"Петров А.А."},
     {id:2, text:"Задача 1", start_date:"07.05.2017", duration:3, parent:1, executor:"Иванов И.И."},
     {id:3, text:"Задача 2", start_date:"07.05.2017", duration:2, parent:1},
     {id:4, text:"Подзадача 1 задачи 2", start_date:"07.05.2017", duration:3, parent:3}
   ]
};
gantt.config.lightbox.sections = [
    {name:"description", height:40, map_to:"text", type:"textarea",focus:true},          
    {name:"time", type:"duration", map_to:"auto"},
    {name:"executor", height:55, type:"select", map_to:"executor", options:[ 
        {key:"Петров А.А.", label: "Петров А.А."},                                               
        {key:"Иванов И.И.", label: "Иванов И.И."},                                             
        {key:"Сидоров П.А.", label: "Сидоров П.А."}                                                 
     ]}
];
gantt.config.columns =  [
    {name:"id", label:"#", width:"40px", align:"center"},
    {name:"text",       tree:true, width:"250px" },
    {name:"start_date", align: "center" },
    {name:"duration", align: "center", width:"100px" },
    {name:"executor",   label:"Исполнитель",   align: "center" },
    {name:"add", align: "center" }
];
gantt.config.grid_width = 640;

        gantt.init("gantt_here");
        gantt.parse(tasks);
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

