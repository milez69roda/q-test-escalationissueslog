<!--
<link rel="stylesheet" type="text/css" media="all" href="js/daterange/daterangepicker.css" /> 
<script type="text/javascript" src="js/daterange/moment.js"></script>
<script type="text/javascript" src="js/daterange/daterangepicker.js"></script>
-->
 
<link href="css/datepicker.css" rel="stylesheet" media="screen">
<script src="js/bootstrap-datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

<style>

</style>
<script>

var  oTable;
$(document).ready(function(){
 
	
	 oTable = $('#example').dataTable( {
		//"sDom": "<'row'<'span2'l><'span6 toolbar'><'span4'f>r>t<'row'<'span6'i><'span6'p>>",
		//"sDom": "<'row'<'span2'l><'span6 toolbar'><'span4'>r>t<'row'<'span6'i><'span6'p>>",
		"sDom": "<'row'<'span2'l><'span6 toolbar'><'span4'>r>  <'row'<'span6'i><'span6'p> t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap", 
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "client/ajax_issues_summary",				
		"oLanguage": {
			"sLengthMenu": "_MENU_ per page"
		},
		"aaSorting": [[ 0, 'desc' ]], 
		"fnServerParams": function( aoData ){
			aoData.push( { "name": "issues_vars", "value": $("#search_form").serialize() } ); 
		}
	});	
	
	$("#example_processing").addClass('label label-success');
	
 
				
	$('#start_date').datepicker({ 'autoclose': true });
	$('#end_date').datepicker({ 'autoclose': true });
	
 
	
	$("#btn_export").click(function(){ 
		var vars = $("#search_form").serialize(); 
		window.location = '<?php echo base_url(); ?>client/export/?'+vars+'&channel=issues'; 
	});	
 
	$(".system_impacting").click(function(){
		if( $(this).is(":checked") ){
			$(this).parent('label').addClass('badge-info');
		}else{
			//$(this).parent('label').removeClass('badge');
			$(this).parent('label').removeClass('badge-info');
		} 
	});	 
	
	$("#center_all").click(function(){ 
	
		if( $(this).is(":checked") ){
			$(".center_list").each(function(){
				$(this).prop('checked',true);
			});	
		}else{
			$(".center_list").each(function(){
				$(this).prop('checked', false);
			});		
		}
	}); 
	
	$("#system_impacting_all").click(function(){ 
	
		if( $(this).is(":checked") ){
			$(".system_impacting").each(function(){
				$(this).prop('checked',true);
				$(this).parent('label').addClass('badge-info');
			});	
		}else{
			$(".system_impacting").each(function(){
				$(this).prop('checked', false);
				$(this).parent('label').removeClass('badge-info');
			});		
		}
	});	
	
	
});
	function onSearch(f){ 
		oTable.fnFilter();	 
		return false; 
	}	  
</script>
<div class="row-fluid">
	<h3>Issues Log</h3>
	<?php echo $nav; ?>
   
	<div class="accordion" id="accordion2" style="background-color: #eee">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="font-size: 16px; font-weight: bold; text-decoration: none" title="Click to collapse">Search <em style="font-size: 11px; padding-left: 10px">click here to show/hide search</em></a>
			</div>
			<div id="collapseOne" class="accordion-body collapse in">
				<div class="accordion-inner" style="background-color: #fff;">
				 
					<form class="form-inline" id="search_form" onsubmit="return onSearch(this);" method="post" action="">
						<div class="row-fluid">
						<label style="width: 145px; text-align: right; font-weight: bold; padding-right:3px;" >Date: </label> <input type="text" class="input-small"   name="start_date" id="start_date" data-date-format="yyyy-mm-dd" >
						<label> - <input type="text" class="input-small"  name="end_date" id="end_date" data-date-format="yyyy-mm-dd" ></label>
						</div>	
						
						<div class="row-fluid">
						<label style="width: 145px; text-align: right; font-weight: bold; padding-right:3px; float:left">System(s) Impacting: </label> 
						<!--<?php foreach($system_impacting as $key=>$value):  ?>
						<label class="checkbox" style="padding-right: 4px"><input class="system_impacting" type="checkbox" name="system[]" id="system" value="<?php echo $value; ?>"/> <?php echo $value; ?> </label>
						<?php endforeach; ?> -->
						
						<div style="height: 150px; overflow: scroll; overflow-x: hidden; border: 1px solid #ccc"> 
							<div style="font-size: 14px;">
								<ul class="unstyled">
								<li class="" style="padding: 2px 4px; float: left; width: 220px" > <label class="checkbox" style=""><input type="checkbox" class="system_impacting" id="system_impacting_all" value="<?php echo $value; ?>"/> All </label> </li>	
								<?php  
									foreach($system_impacting as $key=>$value): //$i++; 
								?>
								<li class="" style="padding: 2px 4px; float: left; width: 220px" > <label class="checkbox" style=""><input type="checkbox" name="sys_impacting[]" class="system_impacting" value="<?php echo $value; ?>"/> <?php echo $value; ?> </label> </li>
								<?php endforeach; ?> 
								<ul>
							</div>
						</div>							
						</div>	
						
						<div class="row-fluid">
						<label style="width: 145px; text-align: right; font-weight: bold; padding-right:3px;">Center: </label> 
						<label class="checkbox" style="padding-right: 4px"><input type="checkbox"  id="center_all" value="<?php echo $value; ?>"/> All </label>
						<?php foreach($centers as $key=>$value):  ?>
						<label class="checkbox" style="padding-right: 4px"><input type="checkbox" name="center[]" class="center_list" id="center" value="<?php echo $value; ?>"/> <?php echo $value; ?> </label>
						<?php endforeach; ?> 	
						</div>	
						 
						<div class="row-fluid">
						<label style="width: 145px; text-align: right; font-weight: bold; padding-right:3px;">Incident #: </label> <input type="text" class="input-medium" name="incident_no" id="incident_no" value=""/>
						
						<label style="width: 200px; text-align: right; font-weight: bold; padding-right:3px;">Entered By: </label> <input type="text" name="user_fullname" value="" />						
						</div> 		
						
						<div class="row-fluid">
						<label style="width: 145px; text-align: right; font-weight: bold; padding-right:3px;">CA #: </label> 	
						<input type="text" class="input-medium" name="ca_ticket_no" id="ca_ticket_no" value=""/> 		
						</div>
						
						<label style="width: 145px; text-align: right; font-weight: bold; padding-right:3px;">&nbsp;</label> 	
						<button type="submit" class="btn btn-primary">Search</button>
						<button type="button" class="btn btn-danger" id="btn_export">Export to Excel</button>
					</form>				 
				 
				</div>
			</div>
		</div> 
	</div>
 	
	
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example"  >
		<thead> 	
			<tr>
				<th></th>
				<th>Entered Date</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Issue #</th> 
				<th>Total Down Time (hr/mins)</th>
				<th>System(s) Impacting</th>				
				<th>Centers</th>
				<th>Incident #</th>
				<th>Issue Description</th>
				<th>Root Cause</th>
				<th>CR # (ORR/PSI) </th> 
				<th>CR Deployment Date (ORR/PSI) </th>
				<th>Resolved by</th>
				<th>Potential Customer Impact</th>
				<th>CA Ticket #</th>
				<th>Notification #</th>
				<th># of Dropped Calls</th> 
				<th># Agents Impact</th> 
				<th>Agents Staffed: MIA</th>
				<th>Agents Staffed: ATL</th>
				<th>Entered By</th>
				<th>Last Updated By</th>
				<th>Edit</th>
				 
			</tr>
		</thead>
		<tbody>	
			
		</tbody>		
	</table>	
</div>	