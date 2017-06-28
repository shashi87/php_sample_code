<?php
/**
 * Application level Controller
 *
 * This file is Teams controller file. You can put all
 * team related methods here.
 *
 * PHP version 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @category  PHP
 * @package   CakePHP
 * @author    smartData <smartdata@smartdatainc.net>
 * @copyright 2005-2012 Cake Software Foundation, Inc.
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version   CVS: <2.3>
 * @link      http://cakephp.org CakePHP(tm) Project
 */

 /**
 * Team Controller
 *
 * Add your teams related methods in the class below, this controller
 * inherits the App controller.
 *
 * @category  PHP
 * @package   TeamsController
 * @author    smartData <smartdata@smartdatainc.net>
 * @copyright 2005-2012 Cake Software Foundation, Inc.
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version   Release: <1.0>
 * @link      http://book.cakephp.org/2.0/en/controllers.html
 */
class TeamsController extends AppController
{
    /**
    * This controller is using following models.
    * 
    * @var array
    */
    public $components = array('RequestHandler','Session','Auth');
    
    /**
    * This controller is using following helpers.
    * 
    * @var array
    */
    public $helpers = array('Html', 'Form', 'Session');
   
   
    /**
    * This function is executed before every action in the controller.
    * Function beforeFilter() is defined to set the variables which we will use in every function.
    * 
    * @author smartData
    * @return void
    * @access public
    */
    public function beforeFilter()
    {        
        parent::beforeFilter();
        
        if ($this->RequestHandler->isMobile()) {
            $this->layout = 'mobileCompanyDashboard';
        } else {
            $this->layout = 'companyDashboard';
        }
    }

    /**
    * List App Team .
    * Function index() is defined to list all app teams.
    * 
    * @author smartData
    * @return array
    * @throws CakeException
    * @access public
    */
    public function index()
    {    
        $teams = $this->Team->find('all', array('conditions' => array('Team.deleted' => 0)));
        $this->set('teams', $teams);    
        $this->loadModel('User');
        $schedulerList = $this->User->find('list', array('conditions' => array('User.role_id' => array(1,2),'User.status' => 1),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));
        $this->set('schedulerList', $schedulerList);
        
    }
     /**
    * Add Team.
    * Function index() is defined to add teams in app.
    *
    * @author smartData
    * @return void
    * @throws CakeException
    * @access public
    */
    public function add()
    {
        // To list all schedulers in the multi dropdown
        $this->loadModel('User');
        $this->loadModel('TeamUser');
        // List of users already added.
        $teamUserList = $this->TeamUser->find('list', array('conditions' => array(),'fields' => array('TeamUser.user_id')));
        
        // Listof leader i.e admin and scheduler
        $leaderList = $this->User->find('list', array('conditions' => array('User.role_id' => array(1,2),'User.status' => 1,'User.id <>' => $teamUserList),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));        
        $this->set('leaderList', $leaderList);
        // List of users i.e schedulers in a system
        $schedulerList = $this->User->find('list', array('conditions' => array('User.role_id' => 2,'User.status' => 1,'User.id <>' => $teamUserList),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));
        $this->set('schedulerList', $schedulerList);
        //Post data
        if (!empty($this->data)) {            
            $leaderId = $this->request->data['Team']['leader_id'];
            $this->Team->set($this->request->data);            
            if ($this->Team->validates()) {
                if ($this->Team->save($this->data)) {
                    // To get last inserted team id 
                    $lastTeamId = $this->Team->id;    
                        
                    if (empty($this->request->data['Team']['scheduler_id'])) {
                        $schedulerIds = array();
                    } else {
                        $schedulerIds = $this->request->data['Team']['scheduler_id'];    
                    }
                        
                    if (!in_array($leaderId, $schedulerIds)) {
                        $schedulerIds = array_merge($schedulerIds, array($leaderId));
                    }
                        
                    if (!empty($schedulerIds)) {
                        foreach ($schedulerIds as $schedulerId) {
                            $this->request->data['TeamUser']['id']      = null;
                            $this->request->data['TeamUser']['user_id'] = $schedulerId;
                            $this->request->data['TeamUser']['team_id'] = $lastTeamId;
                            $this->TeamUser->save($this->data);    
                        }
                    }
                        
                    $this->Session->setFlash("<div class='alert alert-success'>App Team created successfully.</div>");
                    $this->redirect(array('controller' => 'teams','action' => 'index'));
                } else {
                    $this->Session->setFlash("<div class='alert alert-danger'>Something went wrong while adding team.</div>");
                }
            } else {
                // didn't validate logic
                $errors = $this->Team->validationErrors;
                $this->Session->setFlash("<div class='alert_error'>Something went wrong while adding information</div>");
            }
        }
    }
    /**
    * View Team.
    * Function index() is defined to view team user detail.
    *
    * @param int $id Team user id.
    *
    * @author smartData
    * @return array
    * @throws CakeException
    * @access public
    */
    public function view($id=null)
    {
        $id = base64_decode($id);
        $this->loadModel('User');
        $schedulerList = $this->User->find('list', array('conditions' => array('User.role_id' => array(1, 2),'User.status' => 1),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));
        
        $this->set('schedulerList', $schedulerList);
        $details = $this->Team->findById($id);
        if (!empty($details)) {
            $team = '';
            foreach ($details['TeamUser'] as $data) {
                $team[] = $schedulerList[$data['user_id']];
            }
            
            if (!empty($team)) {
                $details['TeamUser'] = implode(', ', $team);
            } else {
                $details['TeamUser'] = '';
            }
        }            
        $this->set('details', $details);        
    }	
    /**
    * Delete Team.
    * Function delete() is defined to delete team.
    *
    * @param int $id Team user id.
    *
    * @author smartData
    * @return void
    * @throws CakeException
    * @access public
    */
    public function delete($id=null)
    {
        $id = base64_decode($id);
        $this->loadmodel('TeamAdjuster');
        if ($this->Team->updateAll(array('Team.deleted' => 1), array('Team.id' => $id))) {
            $this->TeamAdjuster->updateAll(array('TeamAdjuster.deleted' => 1), array('TeamAdjuster.team_id' => $id));
            $this->Session->setFlash("<div class='alert alert-success'>App Team deleted successfully.</div>");
            $this->redirect(array('controller' => 'teams','action' => 'index'));
        } else {
            $this->Session->setFlash("<div class='alert alert-error'>Something went wrong, Please try again.</div>");
            $this->redirect(array('controller' => 'teams','action' => 'index'));
        }
    }
    /**
    * Edit Team.
    * Function edit() is defined to edit team.
    *
    * @param int $id Team user id.
    *
    * @author smartData
    * @return void
    * @throws CakeException
    * @access public
    */
    public function edit($id=null)
    {
        $id = base64_decode($id);
        //Post data
        if (!empty($this->data)) {                
            $this->Team->set($this->request->data);            
            if ($this->Team->validates()) {
                 $leaderId = $this->request->data['Team']['leader_id'];
                if ($this->Team->save($this->data)) {
                    // To get last inserted team id 
                    $lastTeamId   = $this->Team->id;                        
                    $schedulerIds = $this->request->data['Team']['scheduler_id'];
                    if (!empty($schedulerIds)) {
                        $this->loadModel('TeamUser');                            
                        $conditions = array('TeamUser.team_id' => $lastTeamId);
                        $this->TeamUser->deleteAll($conditions, false);
                        if (!in_array($leaderId, $schedulerIds)) {
                            $schedulerIds = array_merge($schedulerIds, array($leaderId));
                        }
                        foreach ($schedulerIds as $schedulerId) {
                            $this->request->data['TeamUser']['id']      = null;
                            $this->request->data['TeamUser']['user_id'] = $schedulerId;
                            $this->request->data['TeamUser']['team_id'] = $lastTeamId;
                            $this->TeamUser->save($this->data);    
                        }
                    }
                        
                    $this->Session->setFlash("<div class='alert alert-success'>Team details are updated successfully.</div>");
                    $this->redirect(array('controller' => 'teams','action' => 'index'));
                } else {
                    $this->Session->setFlash("<div class='alert alert-danger'>Something went wrong while adding team.</div>");
                }
            } else {
                // didn't validate logic
                $errors = $this->Team->validationErrors;
                $this->Session->setFlash("<div class='alert_error'>Something went wrong while adding information</div>");
            }
        } else {
            
            // To list all schedulers in the multi dropdown
            $this->loadModel('User');
            $this->loadModel('TeamUser');
            // List of users already added.
            $teamUserList = $this->TeamUser->find('list', array('conditions' => array('TeamUser.team_id <>' => $id),'fields' => array('TeamUser.user_id')));
            // Listof leader i.e admin and scheduler
            $leaderList = $this->User->find('list', array('conditions' => array('User.role_id' => array(1,2),'User.status' => 1,'User.id <>' => $teamUserList),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));        
            $this->set('leaderList', $leaderList);            
            // List of users i.e schedulers in a system
            if (!empty($teamUserList)) {
                if (count($teamUserList) == 1) {
                    $teamUserList = array_values($teamUserList);
                    $teamUserList = $teamUserList[0];
                }
                $schedulerList = $this->User->find('list', array('conditions' => array('User.role_id' => 2,'User.status' => 1,'User.id <>' => $teamUserList),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));
            } else {
                $schedulerList = $this->User->find('list', array('conditions' => array('User.role_id' => 2,'User.status' => 1),'fields' => array('User.lastFirst'),'order' => 'User.lname ASC'));
            }
            $this->set('schedulerList', $schedulerList);
            
            $this->request->data = $this->Team->findById($id);
            if (!empty($this->request->data['TeamUser'])) {
                $teamUserArray   = array();
                $teamUserIdArray = array();
                foreach ($this->request->data['TeamUser'] as $teamUser) {
                    $teamUserArray[]   = $teamUser['id'];
                    $teamUserIdArray[] = $teamUser['user_id'];
                }
                $this->request->data['Team']['team_user']    = '';
                $this->request->data['Team']['team_user_id'] = '';
                if (!empty($teamUser)) {
                    $this->request->data['Team']['team_user']    = implode(',', $teamUserArray);
                    $this->request->data['Team']['team_user_id'] = implode(',', $teamUserIdArray);
                }
            }            
        }
    }
    
    /**
    * Assign Team 
    * Function assignment() is defined to assign team to the adjuster.
    *
    * @author smartData
    * @return array
    * @throws CakeException
    * @access public
    */
    public function assignment()
    {
        tombstone('2016-11-29', 'glens');
        $this->loadmodel('User');
        $this->loadmodel('TeamAdjuster');
        $teams = $this->Team->find('all', array('fields'=>array('Team.id', 'Team.name'), 'conditions' => array('Team.deleted' => 0)));
        $this->set('teams', $teams);
        $teamadjusterlist = $this->TeamAdjuster->find('list', array('fields'=>array('id', 'adjuster_id'), 'conditions' => array('TeamAdjuster.deleted' => 0)));
        $adjuster = $this->User->find('all', array('fields'=>array('User.id', 'User.fname', 'User.lname'), 'conditions' => array('User.role_id' => 3),'order'=>'User.lname asc'));
        $withteam = array();
        $withoutteam = array();
        if (!empty($adjuster)) {
            foreach ($adjuster as $adjusters) {
                if (in_array($adjusters['User']['id'], $teamadjusterlist)) {
                    $adjusters['User']['danger'] =0;
                    $withteam[] = $adjusters;
                } else {
                    $adjusters['User']['danger'] =1;
                    $withoutteam[] = $adjusters;				
                }
            }
        }
        $final_list = array_merge($withoutteam, $withteam);
        $this->set(compact('final_list'));
        $teamadjuster = $this->TeamAdjuster->find('all', array('fields'=>array('TeamAdjuster.id', 'TeamAdjuster.adjuster_id', 'TeamAdjuster.team_id'), 'conditions' => array('TeamAdjuster.deleted' => 0)));
        $this->set('teamadjusters', $teamadjuster); 
    }
    /**
    * Add/Update Team.
    * Function save_team() is defined to add or update team assignment to adjuster's by ajax.
    *
    * @author smartData
    * @return string
    * @throws CakeException
    * @access public
    */
    public function save_team()
    {
        $this->loadmodel('TeamAdjuster');
        $this->autoRender = false;
        if ($this->request->isPost()) {
            $adjuster_id = $this->request->data['adjuster_id'];
            $team_id     = $this->request->data['team_id'];
            $set_by      = AuthComponent::User('id');
            $this->request->data['set_by'] = $set_by;
            $exist_check = $this->TeamAdjuster->find('first', array('fields'=>array('TeamAdjuster.id', 'TeamAdjuster.adjuster_id', 'TeamAdjuster.team_id'), 'conditions' => array('TeamAdjuster.adjuster_id' =>$adjuster_id)));
            if (!empty($exist_check)) {
                $this->request->data['TeamAdjuster']['deleted'] = 0;
                if ($this->request->data['ischecked']==0) {
                    $this->request->data['TeamAdjuster']['deleted'] = 1;
                }
                $this->TeamAdjuster->id = $exist_check['TeamAdjuster']['id'];
                $this->request->data['TeamAdjuster']['adjuster_id'] = $this->request->data['adjuster_id'];
                $this->request->data['TeamAdjuster']['team_id'] = $this->request->data['team_id'];
                $this->TeamAdjuster->save($this->request->data);
                $message = "Updated successfully.";
            } else {
                $this->TeamAdjuster->save($this->request->data);
                $message =  "Team assigned successfully.";
            }	
        }
        return $message;
    }
    /**
    * Update Team Assignment.
    * Function updated_team_assignment() is defined to check the updated value from the database by ajax
    * in last 15 seconds that's run every 15 seconds.
    *
    * @author smartData
    * @return boolean
    * @throws CakeException
    * @access public
    */
    public function updated_team_assignment()
    {
        $this->loadmodel('TeamAdjuster');
        $this->autoRender = false;
        $current_time = date("Y-m-d H:i:s");
        $past_time    = date("Y-m-d H:i:s", time() - 16);
        $exist_check = $this->TeamAdjuster->find('all', array('fields'=>array('TeamAdjuster.id', 'TeamAdjuster.adjuster_id', 'TeamAdjuster.team_id'), 'conditions' => array('TeamAdjuster.updated BETWEEN '."'".$past_time."'".' AND '."'".$current_time."'")));
        if (!empty($exist_check)) {
            $result = 1;	
        } else {
            $result = 0;
        }
        return $result;
    }
}
?>
