<link href="css/datepicker.css" rel="stylesheet" media="screen">
<script src="js/bootstrap-datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
<link href="css/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
 
<script src="js/bootstrap-timepicker.min.js"></script>
 
<style>
	.ltitle{
		font-weight: bold;
	}
</style>
<script>
	
$(document).ready(function(){
	
	$('.cdate').datepicker({ 'autoclose': true }).on('changeDate', function(ev) {
		var start = $("#start_date").val()+' '+$('#timepicker1').val();
		var end = $("#end_date").val()+' '+$('#timepicker2').val();
		diff(start, end);				 
	});
	  
	$('#timepicker1').timepicker({minuteStep:1}).on('changeTime.timepicker', function(e) {
		//console.log(e.time.value);
		
		var start = $("#start_date").val()+' '+e.time.value;
		var end = $("#end_date").val()+' '+$('#timepicker2').val();
		diff(start, end);
	});	
	$('#timepicker2').timepicker({minuteStep:1}).on('changeTime.timepicker', function(e) {
		var start = $("#start_date").val()+' '+$('#timepicker1').val();
		var end = $("#end_date").val()+' '+e.time.value;
		diff(start, end);		
	});	
	
	ISSUES = {
		
		save: function(f){
		
			if( confirm('Are you sure you want to submit?') ){	
				$.ajax({
					type: 'post',
					url: "client/issues_save/",
					data: $(f).serialize(),
					dataType: 'json',
					success: function(json){
						if(json.status){
						
							COMMON.alert('Submitted', json.msg, 'alert-success', '<?php echo base_url(); ?>issues/summary');									 
							//COMMON.clearForm(form);
						}else{							
							COMMON.alert('Warning', json.msg, 'alert-error', '');
						}
					},
					error: function(){
						COMMON.alert('Warning', 'ERRor', 'alert-error', '');
					}
				});
			}; 			
		 
			return false;
		} 
	}

	function diff(start, end){
		 
		 $.ajax({
				type: 'post',
				url: "client/datediff/",
				data: 'start='+start+'&end='+end, 
				success: function(json){
					$("#total_downtime").val(json);
				}
		 })
		
	}

	$(".system_impacting").click(function(){
		if( $(this).is(":checked") ){
			$(this).parent('label').addClass('badge-info');
			
			if( $(this).val() == 'OTHER' ){
				$("#sys_other_cont").show();
			}
			
		}else{
			//$(this).parent('label').removeClass('badge');
			$(this).parent('label').removeClass('badge-info');
			
			if( $(this).val() == 'OTHER' ){
				$("#sys_other_cont").hide();
			}			
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
});
	  
</script>
<div class="row-fluid">
	<h3>Issues Log</h3>
	<?php echo $nav; ?>
	<form name="form1" class="form-inline" id="form1" action="" method="post" onsubmit="return ISSUES.save(this)"> 
		<input type="hidden" name="ftype" value="new"  />
		<div class="span4 pull-left">
			<div class="pull-left"  >
				<label class="ltitle">Start Date</label><br />			
				<div data-date-format="yyyy-mm-dd" class="input-append date cdate" style="width: 148px !important">
					<input id="start_date" name="start_date" type="text" readonly="" value="<?php echo ( isset($_GET['from']))?$_GET['from']:date('Y-m-d'); ?>" size="16" class="span7">
					<span class="add-on"><i class="icon-calendar" ></i></span>
				</div> 
			</div>
			
			<div class="pull-left"  >
				<label class="ltitle">End Date</label> <br />			
				<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
					<input id="end_date" name="end_date" type="text" readonly="" value="<?php echo ( isset($_GET['from']))?$_GET['from']:date('Y-m-d'); ?>" size="16" class="span7">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
				
			</div>

			<br style="clear:both"/>	

			<p>	
			<div class="pull-left">
				<label class="ltitle">Start Time</label> <br />			
				<div class="input-append bootstrap-timepicker">
					<input id="timepicker1" name="time1" type="text" class="input-small">
					<span class="add-on"><i class="icon-time"></i></span>
				</div>
				
			</div>
			
			<div class="pull-left">
				<label class="ltitle" style="padding-left: 30px">End time</label><br />			
				<div class="input-append bootstrap-timepicker" style="padding-left: 30px">
					<input id="timepicker2" name="time2" type="text" class="input-small">
					<span class="add-on"><i class="icon-time"></i></span>
				</div>
				
			</div>
			</p>
			
			<br style="clear:both"/>
			<br/>
			<!--<p>		 
				<label class="ltitle">Issue #: <strong style="color:red">*</strong></label>
				<input type="text" name="issue_no" class="span4" >	 
			</p>-->
			
			<p>			
				<label class="ltitle">Total Down Time:</label>
				<input type="text" name="total_downtime" id="total_downtime" value="0:0" class="span4">		
			</p>
			 		
			<label class="ltitle">Centers: <strong style="color:red">*</strong></label> <input type="checkbox" id="center_all" style="padding:1px" /> All
			<div style="font-size: 14px;">
				<ul class="unstyled">
				<?php 
					//$i=0;
					foreach($centers as $key=>$value): 
						//if( $i%2==0 AND $i != 0) echo '<br style="clear:both"/>'; 
				?>
				<li style="padding: 0px 4px; width: 130px; float: left"> <label class="checkbox" style=""><input type="checkbox" name="center[]"  class="center_list" value="<?php echo $value; ?>"/> <?php echo $value; ?> </label> </li>
				<?php  endforeach; ?> 
				</ul>
			</div>
			
			<br style="clear:both" />
			<br />			
			
			<p>
			<label class="ltitle">Issue Description:</label>
			<textarea name="issue_desc" class="input-xlarge" rows="4"></textarea>	
			</p>			
			    
			<p>
			<label class="ltitle">Incident #: <strong style="color:red">*</strong></label>
			<input type="text" class="in-line" name="incident_no" >	
			</p>		 
		 			
		</div>
		   
		<div class="span4 pull-left"> 
		 
			<p>
			<label class="ltitle">Root Cause:</label> 
			<textarea name="root_cause" class="input-xlarge"></textarea>	
			<?php //echo form_dropdown('root_cause', $root_cause, '', '');  ?>		
			</p>			
			 
			<p>
			<label class="ltitle">CA Ticket #: </label>
			<input type="text" name="ca_ticket_no" class="span4" >
			</p>
			
			<!-- 
			<p>
			<label class="ltitle">Notification #: </label>
			<input type="text" name="notification_no" class="span4">	
			</p>	
			-->
			
			<p>
				<label class="ltitle">Resolved by: </label>
				<input type="text" name="resolve_by" class="span4" >	
			</p>
			
			<p>
			<label class="ltitle">CR #: (ORR/PSI)</label>
			<input type="text" name="cr_no" >
			</p>
			
			 
			<label class="ltitle">CR Deployment Date: (ORR/PSI)</label>			
			<div data-date-format="yyyy-mm-dd" class="input-append date cdate" style="width: 176px" >
				<input id="cr_deploy_date" name="cr_deploy_date" type="text" readonly="" value="" class="span6" >
				<span class="add-on"><i class="icon-calendar"></i></span>
			</div>
			  
			<p>
			<label class="ltitle">Potential Customer Impact: </label>
			<input type="text" name="po_cust_impact" class="span4">	
			</p>

			<p>
			<label class="ltitle"># of Dropped Calls: </label>
			<input type="text" name="drop_calls" class="span4">	
			</p>
			  
			<p>
			<label class="ltitle"># Agents Impact: </label>
			<input type="text" name="agent_impacted" class="span4">	
			</p>
			
			<p>
			<label class="ltitle"># of Agents Staffed: &nbsp;</label>
			MIA <input type="text" name="staff_mia" class="span2">	
			ATL <input type="text" name="staff_atl" class="span2">	
			</p>			
		</div>
		
		<div class="span3 pull-left">
			<label class="ltitle">System Impacting: <strong style="color:red">*</strong></label>
			<div style="height: 450px; overflow: scroll"> 
				<div style="font-size: 14px;">
					<ul class="unstyled">
					<?php  
						foreach($system_impacting as $key=>$value): //$i++; 
					?>
					<li class="" style="padding: 2px 4px"> <label class="checkbox" style=""><input type="checkbox" name="sys_impacting[]" class="system_impacting" value="<?php echo $value; ?>"/> <?php echo $value; ?> </label> </li>
					<?php endforeach; ?> 
					<ul>
				</div>
			</div>
			<div id="sys_other_cont" style="display:none">
			<label class="ltitle">OTHER: </label>
			<input type="text" name="sys_imp_other" id="sys_imp_other" value="" />
			</div>
		</div>			
		
		<br style="clear:both"/>
		<div class="row-fluid text-center">		
			<button type="submit" class="btn btn-primary">Submit</button> 
		</div>
	</form>	
</div>	