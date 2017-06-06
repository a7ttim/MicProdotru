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
    if(task.duration === 1) return task.progress*100 + "%";
    else return "<b>Завершено: </b>" + task.progress*100 + "%";
};

gantt.templates.tooltip_text = function(start, end, task){ 
    if(task.id === 1) return "<b>Описание: </b>" + task.description + "<br><b> Загруженность исполнителя: </b>" + task.employment_percentage  + 
    "%" + "<br><b>Длительность (в днях):</b> " + task.duration;
    else return "<b>Описание: </b>" + task.description + "<br><b> Исполнитель: </b>" + task.executor  + "<br><b> Загруженность исполнителя: </b>" + task.employment_percentage  + 
    "%" + "<br><b>Длительность (в днях): </b>" + task.duration;
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

$start_date = date_create($project->start_date);
$end_date = date_create($project->end_date);
$project_duration = date_diff($start_date, $end_date);

$script .= '{
    id:1,
    text:"'.$project->name.'", 
    description:"'.$project->description.'",
    start_date:"'.date('d.m.Y', strtotime($project->start_date)).'", 
    duration:' . $project_duration->format('%a') . ',
    progress: 0.'.$project_compl.',
    employment_percentage: '.$project->getTasks()->one()->employment_percentage.',
    color:"' . ($project_compl === 100 ? "green" : "default") . '"},';

foreach ($tasks as $task){
    if($task->status_id===1||$task->status_id===4||$task->status_id===6) continue;
    else
    {
        $script .= '{
        id:'.$task->task_id.',
        text:"'.$task->name.'",
        description:"'.$task->description.'",
        start_date:"'.date('d.m.Y', strtotime($task->start_date)).'",
        duration:'.$task->plan_duration.',
        progress: 0.'.$task->complete_percentage.',
        employment_percentage: '.$task->employment_percentage.',
        parent:'.((!isset($task->parent_task_id) || is_null($task->parent_task_id)) ? 1 : $task->parent_task_id).',
        executor:"'.$task->user->name.'",
        color:"' . ($task->complete_percentage === 100 ? "green" : "default") . '"},';
    }
}
$script .= <<< JS
   ], 
   links:[      
JS;
foreach ($links as $link){
    ($link->task_id % 2 === 0) ? $cnt = 2 : $cnt = 1;
    $script .= '{id:'.$link->task_id.', source:"'.$link->previous_task_id.'", target:"'.$link->task_id.'", type:'. $cnt .'},';
}
$script .= <<< JS
   ]
});
        
JS;
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

