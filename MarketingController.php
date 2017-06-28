<?php
class MarketingController extends AppController {

    var $helpers = array('Html', 'Form', 'Cache', 'Common');
    public $components = array('Email', 'Upload', 'Cookie', 'AuthorizeNet', 'Mailgun','Cart');
    public $paginate = array(
        'limit' => 10
    );

    /**@Created:    24-April-2017
     * @Method :     beforeFilter
     * @Author:      Shashi 
     * @Modified :   ---
     * @Purpose:     Rendered before any function
     * @Param:       none
     * @Return:      none
     */
    function beforeFilter() {
        
        parent::beforeFilter();
        $this->Auth->allow('itemupdate');
    }

    
     /*@Created:   24-April-2017
     * @Method :    index
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:    top nav marketing page. 
     * @Param:       
     * @Return:      none
     */
    public function index($id = NULL) {
        $this->layout = "front/manage";
        $this->set('title_for_layout', $this->title_name.': Marketing');
        $this->loadModel('Slider');
        $this->loadModel('Subscription');
        $this->loadModel('Custompackage');
        $this->loadModel('Faq');
        $this->loadModel('Event');
        $this->loadModel('Help');
        $current_date = date('Y-m-d', time());
        $user = $this->Auth->user();
        $assign_back = array();
        if (!empty($id)) {
            $event_id = base64_decode($id);
            $this->Event->unBindModel(array('hasMany' => array('EventDate','EventEditedUser','EventFbattendUser','EventImages','TicketPrice','EventCategory'), 'belongsTo' => array('User'),'hasOne'=>array('Giveaway','Topevent','RecommendedEvent')), false);
            $event_option = $this->Event->find('list', array('fields' => array('id', 'title'), 'conditions' => array('Event.user_calendar_id'=>CHILD_DOMAIN_ID,'Event.domain_id'=>DOMAIN_ID,'Event.event_from' => "ALH",'Event.user_id' => $user['id'], 'Event.id' => $event_id, 'Event.is_deleted' => 0, 'Event.start_date >=' => $current_date)));
        } else {
            $event_id = 0;
            $event_option = $this->Event->find('list', array('fields' => array('id', 'title'), 'conditions' => array('Event.user_calendar_id'=>CHILD_DOMAIN_ID,'Event.domain_id'=>DOMAIN_ID,'Event.event_from' => "ALH", 'Event.user_id' => $user['id'], 'Event.is_deleted' => 0, 'Event.start_date >=' => $current_date)));
        }
        $getSliders = $this->Slider->find("all", array(
            "conditions" => array(
                "Slider.status" =>1,
                "Slider.user_calendar_id" => CHILD_DOMAIN_ID
                ),
            "fields" =>array(
               "Slider.id","Slider.title","Slider.img","Slider.description"
            )
            ));
        $getSubscriptionplan = $this->Subscription->find("all", array(
            "conditions" => array(
                "Subscription.status" =>1,
                "Subscription.is_deleted" =>0,
                "Subscription.user_calendar_id" => CHILD_DOMAIN_ID
                ),
            "fields" =>array(
               "Subscription.id","Subscription.name","Subscription.frequency","Subscription.amount","Subscription.offer","Subscription.planimage","Subscription.status"
                )
            ));
         $getCustomPackage = $this->Custompackage->find("all", array(
            "conditions" => array(
                "Custompackage.status" =>1,
                "Custompackage.is_deleted" =>0,
                "Custompackage.user_calendar_id" => CHILD_DOMAIN_ID
            ),
            "fields" =>array(
               "Custompackage.id","Custompackage.plan_id","Custompackage.name","Custompackage.amount","Custompackage.planimage","Custompackage.description","Custompackage.frequency","Custompackage.status"
            )
            ));
          $getFaqs = $this->Faq->find("all", array(
            "conditions" => array(
                "Faq.status" =>1,
                "Faq.is_deleted" =>0,
                "Faq.user_calendar_id" => CHILD_DOMAIN_ID
            ),
            "fields" =>array(
               "Faq.id","Faq.question","Faq.answer","Faq.status"
            )
            ));
          $getHelp = $this->Help->find("all", array(
            "conditions" => array(
                "Help.status" =>1,
                "Help.user_calendar_id" => CHILD_DOMAIN_ID
                ),
            "fields" =>array(
               "Help.id","Help.title","Help.img","Help.description"
            )
            ));
          
          $getSlidersimg = $getSliders;
          $this->set(compact('getSliders','getSlidersimg','getFaqs','getHelp','event_option','event_id','getSubscriptionplan','getCustomPackage'));
    }
    
    /*@Created:   24-April-2017
     * @Method :    clear
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:    Use to clear the cart session. 
     * @Param:       
     * @Return:      none
     */
    public function clear() {
        $this->Cart->clear();
        $this->Session->setFlash('All item(s) removed from your shopping cart');
        return $this->redirect('/marketing');
    }

    /*@Created:   24-April-2017
     * @Method :    itemupdate
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:    Ajax method is used to add, edit,delete item in cart. 
     * @Param:       
     * @Return:      json
     */
    public function itemupdate() {
        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : null;
            $event_id = $this->request->data['eventId'];
            $product = $this->Cart->add($id, $quantity,$event_id);
        }
        $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
    }
    
    /*@Created:   24-April-2017
     * @Method :    remove
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:    Ajax method is used to delete item from cart. 
     * @Param:       
     * @Return:      json
     */
    public function remove($id = null) {
        $product = $this->Cart->remove($id);
        if(!empty($product)) {
            $this->Session->setFlash($product['Product']['name'] . ' was removed from your shopping cart');
        }
        return $this->redirect(array('action' => 'index'));
    }

     /*@Created:   24-April-2017
     * @Method :    promote
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:   Used to show the promotional plan detail page while purhchasing. 
     * @Param:    $subscriptionId,   $eventID
     * @Return:      none
     */
    public function promote($subscriptionId = null,$eventID = null) {
        $this->layout = "front/manage";
        $this->loadModel('Subscription');
        if(empty($subscriptionId)) {
                $this->redirect('/marketing'); 
        }  
        if(!empty($subscriptionId)) {
           $subscriptionId = base64_decode($subscriptionId);
           $event_ID = base64_decode($eventID);
        
           $getFeature = $this->Subscription->find('all', array(
		'conditions' => array (
		    'Subscription.id' => $subscriptionId
		)
            ));
          
        $this->set('subscriptionId', $subscriptionId);
        
        $this->Event->unBindModel(array('hasMany' => array('EventDate','EventEditedUser','EventFbattendUser','EventImages','TicketPrice','EventCategory'), 'belongsTo' => array('User'),'hasOne'=>array('Giveaway','Topevent','RecommendedEvent')), false);
        $get_event = $this->Event->find('first', array('fields' => array('id','end_date'), 'conditions' => array('Event.id' =>$event_ID)));
        $end_date = date('m/d/Y', strtotime($get_event['Event']['end_date']));
        
        $this->set('eventId', $eventID);
        $this->set('endDate', $end_date);
        $this->Session->write('Shop.Subscription',$getFeature[0]['Subscription']);
        $this->Session->write('Shop.PackageFeature',$getFeature[0]['PackageFeature']);
        $this->Session->write('Shop.Order.event_id',$event_ID);
        $orderDetail = $this->Session->read('Shop');
        }
        $this->set(compact('orderDetail'));
    }
    
    /*@Created:   24-April-2017
     * @Method :    savepromotion
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:   Authorize Payments Promotional Plans
     * @Param:    
     * @Return:      none
     */
    public function savepromotion() {
        $this->autoRender = false;
        $this->layout = "front/manage";
        $this->loadModel('Subscription');
        $this->loadModel('Event');
        $this->loadModel('Order');
        $this->loadModel('OrderDetail');
        $this->loadModel('User');
        $this->loadModel('LeaderboardBanner');
        $this->loadModel('MajorMediaPost');
        $postData = $this->request->data;
        if(!empty($postData)) {
           $subscriptionId = base64_decode($postData['Subscription']['id']);
           $eventId = base64_decode($postData['Subscription']['event_id']);
           $getFeature = $this->Subscription->find('all', array(
		'conditions' => array (
		    'Subscription.id' => $subscriptionId
		)
            ));
        }
        $this->Session->write('Shop.Order',$getFeature[0]['Subscription']);
        $this->Session->write('Shop.OrderItem',$getFeature[0]['PackageFeature']);
        $this->Session->write('Shop.Order.event_id', $eventId);
        $order = $this->Session->read('Shop');
        if(isset($postData['paypal']) && $postData['paypal']=="submit") {
            foreach ($order['OrderItem'] as $key => $item) {
                if(isset($postData['OrderItem'][$key]) && !empty($postData['OrderItem'][$key])) {
                    $newarray=$postData['OrderItem'][$key];
                    $result[$key] = array_merge($item,$newarray);
                }
            }
            $this->Session->write('Shop.OrderDetail',$result);
            $this->redirect(array('controller' => 'payments', 'action' => 'paypalSectionPlan', base64_encode($subscriptionId)));  
        }
        if ($this->request->is('post')) {
            $user_id = $this->Auth->user('id');
            $user_data = $this->User->findById($user_id);
            $full_name = $user_data['User']['first_name'] . " " . $user_data['User']['last_name'];
            $amount =   $this->request->data['Payment']['amount'];
            $card_num = $this->request->data['Payment']['cardnumber'];
            $card_cvv = $this->request->data['Payment']['cvv'];
            $exp_date = $this->request->data['Payment']['expiryMonth'] . date('y', strtotime('01-01-' . $this->request->data['Payment']['expiryYear']));
            $response = $this->AuthorizeNet->validate_card(LOGINID, TRANSACTIONKEY, $amount, $card_num, $exp_date, $card_cvv, $user_data);
            if ($response->approved == 1) {
                $transaction_id = $response->transaction_id;
                $responseCode = $response->response_code . '-' . $response->response_subcode;
                $responsetext = $response->response_reason_text;
                foreach ($order['OrderItem'] as $key => $item) {
                    if(isset($postData['OrderItem'][$key]) && !empty($postData['OrderItem'][$key])){
                        $newarray=$postData['OrderItem'][$key];
                        $result[$key] = array_merge($item,$newarray);
                    }
                }
                $this->Session->delete('Shop.OrderItem');
                $this->Session->write('Shop.OrderDetail',$result);
                $orderDetail = $this->Session->read('Shop');
                $leaderBoardId = 0; $majormediaId = 0;
                if(isset($orderDetail) && !empty($orderDetail)) {
                    $order = array();
                    $order['Order']['payment_status'] = 1;
                    $order['Order']['user_id'] = $user_id;
                    $order['Order']['event_id'] = $eventId;
                    $order['Order']['order_type'] = 2;
                    $order['Order']['order_count'] = 1;
                    $order['Order']['total_quantity'] = 1;
                    $order['Order']['total_amount'] = $orderDetail['Order']['amount'];
                    $order['Order']['subtotal_amount'] = $orderDetail['Order']['amount'];
                    $order['Order']['response'] = $responsetext;
                    $order['Order']['response_code'] = $responseCode;
                    $order['Order']['transaction_id'] = $transaction_id ;
                    $order['Order']['user_calendar_id'] = CHILD_DOMAIN_ID;
              
                    foreach($orderDetail['OrderDetail'] as $key => $item) {
                        $order['OrderDetail'][$key]['plan_id'] = $item['plan_id'];
                        $order['OrderDetail'][$key]['promotional_package_id'] = $orderDetail['Order']['id'];
                        $order['OrderDetail'][$key]['package_name'] = $item['name'];
                        $order['OrderDetail'][$key]['price'] = 0;
                        $order['OrderDetail'][$key]['quantity'] = $item['quantity'];
                        $order['OrderDetail'][$key]['subtotal'] = 0;
                        if(isset($item['date1'])) {
                            $order['OrderDetail'][$key]['date1'] = date('Y-m-d', strtotime($item['date1']));
                        }
                        if(isset($item['date2'])) {
                            $order['OrderDetail'][$key]['date2'] = date('Y-m-d', strtotime($item['date2']));
                        }
                        if(isset($item['date3'])) {
                            $order['OrderDetail'][$key]['date3'] = date('Y-m-d', strtotime($item['date3']));
                        }
                        if(isset($item['date4'])) {
                            $order['OrderDetail'][$key]['date4'] = date('Y-m-d', strtotime($item['date4']));
                        }
                        if(isset($item['start_date'])) {
                            
                        }
                        if($item['plan_id'] == '6') {
                            $order['Order']['is_media'] = 1;
                            $order['Order']['post_media_city'] = $item['post_media_city'];
                            $order['OrderDetail'][$key]['post_media_city'] = $item['post_media_city'];
                            $media['MajorMediaPost']['state_name'] =  $item['post_media_city'];
                            $media['MajorMediaPost']['event_id'] = $eventId; 
                            $this->MajorMediaPost->save($media);
                            $majormediaId = $this->MajorMediaPost->getLastInsertID();
                        }
                        if($item['plan_id'] == '4') {
                            $order['Order']['is_banner'] = 1;
                            $order['OrderDetail'][$key]['start_date'] = date('Y-m-d', strtotime($item['start_date']));
                            $order['OrderDetail'][$key]['end_date'] = date('Y-m-d', strtotime($item['end_date']));
                            $this->Event->unBindModel(array('hasMany' => array('EventDate','EventEditedUser','EventFbattendUser','EventImages','TicketPrice','EventCategory'), 'belongsTo' => array('User'),'hasOne'=>array('Giveaway','Topevent','RecommendedEvent')), false);
                            $get_event = $this->Event->find('first', array('fields' => array('zip_code', 'state'), 'conditions' => array('Event.id' =>$eventId)));
                            $data['LeaderboardBanner']['start_date'] = date('Y-m-d', strtotime($item['start_date']));
                            $data['LeaderboardBanner']['end_date'] = date('Y-m-d', strtotime($item['end_date']));
                            $data['LeaderboardBanner']['zip'] = $get_event['Event']['zip_code']; 
                            $data['LeaderboardBanner']['state'] = $get_event['Event']['state'];
                            $data['LeaderboardBanner']['status'] = 0; 
                            $this->LeaderboardBanner->save($data);
                            $leaderBoardId = $this->LeaderboardBanner->getLastInsertID();
                        }
                    }
                }
                $save = $this->Order->saveAll($order, array('validate' => 'false'));
                if($save) {
                    $lastorderId = $this->Order->getLastInsertID();
                    $this->Order->id = $lastorderId;
                    $this->Order->saveField('leaderboard_banner_id', $leaderBoardId);
                    $this->Order->saveField('major_media_post_id', $majormediaId);
                    $this->paymentEmail($lastorderId,$user_data['User']['email']);
                    $this->Session->setFlash(__("$responsetext"), "default", array("class" => "green"));
                }
                $this->redirect(array('controller' => 'sales', 'action' => 'orderList'));
            } else {
                $responsetext = $response->response_reason_text;
                $this->Session->setFlash(__("$responsetext"), "default", array("class" => "red"));
                $this->redirect(array('controller' => 'marketing', 'action' => 'promote/'.base64_encode($subscriptionId).'/'.base64_encode($eventId)));
            }
        } 
    }
    
    /*@Created:   24-April-2017
     * @Method :    cart
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:    Showing cart in front end of custom packages. 
     * @Param:       
     * @Return:      none
     */
    public function cart() {
        $this->layout = "front/manage";
        $this->loadModel('Event');
        $shop = $this->Session->read('Shop');
        $event_ID = $shop['Order']['event_id'];
        $session_id = $this->Session->id();
        $this->Event->unBindModel(array('hasMany' => array('EventDate','EventEditedUser','EventFbattendUser','EventImages','TicketPrice','EventCategory'), 'belongsTo' => array('User'),'hasOne'=>array('Giveaway','Topevent','RecommendedEvent')), false);
        $get_event = $this->Event->find('first', array('fields' => array('id','end_date'), 'conditions' => array('Event.id' =>$event_ID)));
        $end_date = date('m/d/Y', strtotime($get_event['Event']['end_date']));
        $this->set('endDate', $end_date);
        $this->set(compact('shop','session_id'));
    }
    
     /*@Created:   24-April-2017
     * @Method :    promote
     * @Author:     Shashi 
     * @Modified :   ---
     * @Purpose:   save custom packages data into the database. 
     * @Param:    
     * @Return:      none
     */
    
    public function saveorder() {
        $this->autoRender = false;
        $this->layout = "front/manage";
        $this->loadModel('Order');
        $this->loadModel('OrderDetail');
        $this->loadModel('User');
        $this->loadModel('LeaderboardBanner');
        $this->loadModel('MajorMediaPost');
        $this->loadModel('Event');
        $order = $this->Session->read('Shop');
        $postData = $this->request->data;
        if(isset($postData['paypal']) && $postData['paypal']=="submit") {
            $session_id = $this->Session->id();
            foreach ($order['OrderItem'] as $key => $item) {
                if(isset($postData['OrderItem'][$key]) && !empty($postData['OrderItem'][$key])) {
                    $newarray=$postData['OrderItem'][$key];
                    $result[$key] = array_merge($item,$newarray);
                }
            }
            $this->Session->write('Shop.OrderDetail',$result);
            $this->redirect(array('controller' => 'payments', 'action' => 'paypalSection', base64_encode($session_id)));  
        }
        $result = array();
        if ($this->request->is('post')) {
            $user_id = $this->Auth->user('id');
            $user_data = $this->User->findById($user_id);
            $full_name = $user_data['User']['first_name'] . " " . $user_data['User']['last_name'];
            $amount =   $this->request->data['Payment']['amount'];
            $card_num = $this->request->data['Payment']['cardnumber'];
            $card_cvv = $this->request->data['Payment']['cvv'];
            $exp_date = $this->request->data['Payment']['expiryMonth'] . date('y', strtotime('01-01-' . $this->request->data['Payment']['expiryYear']));
            $response = $this->AuthorizeNet->validate_card(LOGINID, TRANSACTIONKEY, $amount, $card_num, $exp_date, $card_cvv, $user_data);
            if ($response->approved == 1) {
                $transaction_id = $response->transaction_id;
                $responseCode = $response->response_code . '-' . $response->response_subcode;
                $finalamount = $response->amount;
                $responsetext = $response->response_reason_text;
                foreach ($order['OrderItem'] as $key => $item) {
                    if(isset($postData['OrderItem'][$key]) && !empty($postData['OrderItem'][$key])) {
                        $newarray=$postData['OrderItem'][$key];
                        $result[$key] = array_merge($item,$newarray);
                    }
                }
                $this->Session->delete('Shop.OrderItem');
                $this->Session->write('Shop.OrderDetail',$result);
                $orderDetail = $this->Session->read('Shop');
                $leaderBoardId = 0; $majormediaId = 0;
                if(isset($orderDetail) && !empty($orderDetail)) {
                    $order = array();
                    $order['Order']['payment_status'] = 1;
                    $order['Order']['user_id'] = $this->Auth->user('id');
                    $order['Order']['event_id'] = $orderDetail['Order']['event_id'];
                    $order['Order']['order_type'] = 1;
                    $order['Order']['order_count'] = $orderDetail['Order']['order_item_count'];
                    $order['Order']['total_quantity'] = $orderDetail['Order']['quantity'];
                    $order['Order']['total_amount'] = $orderDetail['Order']['total'];
                    $order['Order']['subtotal_amount'] = $orderDetail['Order']['subtotal'];
                    $order['Order']['response'] = $responsetext;
                    $order['Order']['response_code'] = $responseCode;
                    $order['Order']['transaction_id'] = $transaction_id ;
                    $order['Order']['user_calendar_id'] = CHILD_DOMAIN_ID;
                    
                    foreach($orderDetail['OrderDetail'] as $key => $item) {
                                  
                        $order['OrderDetail'][$key]['plan_id'] = $item['plan_id'];
                        $order['OrderDetail'][$key]['package_id'] = $item['product_id'];
                        $order['OrderDetail'][$key]['package_name'] = $item['name'];
                        $order['OrderDetail'][$key]['price'] = $item['price'];
                        $order['OrderDetail'][$key]['quantity'] = $item['quantity'];
                        $order['OrderDetail'][$key]['subtotal'] = $item['subtotal'];
                        if(isset($item['date1'])) {
                            $order['OrderDetail'][$key]['date1'] = date('Y-m-d', strtotime($item['date1']));
                        }
                        if(isset($item['date2'])) {
                            $order['OrderDetail'][$key]['date2'] = date('Y-m-d', strtotime($item['date2']));
                        }
                        if(isset($item['date3'])) {
                            $order['OrderDetail'][$key]['date3'] = date('Y-m-d', strtotime($item['date3']));
                        }
                        if(isset($item['date4'])) {
                            $order['OrderDetail'][$key]['date4'] = date('Y-m-d', strtotime($item['date4']));
                        }
                        if($item['plan_id'] == '6') {
                            $order['Order']['is_media'] = 1;
                            $order['Order']['post_media_city'] = $item['post_media_city'];
                            $order['OrderDetail'][$key]['post_media_city'] = $item['post_media_city'];
                            $media['MajorMediaPost']['state_name'] =  $item['post_media_city'];
                            $media['MajorMediaPost']['event_id'] = $orderDetail['Order']['event_id']; 
                            $this->MajorMediaPost->save($media);
                            $majormediaId = $this->MajorMediaPost->getLastInsertID();
                        }
                        if($item['plan_id'] == '4') {
                            $order['Order']['is_banner'] = 1;
                            $order['OrderDetail'][$key]['start_date'] = date('Y-m-d', strtotime($item['start_date']));
                            $order['OrderDetail'][$key]['end_date'] = date('Y-m-d', strtotime($item['end_date']));
                            $this->Event->unBindModel(array('hasMany' => array('EventDate','EventEditedUser','EventFbattendUser','EventImages','TicketPrice','EventCategory'), 'belongsTo' => array('User'),'hasOne'=>array('Giveaway','Topevent','RecommendedEvent')), false);
                            $get_event = $this->Event->find('first', array('fields' => array('zip_code', 'state'), 'conditions' => array('Event.id' =>$orderDetail['Order']['event_id'])));
                            $data['LeaderboardBanner']['start_date'] = date('Y-m-d', strtotime($item['start_date']));
                            $data['LeaderboardBanner']['end_date'] = date('Y-m-d', strtotime($item['end_date']));
                            $data['LeaderboardBanner']['zip'] = $get_event['Event']['zip_code']; 
                            $data['LeaderboardBanner']['state'] = $get_event['Event']['state'];
                            $data['LeaderboardBanner']['status'] = 0; 
                            $this->LeaderboardBanner->save($data);
                            $leaderBoardId = $this->LeaderboardBanner->getLastInsertID();
                        }
                    }
                } 
                $save = $this->Order->saveAll($order, array('validate' => 'false'));
                if($save) {
                    $lastorderId = $this->Order->getLastInsertID();
                    $this->Order->id = $lastorderId;
                    $this->Order->saveField('leaderboard_banner_id', $leaderBoardId);
                    $this->Order->saveField('major_media_post_id', $majormediaId);
                    $this->paymentEmail($lastorderId,$user_data['User']['email']);
                    $this->Session->setFlash(__("$responsetext"), "default", array("class" => "green"));
                }   
                $this->redirect(array('controller' => 'sales', 'action' => 'orderList'));
            } else {
                $responsetext = $response->response_reason_text;
                $this->Session->setFlash(__("$responsetext"), "default", array("class" => "red"));
                $this->redirect(array('controller' => 'marketing', 'action' => 'cart'));
            }
        }
    }
    
        public function paymentEmail($paymentId,$userEmail) {
        $this->layout = FALSE;
        $this->autoRender = FALSE;
        $this->loadModel("EmailTemplate");
        $this->loadModel("Order");
        $this->loadModel('User');
        if ($paymentId) {
            $this->User->unbindModel(array('hasMany'=>array('UserpCategory','UserpVibe'),'belongsTo'=>array('Brand')));
            $this->Order->bindModel(array('belongsTo'=>array('User'=>array('fields'=>array('User.email','User.id','User.first_name','User.last_name','User.phone_no')))),false);
            $payment_detail = $this->Order->find("first", array("conditions" => array("Order.id" => $paymentId)));
            if ($payment_detail) {
                if ($payment_detail["Order"]["payment_status"] == 1) {
                    $paymentStatus = 'Paid';
                    $emailTemp = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.alias' => "order-confirmation")));
                    $emailContent = utf8_decode($emailTemp['EmailTemplate']['description']);
                    $emailTempAdmin = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.alias' => "order-placed-admin")));
                    $emailContentAdmin = utf8_decode($emailTempAdmin['EmailTemplate']['description']);
                } else {
                    $paymentStatus = 'Failure';
                    $emailTemp = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.alias' => "order-placed")));
                    $emailContent = utf8_decode($emailTemp['EmailTemplate']['description']);

                    $emailTempAdmin = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.alias' => "order-placed-admin")));
                    $emailContentAdmin = utf8_decode($emailTempAdmin['EmailTemplate']['description']);
                }
                $invoice = "";
                foreach ($payment_detail['OrderDetail'] as $key => $items) { 
                    $date1 = $date2 = $date3 = '';
                        $date1 = $date2 = $date3 = $date4 = '';
                        if (!empty($items['date1'])) {
                            $date1 = date('m/d/Y', strtotime($items['date1']));
                        }
                        if (!empty($items['date2'])) {
                            $date2 = ', '.date('m/d/Y',strtotime($items['date2']));
                        }
                        if (!empty($items['date3'])) {
                            $date3 = ', '.date('m/d/Y',strtotime($items['date3']));
                        }
                        if (!empty($items['date4'])) {
                            $date4 = ', '.date('m/d/Y', strtotime($items['date4']));
                        }
                        if ($items['plan_id'] == 4) {
                            $date1 = date('m/d/Y',strtotime($items['start_date']));
                            $date2 = date('m/d/Y',strtotime($items['end_date']));
                        }
                        $invoice.= '<tr>
                                    <td style="padding: 15px; border-bottom:1px #c2c2c2 solid;"><table class="contenttable" align="left" width="440" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                    <tbody>
                                        <tr>
                                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; padding-bottom: 4px;">'.$items['package_name'].'</td>
                                        </tr>
                                    <tr>';
                        if($items['plan_id'] == 6){
                            $invoice.= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height: 16px; color:#7b7b7b;"> Posted to major media city - '.$items['post_media_city'].'</td>';
                        }elseif($items['plan_id'] == 4){
                             $invoice.= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height: 16px; color:#7b7b7b;">'.$items['quantity'].' week(s) from ('.$date1.' to '.$date2.')</td>';
                        }else {
                            $invoice.= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height: 16px; color:#7b7b7b;">'.$items['quantity'].' week(s) on the following date(s) ('. $date1.$date2.$date3.$date4.')</td>';
                        }
                                           
                        $invoice.=  '</tr>	
                                </tbody>
                                 </table><table class="contenttable" align="right" width="70" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                 <tbody>
                                 <tr>
                                     <td align="right" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; padding-right:14px;">$'.number_format($items['subtotal'],2).'</td>
                                 </tr>
                               </tbody>
                               </table></td>
                                 </tr>';

                }
                //$url = "https://" . $_SERVER["HTTP_HOST"] . "/Sales/orderList";
                $data = str_replace(array('{EMAIL_LOGO}','{SUPPORT_EMAIL}','{CONTACT_ADDRESS}','{COMPANY_URL}','{USER_NAME}','{USER_EMAIL}','{USER_PHONE}', '{TRANSACTION_ID}', '{INVOICE}', '{AMOUNT}' ,'{ORDER_DATE}'), array($this->email_logo,$this->support_email,$this->contact_address,$this->company_url,$payment_detail['User']['first_name'].' '.$payment_detail['User']['last_name'],$payment_detail['User']['email'],$payment_detail['User']['phone_no'], $payment_detail["Order"]['transaction_id'],$invoice, $payment_detail["Order"]["subtotal_amount"], date("l, F d, Y", strtotime($payment_detail["Order"]["created"]))), $emailContent);
                $emailTemp['EmailTemplate']['subject'] = str_replace(array("{TRANSACTION_ID}"), array($payment_detail["Order"]["transaction_id"]), $emailTemp['EmailTemplate']['subject']);
                $this->set('mailData', $data);
                $from = $this->company_name.' <'.$this->support_email.'>';
                
                $this->Mailgun->sendMail($payment_detail['User']['email'], $emailTemp['EmailTemplate']['subject'], $data,$from);
                // now send to admin
                //$url = "https://" . $_SERVER["HTTP_HOST"] . "/admin/Payments";
                $dataAdmin = str_replace(array('{EMAIL_LOGO}','{SUPPORT_EMAIL}','{CONTACT_ADDRESS}','{COMPANY_URL}','{USER_NAME}', '{TRANSACTION_ID}', '{INVOICE}', '{AMOUNT}' ,'{ORDER_DATE}'), array($this->email_logo,$this->support_email,$this->contact_address,$this->company_url,$payment_detail['User']['first_name'].' '.$payment_detail['User']['last_name'], $payment_detail["Order"]['transaction_id'],$invoice, $payment_detail["Order"]["subtotal_amount"], date("l, F d, Y", strtotime($payment_detail["Order"]["created"]))), $emailContentAdmin);
                $emailTempAdmin['EmailTemplate']['subject'] = str_replace(array("{TRANSACTION_ID}"), array($payment_detail["Order"]["transaction_id"]), $emailTempAdmin['EmailTemplate']['subject']);
                $this->set('mailData', $dataAdmin);
                $from = $this->company_name.' <'.$this->support_email.'>';
                $this->Mailgun->sendMail($this->support_email, $emailTempAdmin['EmailTemplate']['subject'], $dataAdmin,$from);
            }
        }
        return 1;
    }
}
?>

