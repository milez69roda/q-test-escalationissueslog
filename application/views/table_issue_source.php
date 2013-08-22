

<script>
	
	$(document).ready(function(){
	 
		oTable = $('#example1').dataTable({"sDom": 't', "bPaginate": false});
	});
</script>
	
<style>
	#example1 tfoot tr td, #example1 tfoot tr th{
		border-top: 1px solid red;
	} 
	
	#example1 tfoot tr td a span{
		cursor: pointer !important;
	}
	
	.badge-info{
		cursor: pointer !important;
	}
</style> 
 
<?php 

	$trsuheader = ''; 
	$header1[] = 'System Impacting';
	$header2[] = '';
	$ytd_total_i = ''; 			
	$ytd_total_a = ''; 			
	$ytd_total_d = '';  			
				//print_r($issuesource['results']);
				
			 
	$table = '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example1"  style="color: #000">';
	
	$thead =  '<thead> <tr> <th rowspan="2" style="vertical-align: middle">System Impacting</th>';
	$thead .= '<th colspan="3" style="text-align:center; border-left: 1px solid red; border-right: 1px solid red;" >YTD Total</th>';
				$header1[]='YTD Total'; 
				$header1[] = ''; 
				$header1[] = '';
				
					
	foreach( $issuesource['header'] as $key=>$val): 
		$header1[] = $val; 
		$header1[] = ''; 
		$header1[] = '';
	
		$trsuheader .= '<th class="'.(($key==date('Ym'))?'cuYear':'').'" >I</th>
							<th class="'.(($key==date('Ym'))?'cuYear':'').'" >A</th>
							<th class="'.(($key==date('Ym'))?'cuYear':'').'" >D</th>'; 
		$header2[] = 'I';				
		$header2[] = 'A';				
		$header2[] = 'D';						
		$thead .= '<th colspan="3" style="text-align:center; border-left: 1px solid #000;" class="'.(($key==date('Ym'))?'cuYear':'').'">'.$val.'</th>'; 
		 
	endforeach;
	 
	$header2[]='I'; 
	$header2[]='A'; 
	$header2[]='D';					
	
	$thead .= '</tr> <tr> <th style="border-left: 1px solid red;">I</th> <th>A</th> <th style="border-right: 1px solid red;">D</th> '.$trsuheader.' </tr> </thead>';
			 
	$data[] = $header2;
	
	$tbody = '<tbody>';

	
	$total_d_h = 0;
	$total_d_m = 0;	
	foreach( $issuesource['results'] as $key1=>$value1 ): 	
	
		$tbody_td1 = '';			  
		$tbody_td2 = '';			  
		$tbody_td3 = '';
		
		$data1=array(); 
	
		$data1[] = $key1; 
		$tbody_td1 = '<th>'.$key1.'</th>';
		
		
		
		foreach( $issuesource['header'] as $key=>$val): 
	 
			$ival = @$value1['months']['i'][$key];
			$data1[] = $ival;
			$a = ''; 
			if( !empty($ival) ): 
		 
				$a = '<a href="javascript:void(0);" onclick="OVERVIEW.getDetails('.$value1['id'].','.$key.', \'i\')">';
				$a .= '<span class="badge badge-info" style="color: #000">'.$ival.'</span>';
				$a .= '</a>';
			endif;	
				
			$tbody_td2 .= '<td style="border-left: 1px solid #000;" class="'.(($key==date('Ym'))?'cuYear':'').'">'.$a.'</td>';
			$ytd_total_i += $ival;
	 
			$aval = @$value1['months']['a'][$key];
			$data1[] = $aval;
			$a = '';			
			if( !empty($aval) ):  
				$a = '<a href="javascript:void(0);" onclick="OVERVIEW.getDetails('.$value1['id'].','.$key.', \'a\')" >';
				$a .= '<span class="badge badge-info" style="color: #000">'.$aval.'</span>';
				$a .= '</a>';
			endif;	
			$tbody_td2 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'" >'.$a.'</td>';
			$ytd_total_a += $aval;
			
			
			$time 	= @$value1['months']['d'][$key] / 60 / 60;
			$hr  	= floor($time);		
			$min  	= ($time-$hr)*60;	 
			$hm 	= $hr.':'.$min;
			$hm 	= ($hm != '0:0')?$hm:'';
						  
			$data1[] = $hm;
			$a = '';
			if( !empty($time) ):  
				$a = '<a href="javascript:void(0);" onclick="OVERVIEW.getDetails('.$value1['id'].','.$key.', \'d\')" >';
				$a .= '<span class="badge badge-info" style="color: #000">'.$hm.'</span>';
				$a .= '</a>';
			endif;   
			$tbody_td2 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'" >'.$a.'</td>';
			  
			$ytd_total_d[] = $hm;
		endforeach;	
		
		
		
		$data1[]=@$value1['total']['i'];		
		$tbody_td3 .= '<td style="border-left: 1px solid red; font-weight: bold;">'.@$value1['total']['i'].'</td>';
		
		$data1[] = @$value1['total']['a'];
		$tbody_td3 .= '<td style="font-weight: bold;">'.@$value1['total']['a'].'</td>'; 
		  
		$time 	= @$value1['total']['d']/ 60 / 60;
		$hr  	= floor($time);		
		$min  	= ($time-$hr)*60;	
		$hm 	= $hr.':'.(int)$min;	
		$hm 	= ($hm != '0:0')?$hm:'';
		$data1[] = $hm; 			 
		$tbody_td3 .= '<td style="font-weight: bold; border-right: 1px solid red;">'.$hm.'</td>'; 
		
		
	
	$data[] = $data1;
	$tbody .= '<tr>'.$tbody_td1.$tbody_td3.$tbody_td2.'</tr>';
	
	endforeach;
	 
	$tbody .= '</tbody>';
	
	$tfoot = '<tfoot>'; 
	$tfoot_td2 = '';
	$tfoot_td3 = '';
	 
	$total = array();
	$total[] = 'Grand Total';
	 
	$total[] = $ytd_total_i;
	$total[] = $ytd_total_a;
	$total[] = @array_sum($ytd_total_d);
	
	foreach( $issuesource['header'] as $key=>$val): 
		$dum1 = @$issuesource['colTotal']['i'][$key];
		$total[] = $dum1;
		$tfoot_td2 .= '<td style="border-left: 1px solid #000;">'.$dum1.'</td>';

		$total[] = @$issuesource['colTotal']['a'][$key];
		$tfoot_td2 .= '<td>'.@$issuesource['colTotal']['a'][$key].'</td>';
		 
		$time 	= @$issuesource['colTotal']['d'][$key]/ 60 / 60;
		$hr  	= floor($time);		
		$min  	= ($time-$hr)*60;
		$hm 	= $hr.':'.$min;
		$hm 	= ($hm != '0:0')?$hm:'';
		$total[] = $hm; 
							 ; 
		$tfoot_td2 .= '<td>'.(($hm != '0:0')?$hm:'').'</td>'; 
	 
	endforeach;

	$tfoot_td3 .= '<td style="border-left: 1px solid red;">'.$ytd_total_i.'</td>';
	$tfoot_td3 .= '<td>'.$ytd_total_a.'</td>'; 			
	$tfoot_td3 .= '<td>'.@array_sum($ytd_total_d).'</td>';
	$data[] = $total;	
			
	$tfoot .= '<tr style="font-weight: bold;"><th>Grand Total</th>'.$tfoot_td3.$tfoot_td2.'</tr> </tfoot>';	
	
	echo $table.$thead.$tbody.$tfoot.'</table>';

	$a['header'] =  $header1; 
	$a['data'] =  $data;
	$this->session->set_userdata('ESCISSL_OVISSUE_DETAILS',$a);   
?>
		 