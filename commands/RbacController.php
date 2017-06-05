<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\WorkingOn;
use app\models\Department;
use app\models\Project;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth =  \Yii::$app->authManager;

        // add "pm" role
        $pm = $auth->createRole('pm');
        $auth->add($pm);
		
		// add "pe" role
        $pe = $auth->createRole('pe');
        $auth->add($pe);
		
		// add "dh" role
        $dh = $auth->createRole('dh');
        $auth->add($dh);
		
		// add "pm+pe" role
        $pmpe = $auth->createRole('pm+pe');
        $auth->add($pmpe);
		$auth->addChild($pmpe, $pm);
		$auth->addChild($pmpe, $pe);
		
		// add "pm+dh" role
        $pmdh = $auth->createRole('pm+dh');
        $auth->add($pmdh);
		$auth->addChild($pmdh, $pm);
		$auth->addChild($pmdh, $dh);
		
		// add "dh+pe" role
        $dhpe = $auth->createRole('dh+pe');
        $auth->add($dhpe);
		$auth->addChild($dhpe, $pe);
		$auth->addChild($dhpe, $dh);
		
		// add "super" role
        $super = $auth->createRole('super');
        $auth->add($super);
		$auth->addChild($super, $pe);
		$auth->addChild($super, $pm);
		$auth->addChild($super, $dh);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
		$user_ids = User::find('user_id')->all();
        foreach($user_ids as $uid) {
			$pm_find = Project::findOne(['pm_id' => $uid->user_id]);
			$pe_find = WorkingOn::findOne(['user_id' => $uid->user_id]);
			$dh_find = Department::findOne(['head_id' => $uid->user_id]);
			if($pm_find != null && $pe_find != null && $dh_find != null)
				$auth->assign($super, $uid->user_id);
			else 
				if($pm_find != null && $pe_find != null)
					$auth->assign($pmpe, $uid->user_id);
				else 
					if($pm_find != null && $dh_find != null)
						$auth->assign($pmdh, $uid->user_id);
					else
						if($pe_find != null && $dh_find != null)
							$auth->assign($dhpe, $uid->user_id);
						else 
							if($pe_find != null) $auth->assign($pe, $uid->user_id);
							else 
								if($pm_find != null) $auth->assign($pm, $uid->user_id);
								else 
									$auth->assign($dh, $uid->user_id);			
		}
        //$auth->assign($pm, 3);
        //$auth->assign($pe, 12);
    }
}