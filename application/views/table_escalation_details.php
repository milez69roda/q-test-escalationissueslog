<style>
 
	td.cuYear, th.cuYear{
		background-color: #FFEFBF !important;
	}	
	
	.label-success{
		cursor: pointer !important;
	}
	 	
</style>

	<hr />
	<div class="row">
		<h4 class="text-center">Escalation Issue Type Details</h4>
	</div>
	<div class="row">
		<a class="btn btn-success" href="client/export/?channel=escalation&id=<?php echo $_GET['id']; ?>&month=<?php echo $_GET['month']; ?>&from=<?php echo $_GET['from']; ?>">Export to Excel</a>
	</div>	
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example"  >
		<thead>
			<tr>
				<th>Date Created</th>
				<th>Date Recieve</th>
				<th>From</th>
				<th>Customer Name</th>
				<th>Email</th>
				<th>Serial #</th>
				<th>MIN</th>
				<th>Contact #</th>
				<th>Brand</th>
				<th>Issue Category</th>
				<th>Issue Category: Other</th>
				<th>Issue Details</th>
				<th>Sent only to FJ</th>
				<th>Block from emailing FJ</th>
				<th>Root Cause</th>
				<th>System</th>
				<th>Resolution</th>
				<th>CR #: (ORR/PSI)</th>
				<th>CR Deployment Date:(ORR/PSI)</th>
				<th>Potential Customer Impact (ORR/PSI)</th>
				<th>Status</th>
			 
			</tr>
		</thead>
		<tbody>	
			<?php foreach($results as $row): ?>
			<tr>
				<td><?php echo $row->created_date ?></td>
				<td><?php echo $row->date_received; ?></td>
				<td><?php echo $row->es_from; ?></td>
				<td><?php echo $row->cust_name; ?></td>
				<td><?php echo $row->email_address; ?></td>
				<td><?php echo $row->serial_no; ?></td>
				<td><?php echo $row->es_min; ?></td>
				<td><?php echo $row->es_contact; ?></td>
				<td><?php echo $row->brands; ?></td>
				<td><?php echo $row->issues_cat; ?></td>
				<td><?php echo $row->issues_cat_other; ?></td>
				<td><?php echo $row->issues_details; ?></td>
				<td><?php echo $row->sent_fj; ?></td>
				<td><?php echo $row->block_email_fj; ?></td>
				<td><?php echo $row->root_cause; ?></td>
				<td><?php echo $row->system_impacting; ?></td>
				<td><?php echo $row->resolution; ?></td>
				<td><?php echo $row->cr_no; ?></td>
				<td><?php echo $row->cr_deploy_date; ?></td>
				<td><?php echo $row->po_cust_impact; ?></td>
				<td><?php echo $row->es_status; ?></td>
			</tr>			
			<?php endforeach; ?>	
		</tbody>		
	</table>