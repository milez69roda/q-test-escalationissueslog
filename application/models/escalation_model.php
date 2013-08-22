<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class escalation_model extends CI_Model {
 
    function __construct() {
        
        parent::__construct();
    }
    
    function get(){ 
 
		$aColumns = array('created_date', 'date_received', 'es_from', 'cust_name', 'email_address', 'serial_no', 'es_min', 'es_contact','brands', 'issues_cat', 'issues_cat_other', 'issues_details', 'ca_ticket_no', 'sent_fj', 'block_email_fj', 'root_cause', 'system_impacting', 'resolution', 'cr_no', 'cr_deploy_date', 'po_cust_impact', 'es_status', 'user_fullname', 'last_updateby_fullname' );
		

		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "log_escalation.id";
		
		/* DB table to use */
		$sTable = "log_escalation";
		$sJoin = " ";
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
		}
		 
		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
			
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					
					
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
						
					//$this->db->order_by($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], $_GET['sSortDir_'.$i] );	
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "WHERE 1 ";
		 
		//$sWhere .= " DATE_FORMAT(date_received,'%Y-%m-%d') BETWEEN '".$_GET['date_from']."' AND '".$_GET['date_to']."'";
		 
		 if( $this->session->userdata('ESCISSL_ROLEID') > 3 )			
			$sWhere .= " AND (user_id = '".$this->session->userdata('ESCISSL_USERID')."')";  
		 
		
		if ( $_GET['sSearch'] != "" ){
			parse_str($_GET['escalation_vars'], $escalation_vars);
			
			$countsearch 	= 0;
			
			$start_date 	= trim($escalation_vars['start_date']);
			$end_date 		= trim($escalation_vars['end_date']);
			$es_from 		= $escalation_vars['es_from'];
			$brands 		= $escalation_vars['brands'];
			$issues 		= $escalation_vars['issues'];
			$cr_no 			= trim($escalation_vars['cr_no']);
			$sent_fj 		= trim($escalation_vars['sent_fj']);
			$block_email_fj = trim($escalation_vars['block_email_fj']);
			$user_name		= strtolower(trim($escalation_vars['user_fullname']));
			$cust_name		= strtolower(trim($escalation_vars['cust_name']));
			 

			if( $start_date != '' AND $end_date != ''){ 
				$sWhere .= " AND date_received BETWEEN '".$start_date."' AND '".$end_date."' ";
				$countsearch++;
			}
			
			if( $es_from != ''){
				$es_from = explode(':',$es_from);
				$sWhere .= " AND es_from_id = ".$es_from[0]." ";
				$countsearch++;
			}
			
			if( $brands != ''){
				$brands = explode(':',$brands);
				$sWhere .= " AND brands_id = ".$brands[0]." ";
				$countsearch++;
			}
			
			if( $issues != ''){ 
				$issues = explode(':',$issues);
				$sWhere .= " AND issues_cat_id = ".$issues[0];
				$countsearch++;
			}
			
			if( $cr_no != ''){ 
				$sWhere .= " AND cr_no = '%".mysql_real_escape_string( $cr_no )."%' ";
				$countsearch++;
			}
			
			if( $sent_fj != ''){ 
				$sWhere .= " AND sent_fj = '".$sent_fj."' ";
				$countsearch++;
			}
			
			if( $block_email_fj != ''){ 
				$sWhere .= " AND block_email_fj = '".$block_email_fj."' ";
				$countsearch++;
			}
			
			if( $user_name != ''){ 
				$sWhere .= " AND LOWER(user_fullname)  like '%".mysql_real_escape_string($user_name)."%' ";
				$countsearch++;
			}
			
			if( $cust_name != ''){ 
				$sWhere .= " AND LOWER(cust_name)  like '%".mysql_real_escape_string($cust_name)."%' ";
				$countsearch++;
			}
			
			if( $countsearch == 0 ){
				$sWhere .= " AND DATE_FORMAT(created_date,'%Y-%m-%d') = CURRENT_DATE ";	
			}
		}else{
			$sWhere .= " AND DATE_FORMAT(created_date,'%Y-%m-%d') = CURRENT_DATE ";
		}		
		
		/* if ( $_GET['sSearch'] != "" ){
			 
			$sWhere .= " AND (";	
			
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				
				//if( $i == 0 )
					//$this->db->like($_GET['sSearch'], 'match');
				//else
					//$this->db->or_like($_GET['sSearch'], 'match');
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		} */
		
		/* Individual column filtering */
		/* for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else { 
					$sWhere .= " AND";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		} */
		
		 
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS  
					id, created_date,
					date_received,
					es_from,
					cust_name,
					email_address,
					serial_no,
					es_min,
					es_contact,
					brands,
					issues_cat,
					issues_details,
					sent_fj,
					block_email_fj,
					root_cause,
					repeat_cust,
					resolution,
					cr_no,
					cr_deploy_date,
					po_cust_impact,
					es_status,					
					user_fullname,
					user_name,
					ca_ticket_no,
					issues_cat_other,
					last_updateby_fullname,
					system_impacting
			FROM   $sTable
			$sJoin
			$sWhere
			$sOrder
			$sLimit
		";
		 
		$rResult = $this->db->query($sQuery); 
		
		//echo $this->db->last_query();
		
		$iFilteredTotal = $rResult->num_rows();
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as numrow
			FROM   $sTable
			$sJoin
			$sWhere
		";
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultTotal = mysql_fetch_array($rResultTotal);
		$aResultTotal = $this->db->query($sQuery)->row();
		$iTotal = $aResultTotal->numrow;
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			//"iTotalDisplayRecords" => $iFilteredTotal,
			"iTotalDisplayRecords" => $iTotal,
			"aaData" => array()
		);
		 
		$rResult = $rResult->result();
		
		 
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->id; 
			 
			$rows[] = $row->created_date;    
			$rows[] = $row->date_received;    
			$rows[] = $row->es_from;    
			$rows[] = $row->cust_name;    
			$rows[] = $row->email_address;    
			$rows[] = $row->serial_no;    
			$rows[] = $row->es_min;    
			$rows[] = $row->es_contact;    
			$rows[] = $row->brands;    
			$rows[] = $row->issues_cat;    
			$rows[] = $row->issues_cat_other;    
			$rows[] = $row->issues_details;     
			$rows[] = $row->root_cause;        
			$rows[] = $row->system_impacting;    
			$rows[] = $row->resolution;    
			$rows[] = $row->ca_ticket_no;       
			$rows[] = $row->sent_fj;       
			$rows[] = $row->block_email_fj;     
			$rows[] = $row->cr_no;    
			$rows[] = $row->cr_deploy_date;    
			$rows[] = $row->po_cust_impact;    
			$rows[] = $row->es_status;    
			$rows[] = $row->user_fullname;    
			$rows[] = $row->last_updateby_fullname;    
			$rows[] = '<a href="escalation/form?edit='.$row->id.'">Edit</a>';    
			
			$output['aaData'][] = $rows;
		}
		 
		echo json_encode( $output );	
	 	 
	}
	
	function escalation_source($start, $end, $issues_cat_id = ''){
			
		/* $start	= $_GET['start'];	
		$end 	= $_GET['end'];	 */
		$escalations['header'] = array();		 
		$escalations['results'] = array();
		$dumy = array();
		$dmmyColTotal = array();
		
		if( isset($_GET['from_id']) AND $_GET['from_id'] != 0 ){
			$this->db->where('id', $_GET['from_id']);
		}		
		$this->db->order_by('ordering', 'asc');
		$from 	= $this->db->get_where('tbl_from',array('disable'=>0))->result();
 
		foreach($from as $row){
			
			$dumy[$row->desc]['id'] = $row->id;
			$dumy[$row->desc]['name'] = $row->desc;
			
			$this->db->select(" es_from, DATE_FORMAT(date_received,'%Y%m') AS ldate, COUNT(*) AS lcount ", false);
			if( $issues_cat_id != '' ){
				$this->db->where('issues_cat_id', $issues_cat_id);
			}		 		
			$this->db->where('es_from_id', $row->id);	
			$this->db->where(" DATE_FORMAT(date_received,'%Y-%m-%d') BETWEEN ", "'".$start."' AND '".$end."'", false);	
			$this->db->group_by(array("DATE_FORMAT(date_received,'%Y-%m')"));
			//$this->db->order_by("DATE_FORMAT(created_date,'%Y-%m') desc");
			//$this->db->order_by("DATE_FORMAT(created_date,'%Y-%m')", 'desc');
			$results = $this->db->get('log_escalation', null, false)->result();
			 
			foreach($results as $row1){
				$dumy[$row->desc]['months'][$row1->ldate] = $row1->lcount;  
				@$dmmyColTotal[$row1->ldate] += $row1->lcount;
			}
			
 
			$dumy[$row->desc]['total'] = @array_sum($dumy[$row->desc]['months']); 
		}
		
		
		$escalations['header'] 	= $this->dateRange($start, $end, '+1 month', 'M Y' );
		$escalations['results'] = $dumy;
		$escalations['colTotal'] = $dmmyColTotal;
		
		return $escalations;
	} 
	
	function escalation_issuetype($start, $end, $from_id = ''){
		
		$escalations['header'] = array();		 
		$escalations['results'] = array();
		$escalations['name'] = isset($_GET['ftxt'])?'Escalation Source: '.$_GET['ftxt']:'';
		$escalations['from_id'] = $from_id;
		$dumy = array();
		$dmmyColTotal = array();
		 
		$mres 	= $this->db->get_where('issues',array('disable'=>0))->result();
		
		foreach($mres as $row){
		
			$dumy[$row->desc]['id'] = $row->id;
			
			$this->db->select(" issues_cat_id, issues_cat, DATE_FORMAT(date_received,'%Y%m') AS ldate, COUNT(*) AS lcount, es_from ", false);
			if( $from_id != '' ){
				$this->db->where('es_from_id', $from_id); 
			}
			$this->db->where('issues_cat_id', $row->id);
			$this->db->where(" DATE_FORMAT(date_received,'%Y-%m-%d') BETWEEN ", "'".$start."' AND '".$end."'", false);	
			$this->db->group_by( array("DATE_FORMAT(date_received,'%Y-%m')") );
			$results = $this->db->get('log_escalation', null, false)->result();		

			foreach($results as $row1){
				
				$dumy[$row->desc]['months'][$row1->ldate] = $row1->lcount;  
				@$dmmyColTotal[$row1->ldate] += $row1->lcount;
				 
			}

			$dumy[$row->desc]['total'] = @array_sum($dumy[$row->desc]['months']); 
		}
		
		$escalations['header'] 	= $this->dateRange($start, $end, '+1 month', 'M Y' );
		$escalations['results'] = $dumy;
		$escalations['colTotal'] = $dmmyColTotal;
		
		return $escalations;		
	}
	
	public function escalation_details(){
	
		$this->db->where('issues_cat_id', $_GET['id'] );
		$this->db->where(" DATE_FORMAT(date_received, '%Y%m')=", $_GET['month'], false);
		if( isset($_GET['from']) AND $_GET['from'] != 0 ){
			$this->db->where('es_from_id', $_GET['from'] );
		}
		
		$result = $this->db->get('log_escalation')->result();
		
		return $result;
	}
	
	
	function dateRange( $first, $last, $step = '+1 month', $format = 'Y-m-d' ) {

		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );

		while( $current <= $last ) {

			$dates[date( 'Ym', $current )] = date( $format, $current );
			$current = strtotime( $step, $current );
		}

		return $dates;
	}	
}