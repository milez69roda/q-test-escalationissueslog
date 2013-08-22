<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">

<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

<link href="css/datepicker.css" rel="stylesheet" media="screen">
<script src="js/bootstrap-datepicker.js"></script>

<style>

</style>
<script>

var  oTable;
$(document).ready(function(){
 

	oTable = $('#example').dataTable( {
		//"sDom": "<'row'<'span2'l><'sspan6 toolbar'><'span4'f>r>t<'row'<'span6'i><'span6'p>>",
		"sDom": "<'row'<'span2'l><'span6 toolbar'><'span4'>r>  <'row'<'span6'i><'span6'p> t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap", 
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "client/ajax_escalation_summary",				
		"oLanguage": {
			"sLengthMenu": "_MENU_ per page"
		},
		"aaSorting": [[ 0, 'asc' ]], 
		"fnServerParams": function( aoData ){
			aoData.push( { "name": "escalation_vars", "value": $("#search_form").serialize() } ); 
		}
	});	
	
	$("#example_processing").addClass('label label-success');
	$('#start_date').datepicker({ 'autoclose': true });
	$('#end_date').datepicker({ 'autoclose': true });	
	
	$("#btn_export").click(function(){ 
		var vars = $("#search_form").serialize(); 
		window.location = '<?php echo base_url(); ?>client/export/?'+vars+'&channel=escalation'; 
	});
});
	  
function onSearch(f){
	
	//oTable.fnDraw();
	oTable.fnFilter();	
	return false;

}	
	
</script>
<div class="row-fluid">
	<h3>Escalation Log</h3>
	<?php echo $nav; ?>
  
	<div class="accordion" id="accordion2" style="background-color: #eee">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="font-size: 16px; font-weight: bold; text-decoration: none" title="Click to collapse">Search <em style="font-size: 11px; padding-left: 10px">click here to show/hide search</em></a>
			</div>
			<div id="collapseOne" class="accordion-body collapse in">
				<div class="accordion-inner" style="background-color: #fff;">
				 
					<form class="form-inline" id="search_form" onsubmit="return onSearch(this);" method="post" action="">
						<div class="pull-left">
							<div class="row-fluid">
							<label style="width: 130px; text-align: right; font-weight: bold; padding-right:3px;" >Date: </label> <input type="text" class="input-small"   name="start_date" id="start_date" data-date-format="yyyy-mm-dd" >
							<label> - <input type="text" class="input-small"  name="end_date" id="end_date" data-date-format="yyyy-mm-dd" ></label>
							</div>	
							
							<div class="row-fluid">
							<label style="width: 130px; text-align: right; font-weight: bold; padding-right:3px;">From: </label> 
							<?php echo form_dropdown('es_from', $from, '', '');  ?>
							</div>	
							
							<div class="row-fluid">
							<label style="width: 130px; text-align: right; font-weight: bold; padding-right:3px;">Brand: </label> 
							<?php echo form_dropdown('brands', $brands, '', '');  ?> 	
							</div>	
							
							<div class="row-fluid">
							<label style="width: 130px; text-align: right; font-weight: bold; padding-right:3px;">Issue Category: </label> 	
							<?php echo form_dropdown('issues', $issues, '', '');  ?> 	
							</div>							
						</div> 
						<div class="pull-left">
							 		 
							<div class="row-fluid">
							<label style="width: 200px; text-align: right; font-weight: bold; padding-right:3px;">CR # (ORR/PSI): </label> 	
							<input type="text" class="input-medium" name="cr_no" id="cr_no" value=""/> 		
							</div>
							
							<div class="row-fluid">
							<label style="width: 200px; text-align: right; font-weight: bold; padding-right:3px;">Sent only to FJ: </label> 	
							<select name="sent_fj">
								<option value="">--Select--</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>	
							</div>
							
							<div class="row-fluid">
							<label style="width: 200px; text-align: right; font-weight: bold; padding-right:3px;">Block from emailing FJ: </label> 	
							<select name="block_email_fj">
								<option value="">--select--</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>	
							</div>
							
							<div class="row-fluid">
							<label style="width: 200px; text-align: right; font-weight: bold; padding-right:3px;">Entered By: </label> 	
							<input type="text" name="user_fullname" value="" />
							</div>
							
							<div class="row-fluid">
							<label style="width: 200px; text-align: right; font-weight: bold; padding-right:3px;">Customer Name: </label> 	
							<input type="text" name="cust_name" value="" />
							</div>
						
						</div>
						<div class="row-fluid" style="clear:both">
						<label style="width: 130px; text-align: right; font-weight: bold; padding-right:3px;">&nbsp;</label> 	
						<button type="submit" class="btn btn-primary">Search</button>
						<button type="button" class="btn btn-danger" id="btn_export">Export to Excel</button>
						</div>
					</form>				 
				 
				</div>
			</div>
		</div> 
	</div>	
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
		<thead>
			<tr>
				<th>Entered Date</th>
				<th>Date Recieved</th>
				<th>From</th>
				<th>Customer Name</th>
				<th>Email</th>
				<th>Serial #</th>
				<th>MIN</th>
				<th>Contact #</th>
				<th>Brand</th>
				<th>Issue Category</th>
				<th>Issue Other</th>
				<th>Issue Details</th>
				<th>Root Cause</th>
				<th>System</th>
				<th>Resolution</th>
				<th>CA Ticket #</th>
				<th>Sent only to FJ</th>
				<th>Block from emailing FJ</th>				
				<th>CR # (ORR/PSI)</th>
				<th>CR Deployment Date (ORR/PSI)</th>
				<th>Potential Customer Impact (ORR/PSI) </th>
				<th>Status</th>
				<th>Entered By</th>
				<th>Last Updated By</th>
				<th>Edit</th>
				 
			</tr>
		</thead>
		<tbody>	
			
		</tbody>		
	</table>	
</div>	