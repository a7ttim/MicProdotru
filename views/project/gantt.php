<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

Pjax::begin();
?>
<div id="gantt_here" style='height:400px;'></div>
<?php
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
var tasks = {
  data:[      
JS;
$script .= '{id:1, text:"Проект 1", start_date:"'.date('d.m.Y', strtotime($tasks[0]->start_date)).'", duration:14, executor:"Петров А.А."},';
foreach ($tasks as $task){
    $script .= '{id:'.$task->task_id.', text:"'.$task->name.'", start_date:"'.date('d.m.Y', strtotime($task->start_date)).'", duration:3, parent:1, executor:"'.$task->user_id.'"},';
}
$script .= <<< JS
   ]
};

gantt.config.lightbox.sections = [
    {name:"description", height:40, map_to:"text", type:"textarea",focus:true},      
    {name:"time", type:"duration", map_to:"auto"},
    {name:"executor", height:55, type:"select", map_to:"executor", options:[         
JS;
foreach ($users as $user){
    $script .= '{key:"'.$user->user_id.'", label: "'.$user->name.'"},';
}
$script .= <<< JS
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
        gantt.init("gantt_here");
        gantt.parse(tasks);
        
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

