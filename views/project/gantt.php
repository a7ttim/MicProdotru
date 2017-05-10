<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

$this->title = 'Диаграмма Гантта';
$this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => ['info','project_id' =>$project->project_id]];
$this->params['breadcrumbs'][] = $this->title;

Pjax::begin();
?>
<div id="gantt_here" style='height:400px;'></div>
<?php
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
var tasks = {
  data:[      
JS;
$script .= '{id:1, text:"'.$project->name.'", start_date:"'.date('d.m.Y', strtotime($tasks[0]->start_date)).'", duration:14, executor:"'.$project->pm_id.'"},';
foreach ($tasks as $task){
    $script .= '{id:'.$task->task_id.', text:"'.$task->name.'", start_date:"'.date('d.m.Y', strtotime($task->start_date)).'", duration:'.$task->plan_duration.', parent:'.((!isset($task->parent_task_id) || is_null($task->parent_task_id)) ? 1 : $task->parent_task_id).', '.""
        /*executor:"'.\app\models\User::findOne(['user_id' => $task->user_id])->name.'", */
        .'executor:'.$task->user_id.'},';
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
gantt.config.grid_width = 640;
        gantt.init("gantt_here");
        gantt.parse(tasks);
        
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

