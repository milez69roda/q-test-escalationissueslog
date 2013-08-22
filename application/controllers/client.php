<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start();
class Client extends CI_Controller {

	public $userid;
	public $username;
	public $role_id;
	public $user_fullname;
	private $start_date = '2013-01-01';
	private $end_date; 
	public $access = array(); 

	public function __construct(){ 
		parent::__construct(); 
		
		if( !$this->session->userdata('ESCISSL_ISLOGIN') ){
		 	redirect(base_url().'login');
		}
		
		$this->userid 			= $this->session->userdata('ESCISSL_USERID'); 
		$this->username 		= $this->session->userdata('ESCISSL_USER_NAME'); 
		$this->user_fullname 	= $this->session->userdata('ESCISSL_FULLNAME'); 
		$this->access 			= $this->session->userdata('ESCISSL_ACCESS');
		$this->role_id 			= $this->session->userdata('ESCISSL_ROLEID');
		$this->load->model('Dropdowns', 'dropdowns');
		
		$this->end_date 			= date('Y').'-12-31'; 
	}
	
	public function index() {
	
		if( $this->role_id == 4 ){
			if( in_array(1, $this->access) ){
				redirect(base_url().'escalation/form');
			}else{
				redirect(base_url().'issues/form');
			}			
		}else{
			if( in_array(1, $this->access) ){
				$this->load->model("Escalation_Model", 'escalation');
				
				$hdata['container'] = 'container-fluid';
				$hdata['nactive'] = 'overview';
				$this->load->view('header', $hdata );
				$data = '';  

				$this->load->view('index', $data);
				$this->load->view('footer');		 
			}else{
				redirect(base_url().'issues/overview');
			}
		}
	}	
	
	public function issues_overview(){
		
		$hdata['container'] = 'container-fluid';
		$hdata['nactive'] = 'overview';
		$data = ''; 
		
		$this->load->view('header', $hdata );	   
		$this->load->view('index_issues_overview', $data);
		$this->load->view('footer');		
	}
	
	public function escalationdetails(){
		$this->load->model("Escalation_Model", 'escalation');
		
		$data['results'] = $this->escalation->escalation_details();
		
		$hdata['container'] = 'container-fluid';
		$hdata['nactive'] = 'overview';
		$this->load->view('header', $hdata );
		$this->load->view('table_escalation_details', $data);
		$this->load->view('footer');
	}
	
	public function escalation_source(){
		$this->load->model("Escalation_Model", 'escalation');
		
		$start 	= isset($_GET['start'])?$_GET['start']:$this->start_date; 
		$end 	= isset($_GET['end'])?$_GET['end']:$this->end_date;
		$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:'';
		
		$data['escalationsource'] = $this->escalation->escalation_source($start, $end, $cat_id );
		echo $this->load->view('table_escalation_source', $data, false);
	}
	
	public function escalation_issuetype(){
		$this->load->model("Escalation_Model", 'escalation');
		 
		$start 	= isset($_GET['start'])?$_GET['start']:$this->start_date; 
		$end 	= isset($_GET['end'])?$_GET['end']:$this->end_date;
		$from_id = isset($_GET['from_id'])?$_GET['from_id']:'';		
		
		$data['escalationissuetype'] 	= $this->escalation->escalation_issuetype($start, $end, $from_id );
		echo $this->load->view('table_escalation_issuetype', $data, false);
	}
	
	
	public function issue_source(){
		$this->load->model("Issues_Model", 'issuesmodel');
		
		//$start 	= isset($_GET['start'])?$_GET['start']:date('Y-m-d', strtotime('first day of january '.date('Y')));
		$start 	= isset($_GET['start'])?$_GET['start']:$this->start_date;
		//$start 	= '2013-01-01';
		//$end 	= isset($_GET['end'])?$_GET['end']:date('Y-m-d');
		//$end 	= isset($_GET['end'])?$_GET['end']:date('Y-m-d', strtotime('last day of december '.date('Y')));
		$end 	=  isset($_GET['end'])?$_GET['end']:$this->end_date;
		$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:'';
		
		$data['issuesource'] = $this->issuesmodel->issue_source($start, $end, $cat_id );
		echo $this->load->view('table_issue_source', $data, false);
	}
	
	public function issue_details(){ 
		
		$this->db->where("DATE_FORMAT(log_issues.start_date, '%Y%m') = ", $_GET['date'] );
		$this->db->where("sys_imp_id", $_GET['id'] );
		$this->db->select('log_issues.created_date,
						sys_imp, 
						log_issues.start_date, 
						log_issues.end_date,
						issue_no,
						total_downtime,
						center,
						incident_no,
						issue_desc,
						root_cause,
						cr_no,
						cr_deploy_date,
						resolve_by,
						po_cust_impact,
						ca_ticket_no,
						notification_no,
						drop_calls,
						agent_impacted,
						staff_mia,
						staff_atl,
						user_fullname,
						log_issues.id
						');
		$this->db->join('log_issues', 'log_issues.id = log_issues_sysimp_link.log_issue_id');				
		$data['results'] = $this->db->get('log_issues_sysimp_link')->result();		 
	  
		 
		$hdata['container'] = 'container-fluid';
		$hdata['nactive'] = 'issues';
		$this->load->view('header', $hdata );
		$this->load->view('table_issue_details', $data);
		$this->load->view('footer');		
	}	
	
	 
	public function escalationform(){
		
		if( !in_array(1, $this->access) ) redirect(base_url().'issues/form');
		
		$data['nav'] 		= $this->load->view('nav', array('navlog'=>'escalation'), true);
		$data['brands']	 	= $this->dropdowns->brands_dropdown2();
		$data['issues']	 	= $this->dropdowns->issues_dropdown2();
		$data['from'] 		= $this->dropdowns->from_dropdown2();
		$data['root_cause'] = $this->dropdowns->root_cause_dropdown2();
		$data['system'] 	= $this->dropdowns->system_impacting_dropdown2();
		
		$hdata['nactive'] = 'escalation';
		
		if( isset($_GET['edit']) AND $_GET['edit'] != ''){
			$id = $_GET['edit'];
			
			$this->db->where('id', $id);
			$data['row'] = $this->db->get('log_escalation')->row();
			
			if( $this->session->userdata('ESCISSL_ROLEID') != 1){ 
				if($data['row']->user_id != $this->userid ){
					redirect(base_url().'escalation/summary');
				}
			} 
		
			$this->load->view('header', $hdata );
			$this->load->view('escalation_form_edit', $data);
			$this->load->view('footer');			
		}else{
		
			$this->load->view('header', $hdata );
			$this->load->view('escalation_form', $data);
			$this->load->view('footer');	
			
		} 
	}
	
	public function escalation_save(){
		$json = array('status'=>false, 'msg'=>'Failed to submit');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('es_from', 'From', 'required');
		$this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
		//$this->form_validation->set_rules('serial_no', 'Serial #', 'required');
		$this->form_validation->set_rules('brands', 'Brands', 'required');
		$this->form_validation->set_rules('issues_cat', 'Issues Category', 'required');		
		//$this->form_validation->set_rules('cr_deploy_date', 'CR Deployment Date', 'required');
		$this->form_validation->set_rules('es_status', 'Status', 'required');
		
		if( $this->form_validation->run() ) {
		
			$set['date_received'] 	= $this->input->post('date_received');
			
			@$from = explode(':',$this->input->post('es_from'));
			$set['es_from_id'] 		= $from[0];
			$set['es_from'] 		= $from[1];
			
			$set['cust_name']		= $this->input->post('cust_name');
			$set['email_address']		= $this->input->post('email_address');
			$set['serial_no'] 		= $this->input->post('serial_no');
			$set['es_min'] 			= $this->input->post('es_min');
			$set['es_contact'] 		= $this->input->post('es_contact');
			
			@$brands = explode(':',$this->input->post('brands'));
			$set['brands_id'] 		= $brands[0];
			$set['brands'] 			= $brands[1];
			
			@$issue_cat = explode(':',$this->input->post('issues_cat'));
			$set['issues_cat_id'] 	= $issue_cat[0];
			$set['issues_cat'] 		= $issue_cat[1];
			
			if( $issue_cat[1] == 'Other' )  
				$set['issues_cat_other'] 	= $this->input->post('issues_cat_other');			
			
			$set['issues_details'] 	= $this->input->post('issues_details');
			$set['sent_fj'] 		= $this->input->post('sent_fj');
			$set['block_email_fj'] 	= $this->input->post('block_email_fj');
			
			/* @$resolution = explode(':',$this->input->post('resolution'));
			$set['resolution_id'] 	= @$resolution[0];
			$set['resolution'] 		= @$resolution[1]; */
			
			$set['resolution'] 		= $this->input->post('resolution');
			
			/* if( $resolution[1] == 'Other' )  
				$set['resolution'] 	= $this->input->post('resolution_other');			 */
			
			$set['ca_ticket_no'] 		= $this->input->post('ca_ticket_no');
			$set['system_impacting'] 	= $this->input->post('system');
			$set['root_cause'] 		= $this->input->post('root_cause');
			$set['cr_no'] 			= $this->input->post('cr_no'); 
			$set['cr_deploy_date'] 	= $this->input->post('cr_deploy_date'); 
			$set['po_cust_impact'] 	= $this->input->post('po_cust_impact'); 
			$set['es_status'] 		= $this->input->post('es_status'); 
			
			if( $this->input->post('ftype') == 'edit' ){
				$set['last_updateby_id'] 		= $this->userid;
				$set['last_udpateby_name'] 		= $this->username;
				$set['last_updateby_fullname'] 	= $this->user_fullname;
				$set['last_update_date'] 		= date("Y-m-d H:i:s");
				$set['last_update_ip'] 			= $_SERVER['REMOTE_ADDR'];
			}else{ 
				$set['user_id'] 		= $this->userid;
				$set['user_name'] 		= $this->username;
				$set['user_fullname'] 	= $this->user_fullname;
				$set['ip_address'] 		= $_SERVER['REMOTE_ADDR'];
			}
			
			if( $this->input->post('ftype') == 'edit' ){
				$this->db->where('id', $this->input->post('indexid'));
				if( $this->db->update('log_escalation', $set) ){
					$json['status'] = true;	
					$json['msg'] = 'Succesfully Updated!!!';
				}else{
					$json['msg'] = 'Failed to save the form';
				} 			
			}else{
				if( $this->db->insert('log_escalation', $set) ){
					$json['status'] = true;	
					$json['msg'] = 'Succesfully Submitted!!!';
				}else{
					$json['msg'] = 'Failed to submit the form';
				} 
			}
			
		}else{			
			$json['msg'] = validation_errors();
		}		
		
		echo json_encode($json);		
	}
	
	public function escalationsummary(){
		
		if( !in_array(1, $this->access) ) redirect(base_url().'issues/summary');
		
		$data['nav'] = $this->load->view('nav', array('navlog'=>'escalation'), true); 
		$data['brands'] = $this->dropdowns->brands_dropdown2();
		$data['issues'] = $this->dropdowns->issues_dropdown2();
		$data['from'] = $this->dropdowns->from_dropdown2();		
		
		$hdata['container'] = 'container-fluid';
		$hdata['nactive'] = 'escalation';
		$this->load->view('header', $hdata );
		$this->load->view('escalation_summary', $data);
		$this->load->view('footer');	
	}
	
	public function ajax_escalation_summary(){ 
		
		$this->load->model("Escalation_Model", 'escalation');
		$this->escalation->get(''); 
	}
	 
	public function issuesform(){
		
		if( !in_array(2, $this->access) ) redirect(base_url().'escalation/form');
		
		$data['nav'] = $this->load->view('nav', array('navlog'=>'issues'), true);
		$data['centers'] = $this->dropdowns->center_dropdown1();
		$data['system_impacting'] = $this->dropdowns->system_impacting_dropdown1();
		$data['root_cause'] = $this->dropdowns->resolution_dropdown1();
		
		$hdata['nactive'] = 'issues';
	
		
		if( isset($_GET['edit']) AND $_GET['edit'] != ''){
			$id = $_GET['edit'];
			
			$this->db->where('id', $id);
			$data['row'] = $this->db->get('log_issues')->row();
			
			if( $this->session->userdata('ESCISSL_ROLEID') != 1){ 
				if($data['row']->user_id != $this->userid ){
					redirect(base_url().'issues/summary');
				}
			} 
		
			$this->load->view('header', $hdata );
			$this->load->view('issues_form_edit', $data);
			$this->load->view('footer');			
		}else{ 
			$this->load->view('header', $hdata );
			$this->load->view('issues_form', $data);
			$this->load->view('footer'); 
		}		
	
	}	
	
	public function issues_save(){
		$json = array('status'=>false, 'msg'=>'Failed to submit');
		$this->load->library('form_validation');
		
		//$this->form_validation->set_rules('issue_no', 'Issue #', 'required');
		$this->form_validation->set_rules('incident_no', 'Incident #:', 'required'); 
		$this->form_validation->set_rules('center', 'Center', 'required'); 
		$this->form_validation->set_rules('sys_impacting', 'System Impacting', 'required'); 
		$this->form_validation->set_rules('po_cust_impact', 'Potential Customer Impact (ORR/PSI)', 'is_natural'); 
		
		if( $this->form_validation->run() ) {
			
			$system = $this->dropdowns->system_impacting_dropdown();
			
			$start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date').' '.$this->input->post('time1')) );
			$end_date =  date('Y-m-d H:i:s', strtotime($this->input->post('end_date').' '.$this->input->post('time2')) );
			
			$set['start_date'] 		= $start_date;
			$set['end_date'] 		= $end_date;
			//$set['issue_no'] 		= $this->input->post('issue_no');
			
			$datetime1 = strtotime($start_date);
			$datetime2 = strtotime($end_date);
			$interval  = @abs($datetime2 - $datetime1);			
			
			$set['total_downtime_in_sec']	= $interval;
			$set['total_downtime']	= $this->input->post('total_downtime');
			
			$sys_impacting = @implode(',',$this->input->post('sys_impacting')); 
			$set['sys_impacting'] 		= $sys_impacting;
			$set['sys_impacting_other'] = $this->input->post('sys_imp_other');
			
			$center = @implode(',',$this->input->post('center'));			
			$set['center'] 			= $center;
			
			$set['incident_no'] 	= $this->input->post('incident_no');
			$set['issue_desc'] 		= $this->input->post('issue_desc');
			//$set['root_cause'] 		= $this->input->post('root_cause');
			
			/* $root_cause = explode(':',$this->input->post('root_cause'));
			$set['root_cause_id'] 	= @$root_cause[0];
			$set['root_cause'] 		= @$root_cause[1]; */			
			
			$set['root_cause'] 		= $this->input->post('root_cause');
			$set['cr_no'] 			= $this->input->post('cr_no');
			$set['cr_deploy_date'] 	= $this->input->post('cr_deploy_date');
			$set['resolve_by'] 		= $this->input->post('resolve_by'); 
			$set['po_cust_impact'] 	= $this->input->post('po_cust_impact'); 
			$set['ca_ticket_no'] 	= $this->input->post('ca_ticket_no');
			//$set['notification_no'] = $this->input->post('notification_no');
			
			$set['drop_calls'] 		= $this->input->post('drop_calls'); 
			$set['agent_impacted'] 	= $this->input->post('agent_impacted'); 
			$set['staff_mia'] 		= $this->input->post('staff_mia'); 
			$set['staff_atl'] 		= $this->input->post('staff_atl'); 
			
			if( $this->input->post('ftype') == 'edit' ){
				$set['last_updateby_id'] 		= $this->userid;
				$set['last_udpateby_name'] 		= $this->username;
				$set['last_updateby_fullname'] 	= $this->user_fullname;
				$set['last_update_date'] 		= date("Y-m-d H:i:s");
				$set['last_update_ip'] 			= $_SERVER['REMOTE_ADDR'];
			}else{ 
				$set['user_id'] 		= $this->userid;
				$set['user_name'] 		= $this->username;
				$set['user_fullname'] 	= $this->user_fullname;
				$set['ip_address'] 		= $_SERVER['REMOTE_ADDR'];
			}			
			
			if( $this->input->post('ftype') == 'edit' ){	
				$indexid = $this->input->post('indexid');
				$this->db->where('id', $indexid);
				if( $this->db->update('log_issues', $set) ){
					
					$this->db->delete('log_issues_sysimp_link', array('log_issue_id' => $indexid)); 
					
					if( count($this->input->post('sys_impacting')) > 0  ){ 
						foreach($this->input->post('sys_impacting') as $val){
							$set2['start_date'] 		= $start_date;
							$set2['end_date'] 		= $end_date;							
							$set2['log_issue_id'] 	= $indexid;
							$set2['sys_imp'] 		= $val;
							$this->db->insert('log_issues_sysimp_link', $set2);
						}
					}				
				
					$json['status'] = true;	
					$json['msg'] = 'Succesfully Updated!!!';
				}else{
					$json['msg'] = 'Failed to save the form';
				} 				
			
			}else{
				if( $this->db->insert('log_issues', $set) ){
					$id = $this->db->insert_id();
					
					if( count($this->input->post('sys_impacting')) > 0  ){ 
						$sys_impacting1 = $this->input->post('sys_impacting');
						foreach( $sys_impacting1 as $val){
							$set2['start_date'] 	= $start_date;
							$set2['end_date'] 		= $end_date;						
							$set2['log_issue_id'] 	= $id;
							$set2['sys_imp_id'] 	= array_search($val, $system);
							$set2['sys_imp'] 		= $val;
							$set2['sys_imp_other'] 	= $this->input->post('sys_imp_other');
							
							$this->db->insert('log_issues_sysimp_link', $set2);
						}
					}
					
					$json['status'] = true;	
					$json['msg'] = 'Succesfully Submitted!!!';
				}else{
					$json['msg'] = 'Failed to submit the form';
				}			
			} 
			
		}else{			
			$json['msg'] = validation_errors();
		}		
		
		echo json_encode($json);		
	}	
	
	public function issuessummary(){
	
		if( !in_array(2, $this->access) ) redirect(base_url().'escalation/summary');
	
		$data['nav'] = $this->load->view('nav', array('navlog'=>'issues'), true);
		$data['centers'] = $this->dropdowns->center_dropdown1();
		$data['system_impacting'] = $this->dropdowns->system_impacting_dropdown1();
		
		$hdata['container'] = 'container-fluid';
		$hdata['nactive'] = 'issues';
		$this->load->view('header', $hdata );
		$this->load->view('issues_summary', $data);
		$this->load->view('footer');	
	}
	
	public function ajax_issues_summary(){ 
		
		$this->load->model("Issues_Model", 'issues');
		$this->issues->get(''); 
	}	

	public function datediff(){
		
		/* $start = new DateTime(date('Y-m-d H:i:s',strtotime($this->input->post('start'))));
		$end = new DateTime(date('Y-m-d H:i:s',strtotime($this->input->post('end'))) ); 
		//var_dump($start);
		$dDiff = $start->diff($end);
		//echo var_dump($dDiff);
		echo ($dDiff->format('%days')*(60*24))+$dDiff->format('%h').':'.$dDiff->format('%i'); */
		
		$datetime1 = strtotime($this->input->post('start'));
		$datetime2 = strtotime($this->input->post('end'));
		$interval  = abs($datetime2 - $datetime1);
		$time = $interval / 60 / 60;
		$hr  = floor($time);		
		$min   = ($time-$hr)*60;		
		echo $hr.':'.$min;
	}
	
	public function export(){
		
		$this->load->library('ExportDataExcel');  		
		$excel 		= new ExportDataExcel('browser');
		$channel 	= $_GET['channel'];
		
		$excel->filename = $channel.'_'.strtotime('now').".xls";	
	
	
		$header = ''; 
		switch($channel){
			case 'escalation':
				$this->db->select('date_received, es_from, cust_name, email_address, serial_no, brands, issues_cat, issues_cat_other, issues_details, sent_fj, block_email_fj, root_cause, system_impacting, resolution, cr_no, cr_deploy_date, po_cust_impact, es_status, user_fullname, last_updateby_fullname');
				$header = array('Date Received',
								'From',
								'Customer Name', 
								'Email', 
								'Serial #',								
								'Brand',								
								'Issue Category',								
								'Issue Category: Other',								
								'Issue Details',								
								'Sent only to FJ',								
								'Block from emailing FJ',								
								'Root Cause',								
								'System',								
								'Resolution',								
								'CR #: (ORR/PSI)',								
								'CR Deployment Date: (ORR/PSI)',								
								'Potential Customer Impact (ORR/PSI)',								
								'Status:',								
								'Created By',
								'Last Updated By'	
								);
				$nosearch = 0;				
				if( isset($_GET['start_date']) AND $_GET['start_date'] != '' AND  isset($_GET['end_date']) and $_GET['end_date'] != '') {
					$this->db->where(' DATE_FORMAT(date_received, \'%Y-%m-%d\') BETWEEN ', "'".$_GET['start_date']."' AND '".$_GET['end_date']."'", false);
					$nosearch++;	
				}	
				
				if( isset($_GET['es_from']) AND $_GET['es_from'] != '' ){
					$from = explode(':', $_GET['es_from']);
					$this->db->where('es_from_id', $from[0] ); 
					$nosearch++;
				}
				
				if( isset($_GET['brands']) AND $_GET['brands'] != '' ){
					$brands = explode(':', $_GET['brands']);
					$this->db->where('es_from_id', $brands[0]); 
					$nosearch++;
				}
				
				if( isset($_GET['issues']) AND $_GET['issues'] != ''){
					$issues = explode(':', $_GET['issues']);
					$this->db->where('issues_cat_id', $issues[0]); 
					$nosearch++;
				}	

				if( isset($_GET['cr_no']) AND $_GET['cr_no'] != ''){ 
					$this->db->where('cr_no', mysql_real_escape_string($_GET['cr_no'])); 
					$nosearch++;
				}
				
				if( isset($_GET['sent_fj']) AND $_GET['sent_fj'] != ''){ 
					$this->db->where('sent_fj', $_GET['sent_fj']); 
					$nosearch++;
				}

				if( isset($_GET['block_email_fj']) AND $_GET['block_email_fj'] != ''){ 
					$this->db->where('block_email_fj', $_GET['block_email_fj']); 
					$nosearch++;
				}		
				
				
				//overview options
				if( isset($_GET['id']) AND $_GET['id'] != ''){ 
					$this->db->where('issues_cat_id', $_GET['id']); 
					$nosearch++;
				}	
				
				if( isset($_GET['month']) AND $_GET['month'] != ''){ 
					$this->db->where(" DATE_FORMAT(created_date, '%Y%m')=", $_GET['month'], false);
					$nosearch++;
				}

				if( isset($_GET['from']) AND $_GET['from'] != 0 ){
					$this->db->where('es_from_id', $_GET['from'] );
					$nosearch++;
				}
				
				
				if( $nosearch == 0 ){ 
					$this->db->where(" DATE_FORMAT(created_date, '%Y-%m-%d') = ", "'".date('Y-m-d')."'", false); 
				}
				 
				$this->db->order_by('created_date', 'desc');	
				$records = $this->db->get('log_escalation')->result(); 		
				//echo $this->db->last_query();				
				break;			
			case 'issues':
				$this->db->select('start_date,end_date,CONCAT(\' \',LPAD(`id`, 5,0)),total_downtime,sys_impacting,center,incident_no,issue_desc,root_cause,cr_no,cr_deploy_date,resolve_by,po_cust_impact,ca_ticket_no,notification_no,user_fullname,last_updateby_fullname', false);
				$header = array('Start',
								'End',
								'Issue #',
								'Total Down Time',
								'System Impacting',
								'Centers',
								'Incident #',
								'Issue Description',
								'Root Cause',
								'CR #',
								'Cr Deployment DAte',
								'Resolve By',
								'Potential Customer Impact',
								'CA Ticket #',
								//'Notification #',
								'Created By',
								'Last Updated By' 					
								);
								
				$nosearch = 0;				
				if( isset($_GET['start_date']) AND $_GET['start_date'] != '' AND  isset($_GET['end_date']) and $_GET['end_date'] != '') {
					$this->db->where(' DATE_FORMAT(start_date, \'%Y-%m-%d\') BETWEEN ', "'".$_GET['start_date']."' AND '".$_GET['end_date']."'", false);
					$this->db->where(' DATE_FORMAT(end_date, \'%Y-%m-%d\') BETWEEN ', "'".$_GET['start_date']."' AND '".$_GET['end_date']."'", false);
					$nosearch++;	
				}	
				 
				if( @is_array($_GET['system']) ){ 
					foreach($_GET['system'] as $row){ 
						$this->db->or_like('sys_impacting', $row); 
					} 
					$nosearch++;	
				}
 
				if( @is_array($_GET['center']) ){ 
					foreach($_GET['center'] as $row){ 
						$this->db->or_like('center', $row); 
					} 
					$nosearch++;	
				}	

				if( isset($_GET['incident_no']) AND $_GET['incident_no'] != ''){ 
					$this->db->where('incident_no', mysql_real_escape_string($_GET['incident_no'])); 
					$nosearch++;
				}
				
				if( isset($_GET['ca_ticket_no']) AND $_GET['ca_ticket_no'] != ''){ 
					$this->db->where('ca_ticket_no', mysql_real_escape_string($_GET['ca_ticket_no'])); 
					$nosearch++;
				}	

				if( $nosearch == 0 ){ 
					$this->db->where(" DATE_FORMAT(created_date, '%Y-%m-%d') = ", "'".date('Y-m-d')."'", false); 
				}		
				
				$this->db->order_by('created_date', 'desc');	
				$records = $this->db->get('log_issues')->result(); 	
				
				break;	
			case 'oissues': 
				$header = array('Create Date',
								'System Impacting',
								'Start Date/Time 	',
								'End Date/Time',
								'Issue #',
								'Total Down Time',
								'Centers',
								'Incident #',
								'Issue Description',
								'Root Cause',
								'CR #',
								'CR Deployment Date',
								'Resolve by',
								'Potential Customer Impact',
								'CA Ticket #',
								 
								'# of Dropped Calls',					
								'# Agents Impact',					
								'Agents Staffed: MIA',					
								'Agents Staffed: ATL',					
								'Created By'					
								);

								
				$this->db->where("DATE_FORMAT(log_issues.start_date, '%Y%m') = ", $_GET['date'] );
				$this->db->where("sys_imp_id", $_GET['id'] );
				$this->db->select('log_issues.created_date,
								sys_imp, 
								log_issues.start_date, 
								log_issues.end_date,
								CONCAT(\' \',LPAD(log_issues.id, 5,0)),
								total_downtime,
								center,
								incident_no,
								issue_desc,
								root_cause,
								cr_no,
								cr_deploy_date,
								resolve_by,
								po_cust_impact,
								ca_ticket_no,
								 
								drop_calls,
								agent_impacted,
								staff_mia,
								staff_atl,
								user_fullname
								',false);
				$this->db->join('log_issues', 'log_issues.id = log_issues_sysimp_link.log_issue_id');				
				$records = $this->db->get('log_issues_sysimp_link')->result();						
				break;
			case 'escalationoverviewfrom':
				$escalation_from = $this->session->userdata('ESCISSL_OVESCALATION_FROM');
				$header		= $escalation_from['header'];
				$records	= $escalation_from['data']; 
				break;
			case 'escalationoverviewdetails':
				$escalation_details = $this->session->userdata('ESCISSL_OVESCALATION_DETAILS');
				$header 	= $escalation_details['header'];
				$records 	= $escalation_details['data']; 
				break;
			case 'issuessource':
				$escalation_source = $this->session->userdata('ESCISSL_OVISSUE_DETAILS');
				$header 	= $escalation_source['header'];
				$records 	= $escalation_source['data']; 
				break;
		} 
			
		//echo '<pre>'.$this->db->last_query().'</pre>'; 
		$excel->initialize();
		$excel->addRow($header);
		foreach($records as $row) {
			$excel->addRow($row);
		}
		$excel->finalize();
		 
	}

	public function printit(){
		
		if($_GET['c'] == 'eof'){ 
			$data['title'] = 'Issues Overview';
			$escalation_from = $this->session->userdata('ESCISSL_OVESCALATION_FROM');
			$data['header'] = $escalation_from['header'];
			$data['records'] = $escalation_from['data'];  
		}
		
		if($_GET['c'] == 'eod'){
			$data['title'] = 'Escalation Details ';
			$escalation_details 	= $this->session->userdata('ESCISSL_OVESCALATION_DETAILS');
			$data['header'] = $escalation_details['header'];
			$data['records'] = $escalation_details['data'];  
		}	

		if($_GET['c'] == 'is'){
			$data['title'] = 'Issues Overview';
			$escalation_source 	= $this->session->userdata('ESCISSL_OVISSUE_DETAILS');
			$data['header'] = $escalation_source['header'];
			$data['records'] = $escalation_source['data']; 
		}
		
		$this->load->view('print_tpl', $data);  
	}
	 
	public function myaccount(){
		$hdata['nactive'] = 'home';
		$data = '';
		
		$data['nav'] = $this->load->view('myaccount_nav', '', true);
		$this->load->view('header', $hdata);
		$this->load->view('myaccount', $data);
		$this->load->view('footer');	
	}
	
	public function ajax_changepassword(){
		
		$json = array('status'=>false,'msg'=>'Failed to change password');
		
		if( trim($this->input->post('pass45')) != '' ){
			$this->db->where('username', $this->username );
			$set['password'] 		= strtolower($this->input->post('pass45'));
			$set['newpass_time'] 	= strtotime(date('Y-m-d H:i:s'));
			$set['modified'] 		= date('Y-m-d H:i:s');
			
			if($this->db->update('users',$set)){
				$json['status'] = true;
				$json['msg'] 	= 'Password Changed Successfully';
			}
		
		}else{
			$json['msg'] 	= 'Password must not be empty';
		}
		
		echo json_encode($json);
	}
	
	public function manageaccount(){
		$hdata['nactive'] = 'home';
		$data = '';
		//echo  'tes tes test'.$this->session->userdata('ESCISSL_ROLEID');
		$where = '';
		if( $this->session->userdata('ESCISSL_ROLEID') == 1 )	{
			$this->db->where(' role_id != ', '1', false);	
			
		}else{
			$this->db->where('isVisible', 1);
		}
		
		$data['users'] = $this->db->get('users')->result();
		//echo $this->db->last_query();
		$data['nav'] = $this->load->view('myaccount_nav', '', true);
		$this->load->view('header', $hdata);
		$this->load->view('manageaccount', $data);
		$this->load->view('footer');	
	}	

	public function tobeis(){
	
		$result = $this->db->get_where('log_issues', array('tobetag'=>1))->result();
		
		$sys = $this->db->get('system_impacting')->result();
		
		foreach( $result as $row){
			 
			foreach( $sys as $row1 ){
			
			//echo $row->sys_impacting.'<br/>';
				//$strr = strpos($row->sys_impacting, $row1->desc);
				$pattern = '/'.strtolower($row1->desc).'/';
				preg_match($pattern, strtolower($row->sys_impacting), $matches, PREG_OFFSET_CAPTURE);
				//print_r($matches);
				if( count($matches) > 0 ){
					$set['log_issue_id'] = $row->id;
					$set['sys_imp_id'] 	= $row1->id;
					$set['sys_imp'] 	= $row1->desc;
					$set['start_date'] 	= $row->start_date;
					$set['end_date'] 	= $row->end_date;
					
					$this->db->insert('log_issues_sysimp_link', $set);
					
					echo $row->id.' '.$row->sys_impacting.' => '.$row1->desc.'<br/>';
				} 
				
				//echo $strr.'<br />';
				
			}
			
		}
		
	}
	
	
	public function tobeat(){
		$result = $this->db->get('log_escalation')->result();
		
		$from1 = $this->db->get('tbl_from')->result();
		$from = array(); 
		foreach($from1 as $row){
			$from[$row->id] = $row->desc;
		}
		
		$brands1 = $this->db->get('brands')->result();
		$brands = array(); 
		foreach($brands1 as $row){
			$brands[$row->id] = $row->desc;
		}
		
		
		$issues1 = $this->db->get('issues')->result();
		$issues = array(); 
		foreach($issues1 as $row){
			$issues[$row->id] = $row->desc;
		}
		
		
		$resolution1 = $this->db->get('root_cause')->result();
		$resolution = array(); 
		foreach($resolution1 as $row){
			$resolution[$row->id] = $row->desc;
		}
		
		foreach( $result as $row){ 
				 
			$set['es_from_id'] = @array_search($row->es_from, $from);
			$set['brands_id'] = @array_search($row->brands, $brands);
			$set['issues_cat_id'] = @array_search(trim($row->issues_cat), $issues);
			$set['resolution_id'] = @array_search(trim($row->resolution), $resolution);
			 
			echo $row->es_from.' => '.$set['es_from_id'].'<br />';
			echo $row->brands.' => '.$set['brands_id'].'<br />';
			echo $row->issues_cat.' => '.$set['issues_cat_id'].'<br />';
			echo $row->resolution.' => '.$set['resolution_id'].'<br /><br />';
			
			$this->db->where('id', $row->id);
			if( $this->db->update('log_escalation', $set) ){ echo "success";}
			else{echo "failed";}
			 
		}
		
	}
	
}

/* End of file client.php */
/* Location: ./application/controllers/client.php */