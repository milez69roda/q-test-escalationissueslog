 <script>
	$(function(){
		oTable1 = $('#example1').dataTable({"sDom": 't', "bPaginate": false}); 
		$(".afromlink").popover({trigger:'hover',title: 'Tips', content: "After click results will be shown below (Escalation Details)!"});	
	});
 </script>
<?php 
	$escalation_from = array();
	$header_array[] = 'From';		
	 
	$table = '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example1"  >';
	
	$header_array[] = 'YTD Total';	 
	
	$thead1 = '';
	foreach( $escalationsource['header'] as $key=>$val): 
		$header_array[] = $val; 
		$thead1 .= '<th style="width: 80px" class="'.(($key==date('Ym'))?'cuYear':'').'">'.$val.'</th>';
	endforeach; 
	
	
	$thead = '<thead> <tr> <th>FROM</th> <th style="border-right: 1px solid red; color: red">YTD Total</th> '.$thead1.' </tr> </thead>' ; 
	
	
	
	
	
	$tbody = '<tbody>';	 
	
	
	
	$rows_array = array(); 
	
	
	
	foreach( $escalationsource['results'] as $key1=>$value1 ): 
		$rows_array1 = array();
		$rows_array1[] = $key1;
	 
		$body1 = '<th><a href="javascript:void(0)" class="afromlink" onclick="OVERVIEW.onFromClick('.$value1['id'] .',this)"><span class="badge badge-info">'.$key1.'</span></a></th>';
		$body2 = ''; 	 
		$body3 = ''; 	 
		$rows_array1[] = $value1['total'];
		$body3 = '<td style="border-right: 1px solid red; font-weight: bold; color:red">'.$value1['total'].'</td>';
		
		foreach( $escalationsource['header'] as $key=>$val): 
				$rows_array1[] = @$value1['months'][$key];
		 
				$body2 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'">'.@$value1['months'][$key].'</td>';
		endforeach; 	
		
		$rows_array[] = $rows_array1;
		
		

		$tbody .= '<tr>'.$body1.$body3.$body2.'</tr>';	
	endforeach; 
	
	$tbody .= '</tbody>';
  
	$tfoot2 = '';
	$tfoot3 = '';	
	 
	$total_array[] = 'Grand Total';	
	
	$total =  array_sum($escalationsource['colTotal']); 
	$total_array[] = $total; 
	foreach( $escalationsource['header'] as $key=>$val): 
		$total_array[] = @$escalationsource['colTotal'][$key];
		$tfoot2  .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'">'.@$escalationsource['colTotal'][$key].'</td>';
	endforeach;
	
	
	$rows_array[] = $total_array;					
	$tfoot3 = '<td style="border-right: 1px solid red; font-weight:bold; color:red">'.$total.'</td>';
		 
	$tfoot = '<tfoot><tr><th>Grand Total</th>'.$tfoot3.$tfoot2.'</tr></tfoot>';

	echo $table.$thead.$tbody.$tfoot.'</table>';	  
  
	$escalation_from['header'] = $header_array;
	$escalation_from['data'] = $rows_array; 
	
	$this->session->set_userdata('ESCISSL_OVESCALATION_FROM', $escalation_from); 	
	
	//print_r($this->session->userdata('ESCISSL_OVESCALATION_FROM'));
?> 