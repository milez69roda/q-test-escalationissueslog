 <script>
	$(function(){
		oTable2 = $('#example2').dataTable({"sDom": 't', "bPaginate": false}); 
		$(".afromlink2").popover({trigger:'hover',title: 'Tips', content: "After click results will be shown at the top (Escalation Overview)!"});	
	});
 </script>

<?php
	
	$header[] = 'Issue Type';
	$data = '';
?>
<h5><?php echo @($escalationissuetype['name']!='')?$escalationissuetype['name']:''; ?></h5>
 
<?php 		
		$table = '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2" >'; 
		
		$thead = '<thead> <tr> <th>Issue Type</th>';
		$thead1 = '';
		$header[] = 'Total';
		$header[] = '%'; 
		$thead2 = '<th style="border-left: 1px solid red; color: red !important">Total</th> <th style="color: red !important">%</th>';
		
		
		foreach( $escalationissuetype['header'] as $key=>$val): 
			$header[] = $val;
			$thead1 .= '<th class="'.(($key==date('Ym'))?'cuYear':'').'" style="border-left: 1px solid #000;">'.$val.'</th>';
			$header[] = '%';
			$thead1 .= '<th class="'.(($key==date('Ym'))?'cuYear':'').'">%</th>';
		endforeach;
		
		
						 		
		$thead .= $thead2.$thead1.'</tr></thead>';
				
		$tbody = '<tbody>';		
		
		foreach( $escalationissuetype['results'] as $key1=>$value1 ): $data1 = array(); 
			$tbody1 = '';
			$tbody2	= '';				
			$tbody3	= '';				
		
			$tbody1 = '<tr><th><a href="javascript:void(0)" class="afromlink2" onclick="OVERVIEW.onTypeClick('.$value1['id'].', '.(($escalationissuetype['from_id'] !='')?$escalationissuetype['from_id']:0).')"><span class="badge badge-info">'.$key1; $data1[] = $key1.'</span></a> </th>'; 
			 
			 
			$data1[] = $value1['total'];					
			$tbody3 .= '<td style="border-left: 1px solid red; font-weight: bold; color:red !important">'.$value1['total'].'</td>';
			
			$dum2 = @number_format(($value1['total']/array_sum($escalationissuetype['colTotal']))*100, 0).'%'; 			
			$data1[] = $dum2;
			$tbody3 .= '<td style="font-weight: bold; color:red">'.$dum2.'</td>'; 
			
			foreach( $escalationissuetype['header'] as $key=>$val): 
		  
				$data1[] =  @$value1['months'][$key];
				$a1 = '';
				if( !empty($value1['months'][$key]) ):  
					$a1 = '<a href="javascript:void(0)" onclick="OVERVIEW.onTypeViewDetails('.$value1['id'].','.$key.','.(($escalationissuetype['from_id'] !='')?$escalationissuetype['from_id']:0).')">';
					$a1 .= '<span class="badge badge-info">'.@$value1['months'][$key].'</span>';
					$a1 .= '</a>';
				endif;   
				$tbody2 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'" style="border-left: 1px solid #000;">'.$a1.'</td>';
				
				$dum1 = @number_format(($value1['months'][$key]/$escalationissuetype['colTotal'][$key])*100, 0).'%'; 
				$data1[] = $dum1;
				$tbody2 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'">'.$dum1.'</td>'; 
				
			endforeach; 
		
			$tbody .= $tbody1.$tbody3.$tbody2.'</tr>';
		
			$data[] = $data1;  
		endforeach; 
		
		$tbody .= '</tbody>';
		
		$tfoot = '<tfoot> <tr style="border-top: 1px solid red !important;"> <th>Grand Total</th>';			
		$total[] = 'Grand Total';
		
		$tfoot1 = ''; 
		$tfoot2 = ''; 
		
		$dum4 = array_sum($escalationissuetype['colTotal']);
		$total[]=$dum4;
		$tfoot2 .= '<td style="border-left: 1px solid red; color:red; font-weight: bold">'.$dum4.'</td>'; 
		$total[]='100%'; 
		
		$tfoot2 .= '<td style="color:red; font-weight:bold">100%</td>';		
		
		foreach( $escalationissuetype['header'] as $key=>$val): 
			$total[] = (@$escalationissuetype['colTotal'][$key]);
			$tfoot1 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'" style="border-left: 1px solid #000;">'.@$escalationissuetype['colTotal'][$key].'</td>';
			
			$dum3 = @number_format( ($escalationissuetype['colTotal'][$key]/array_sum($escalationissuetype['colTotal']))*100, 0).'%';
			$total[]=$dum3;
			$tfoot1 .= '<td class="'.(($key==date('Ym'))?'cuYear':'').'">'.$dum3.'</td>'; 
		endforeach;
		$data[] = $total;
				 
		$tfoot .= $tfoot2.$tfoot1.'</tr> </tfoot>';		
		
		echo $table.$thead.$tbody.$tfoot.'</table>';
		
		 
		$escalation_details['header'] = $header; 
		$escalation_details['data'] = $data; 
		$this->session->set_userdata('ESCISSL_OVESCALATION_DETAILS',$escalation_details); 
			//print_r($escalation_details);
?>	 