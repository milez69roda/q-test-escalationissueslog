 <style>
 
	td.cuYear, th.cuYear{
		background-color: #FFEFBF !important;
	}	
 </style>

	<hr /> 
	<h4 class="text-center">Issues Details</h4>	
	<div class="row">
		<a class="btn btn-success" href="client/export/?channel=oissues&date=<?php echo $_GET['date']; ?>&id=<?php echo $_GET['id']; ?>&col=<?php echo $_GET['col']; ?>"> Export to Excel </a>
	</div>		
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example"  >
		<thead> 	
			<tr>
				<th>Entered By</th>
				<th>System Impacting</th>
				<th>Start Date/Time</th>
				<th>End Date/Time</th>
				<th>Issue #</th>
				<th <?php echo (isset($_GET['col']) && $_GET['col']=='d')?"class='cuYear'":'';  ?>>Total Down Time</th> 
				<th>Centers</th>
				<th>Incident #</th>
				<th>Issue Description</th>
				<th>Root Cause</th>
				<th>CR #</th> 
				<th>CR Deployment Date</th>
				<th>Resolve by</th>
				<th>Potential Customer Impact</th>
				<th>CA Ticket #</th>
				<!--<th>Notification #</th>-->
				<th># of Dropped Calls</th> 
				<th <?php echo (isset($_GET['col']) && $_GET['col']=='a')?"class='cuYear'":'';  ?> ># Agents Impact</th> 
				<th>Agents Staffed: MIA</th>
				<th>Agents Staffed: ATL</th>
				<th>Created By</th>  
			</tr>
		</thead>
		<tbody>	
			<?php foreach( $results as $row ): ?>
			<tr>
				<th><?php echo $row->created_date; ?></th>
				<th><?php echo $row->sys_imp; ?></th>
				<td><?php echo $row->start_date; ?></td>
				<td><?php echo $row->end_date; ?></td>
				<td><?php echo str_pad($row->id, 5, "0", STR_PAD_LEFT); ?></td>
				<td <?php echo (isset($_GET['col']) && $_GET['col']=='d')?"class='cuYear'":'';  ?>><?php echo $row->total_downtime; ?></td>
				<td><?php echo $row->center; ?></td>
				<td><?php echo $row->incident_no; ?></td>
				<td><?php echo $row->issue_desc; ?></td>
				<td><?php echo $row->root_cause; ?></td>
				<td><?php echo $row->cr_no; ?></td>
				<td><?php echo $row->cr_deploy_date; ?></td>
				<td><?php echo $row->resolve_by; ?></td>
				<td><?php echo $row->po_cust_impact; ?></td>
				<td><?php echo $row->ca_ticket_no; ?></td>
				<!--<td><?php echo $row->notification_no; ?></td>-->
				<td><?php echo $row->drop_calls; ?></td>
				<td <?php echo (isset($_GET['col']) && $_GET['col']=='a')?"class='cuYear'":'';  ?>><?php echo $row->agent_impacted; ?></td>
				<td><?php echo $row->staff_mia; ?></td>
				<td><?php echo $row->staff_atl; ?></td>
				<td><?php echo $row->user_fullname; ?></td> 
			<?php endforeach; ?>
		</tbody>		
	</table>	