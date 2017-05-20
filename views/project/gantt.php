<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Диаграмма Гантта';
$this->params['breadcrumbs'][] = ['label' => \app\models\ProjectStatus::findOne(['status_id' => $project->status_id])->status_name, 'url' => ['list', 'status_id' => $project->status_id]];
$this->params['breadcrumbs'][] = ['label' => $project->name, 'url' => ['info','project_id' =>$project->project_id]];
$this->params['breadcrumbs'][] = $this->title;

Pjax::begin();
?>
<div id="gantt_here" style='height:400px;'></div>
<?php
//начало многосточной строки, можно использовать любые кавычки

$script = <<< JS

gantt.config.lightbox.sections = [
    {name:"description", height:40, map_to:"text", type:"textarea",focus:true},      
    {name:"time", type:"duration", map_to:"auto"},
    {name:"executor", height:55, type:"select", map_to:"executor", options:[         
JS;
foreach ($users as $user){
    $script .= '{key:"'.$user->name.'", label: "'.$user->name.'"},';
}
$script .= <<< JS
     ]}
];
gantt.config.columns =  [
    {name:"text",       tree:true, width:'*' }
    /*
    {name:"id", label:"#", width:"40px", align:"center"},
    {name:"text",       tree:true, width:"250px" },
    {name:"start_date", align: "center" },
    {name:"duration", align: "center", width:"100px" },
    {name:"executor",   label:"Исполнитель",   align: "center" },
    {name:"add", align: "center" } 
    */
];

gantt.config.subscales = [
    {unit:"year", step:1, date:"%Y год"}
];

gantt.templates.task_text = function(start,end,task){
    if(task.id===1) return task.progress*100 + "%";
    else return task.progress*100 + "%";
};

gantt.templates.tooltip_text = function(start, end, task){ 
    if(task.id === 1) return "<b> Менеджер проекта:</b> " + task.executor + "<br><b>Длительность (в днях):</b> " + task.duration;
    else return "<b> Исполнитель:</b> " + task.executor  + "<br><b>Длительность (в днях):</b> " + task.duration;;
}

gantt.config.readonly = true;

        gantt.init("gantt_here");
        gantt.parse({
          data:[      
JS;
$project_compl = array();
foreach ($tasks as $task){
    array_push($project_compl, $task->complete_percentage);
}
$project_compl=array_sum($project_compl);
$project_compl=$project_compl/count($tasks);
$script .= '{id:1, text:"'.$project->name.'", start_date:"'.date('d.m.Y', strtotime($tasks[0]->start_date)).'", duration:14, 
progress: 0.'.$project_compl.', executor:"'.$project->pm->name.'"},';

foreach ($tasks as $task){
    $script .= '{
    id:'.$task->task_id.',
    text:"'.$task->name.'",
    start_date:"'.date('d.m.Y', strtotime($task->start_date)).'",
    duration:'.$task->plan_duration.',
    progress: 0.'.$task->complete_percentage.',
    parent:'.((!isset($task->parent_task_id) || is_null($task->parent_task_id)) ? 1 : $task->parent_task_id).', '."".'
    executor:"'.$task->user->name.'"},';
}
$script .= <<< JS
   ], 
   links:[      
JS;
foreach ($links as $link){
    $script .= '{id:'.$link->task_id.', source:"'.$link->parent_task_id.'", target:"'.$link->task_id.'", type:1},';
}
$script .= <<< JS
   ]
});
        
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

