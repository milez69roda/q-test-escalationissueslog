<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Issues_Model extends CI_Model {
 
    function __construct() {
        
        parent::__construct();
    }
    
    function get(){ 
 
		$aColumns = array('log_issues.id, created_date', 'start_date', 'end_date', 'id', 'total_downtime', 'sys_impacting', 'center', 'incident_no', 'issue_desc', 'root_cause', 'cr_no', 'cr_deploy_date', 'resolve_by', 'po_cust_impact', 'ca_ticket_no', 'notification_no',  'user_fullname', 'drop_calls', 'agent_impacted', 'staff_mia', 'staff_atl', 'last_updateby_fullname' );
		

		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "log_issues.id";
		
		/* DB table to use */
		$sTable = "log_issues";
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
			parse_str($_GET['issues_vars'], $issues); 
			$countsearch 	= 0;
			
			$start_date 	= trim($issues['start_date']);
			$end_date 		= trim($issues['end_date']);
			$system 		= @$issues['sys_impacting'];
			$center 		= @$issues['center'];
			$incident_no 	= trim($issues['incident_no']);
			$ca_ticket_no 	= trim($issues['ca_ticket_no']);
			$user_fullname 	= strtolower(trim($issues['user_fullname']));
			
			if( $start_date != '' AND $end_date != '' ){
				$sWhere .= " AND (";	
				$sWhere .= " start_date BETWEEN '".$start_date."' AND '".$end_date."' OR";
				$sWhere .= " end_date BETWEEN '".$start_date."' AND '".$end_date."'";
				$sWhere .= ')';
				//$sWhere .= " AND DATE_FORMAT(created_date,'%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."' ";
				$countsearch++;
			}
			
			if( is_array($system) ){
				$sWhere .= " AND (";	
				foreach($system as $row){
					$sWhere .= " sys_impacting LIKE '%".mysql_real_escape_string( $row )."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';	 
				$countsearch++;	
			}
			
			if( is_array($center) ){
				$sWhere .= " AND (";	
				foreach($center as $row){
					$sWhere .= " center LIKE '%".mysql_real_escape_string( $row )."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';	 
				$countsearch++;	
			}	

			if( $incident_no != ''){
				$sWhere .= " AND incident_no LIKE '%".mysql_real_escape_string( $incident_no )."%' ";
				$countsearch++;
			}
			
			if( $ca_ticket_no != ''){
				$sWhere .= " AND ca_ticket_no LIKE '%".mysql_real_escape_string( $ca_ticket_no )."%' ";
				$countsearch++; 
			}
			
			if( $user_fullname != ''){
				$sWhere .= " AND LOWER(user_fullname) LIKE '%".mysql_real_escape_string( $user_fullname )."%' ";
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
			
				if( $aColumns[$i] == '' )
				
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
				start_date,
				end_date,
				issue_no,
				total_downtime,
				sys_impacting,
				sys_impacting_other,
				center,
				incident_no,
				issue_desc,
				root_cause,
				cr_no,
				cr_deploy_date,
				ip_address,
				resolve_by,
				po_cust_impact,
				ca_ticket_no,
				notification_no,
				drop_calls,
				agent_impacted,
				staff_mia,
				staff_atl,				
				user_fullname,
				last_updateby_fullname
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
		
		//while ( $aRow = mysql_fetch_array( $rResult ) ){
		
		$rResult = $rResult->result();
		
		//print_r($rResult);
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->id;  
			
			$rows[] = date('m-d-y_H:i A', strtotime($row->start_date)).'_'.str_pad($row->id, 5, "0", STR_PAD_LEFT).' '.$row->sys_impacting.' '.(($row->sys_impacting_other !='')?' :'.$row->sys_impacting_other:'').' '.$row->center;
			$rows[] = $row->created_date;
			$rows[] = $row->start_date;
			$rows[] = $row->end_date;
			$rows[] = str_pad($row->id, 5, "0", STR_PAD_LEFT);
			$rows[] = $row->total_downtime;
			$rows[] = $row->sys_impacting.' '.(($row->sys_impacting_other !='')?' :'.$row->sys_impacting_other:'');
			$rows[] = $row->center;
			$rows[] = $row->incident_no;
			$rows[] = $row->issue_desc;
			$rows[] = $row->root_cause;
			$rows[] = $row->cr_no;
			$rows[] = $row->cr_deploy_date; 
			$rows[] = $row->resolve_by;
			$rows[] = $row->po_cust_impact;
			$rows[] = $row->ca_ticket_no;
			$rows[] = $row->notification_no;
			$rows[] = $row->drop_calls;
			$rows[] = $row->agent_impacted;
			$rows[] = $row->staff_mia;
			$rows[] = $row->staff_atl;
			$rows[] = $row->user_fullname;  
			$rows[] = $row->last_updateby_fullname;  
			$rows[] = '<a href="issues/form/?edit='.$row->id.'">Edit</a>';    
						
			$output['aaData'][] = $rows;
		}
		
		echo json_encode( $output );	 
	
	}
	
	function issue_source($start, $end, $id = ''){
		
		$system 	= $this->db->get_where('system_impacting',array('disable'=>0))->result();
		
		$issues['header'] = array();
		$issues['results'] = array();
		$dumy = array();	
		$dmmyColTotal = array();
		
		
		foreach( $system as $row ){
			
			$dumy[$row->desc]['name'] = $row->desc;
			$dumy[$row->desc]['id'] = $row->id;
			
			$this->db->where('log_issues_sysimp_link.sys_imp_id', $row->id);	
			$this->db->select(" COUNT(sys_imp_id) as i, DATE_FORMAT(log_issues_sysimp_link.start_date,'%Y%m') AS ldate, SUM(total_downtime_in_sec) AS d, SUM(agent_impacted) AS a ", false);
			$this->db->join("log_issues", "log_issues.id = log_issues_sysimp_link.log_issue_id", " LEFT OUTER ");
			$this->db->group_by(array("DATE_FORMAT(log_issues_sysimp_link.start_date,'%Y-%m')"));
			$results = $this->db->get('log_issues_sysimp_link', null, false)->result();
			//echo '<pre>'.$this->db->last_query().'</pre>';
			/* echo '<pre>';
			print_r($results);
			echo '</pre>'; */
			foreach($results as $row1){
				@$dumy[$row->desc]['months']['i'][$row1->ldate] = $row1->i;  
				@$dumy[$row->desc]['months']['a'][$row1->ldate] = $row1->a;  
				@$dumy[$row->desc]['months']['d'][$row1->ldate] = $row1->d;  
				
				@$dmmyColTotal['i'][$row1->ldate] += $row1->i;				
				@$dmmyColTotal['a'][$row1->ldate] += $row1->a;				
				@$dmmyColTotal['d'][$row1->ldate] += $row1->d; 
				
			}
			
			$dumy[$row->desc]['total']['i'] = @array_sum($dumy[$row->desc]['months']['i']);  
			$dumy[$row->desc]['total']['a'] = @array_sum($dumy[$row->desc]['months']['a']);  
			$z = explode( '.',@array_sum($dumy[$row->desc]['months']['d']) );
			$dumy[$row->desc]['total']['d'] = @$z[0];    
		}
		
		$issues['header'] 	= $this->dateRange($start, $end, '+1 month', 'M Y' );
		$issues['results'] = $dumy;
		$issues['colTotal'] = $dmmyColTotal;
		
		return $issues;		
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