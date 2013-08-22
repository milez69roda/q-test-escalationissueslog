<link href="css/datepicker.css" rel="stylesheet" media="screen">
<script src="js/bootstrap-datepicker.js"></script>
<style>
	.ltitle{
		font-weight: bold;
	}
</style>
<script>
	
$(document).ready(function(){
	 
	$('.cdate').datepicker({ 'autoclose': true });
	
	ESCALATION = {
		
		update: function(f){
		
			if( confirm('Are you sure you want to submit?') ){	
				$.ajax({
					type: 'post',
					url: "client/escalation_save/",
					data: $(f).serialize(),
					dataType: 'json',
					success: function(json){
						if(json.status){
						
							COMMON.alert('Submitted', json.msg, 'alert-success', '<?php echo base_url(); ?>escalation/summary');									 
							//COMMON.clearForm(form);
						}else{							
							COMMON.alert('Warning', json.msg, 'alert-error', '');
						}
					},
					error: function(){
						
					}
				});
			}; 			
		 
			return false;
		} 
	}
	
	$("#issues_cat").click(function(){
		var x = $("#issues_cat option:selected").text();
		   
		if( x == 'Other' ){
			$(this).parent('label').addClass('badge-info');
			$("#issues_other_cont").show();
		}else{
			$(this).parent('label').removeClass('badge-info');
			$("#issues_other_cont").hide();
		}			
		
	});	
	
	/* $("#resolution").click(function(){
		var x = $("#resolution option:selected").text();
		   
		if( x == 'Other' ){
			$(this).parent('label').addClass('badge-info');
			$("#resolution_other_cont").show();
		}else{
			$(this).parent('label').removeClass('badge-info');
			$("#resolution_other_cont").hide();
		} 
	});	 */	
	
});
	  
</script>
<div class="row-fluid">
	<h3>Escalation Log</h3>
	<?php echo $nav; ?>
	<?php //print_r($row); ?>
	<form name="form1" id="form1" class="form-inline" action="" method="post" onsubmit="return ESCALATION.update(this);"> 
			<input type="hidden" name="indexid" value="<?php echo $row->id; ?>"  />
			<input type="hidden" name="ftype" value="edit"  />
			<div class="span6 pull-left">
				<label class="ltitle">Date Received</label>			
				<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
					<input id="date_received" name="date_received" type="text" readonly="" value="<?php echo $row->date_received; ?>" size="16" class="span8">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>	
				<br style="clear:both" />
				<br/> 			
				
				<p>
					<label class="ltitle">From: <strong style="color:red">*</strong></label> 
					<?php echo form_dropdown('es_from', $from, $row->es_from_id.':'.$row->es_from, '');  ?>
				</p>
				
				<p>
					<label class="ltitle">Customer Name: <strong style="color:red">*</strong></label>
					<input type="text" name="cust_name" value="<?php echo $row->cust_name; ?>">			
				</p>
				
				<p>
					<label class="ltitle" style="width: 80px">Email: <strong style="color:red">*</strong></label>
					<input type="text" name="email_address" value="<?php echo $row->email_address; ?>">				
				</p>
				
				<p>
					<label class="ltitle" style="width: 80px">Serial #:</label>
					<input type="text" name="serial_no" value="<?php echo $row->serial_no; ?>">		
				</p>
				
				<p>
					<label class="ltitle" style="width: 80px">MIN:</label> 	 
					<input type="text" name="es_min" value="<?php echo $row->es_min; ?>">					
				</p>
				
				<p>
					<label class="ltitle" style="width: 80px">Contact #:</label>
					<input type="text" name="es_contact" value="<?php echo $row->es_contact; ?>">						
				</p>
				
				<p>
					<label class="ltitle" style="width: 80px">Brands: <strong style="color:red">*</strong></label>
					<?php echo form_dropdown('brands', $brands, $row->brands_id.':'.$row->brands, '');  ?>	
				</p>
				
				<p>
					<label class="ltitle">Issues Category: <strong style="color:red">*</strong></label> 
					<?php echo form_dropdown('issues_cat', $issues, $row->issues_cat_id.':'.$row->issues_cat, ' id="issues_cat"');  ?>				
				</p>
				
				<div id="issues_other_cont" style="<?php echo ($row->issues_cat == "Other")?'':'display:none'; ?>">
					<label class="ltitle" style="width: 80px">Other: </label>
					<input type="text" name="issues_cat_other" id="issues_cat_other" value="<?php echo $row->issues_cat_other; ?>" maxlength="60"/>
				</div>	
				
				<p>
					<label class="ltitle">Issue Details:</label><br />
					<textarea name="issues_details" class="input-xlarge" maxlength="250"><?php echo $row->issues_details; ?></textarea>
				</p>
			</div>
			
			<div class="span5 pull-left">
			
				<p>
					<label class="ltitle" style="width: 120px">System:</label>
					<?php echo form_dropdown('system', $system, $row->system_impacting, ' id="system" ');  ?>
				</p>	

				<p>
					<label class="ltitle" style="width: 120px">CA Ticket # :</label>
					<input type="text" name="ca_ticket_no" value="<?php echo $row->ca_ticket_no; ?>">				
				</p>
				
				<p>
					<label class="ltitle" style="width: 120px">Sent only to FJ:</label>
					<select name="sent_fj">
						<option value="Yes" <?php ($row->sent_fj == 'Yes')?'selected="selected"':''; ?>>Yes</option>
						<option value="No" <?php ($row->sent_fj == 'No')?'selected="selected"':''; ?>>No</option>
					</select>	
				</p>
								
				<p>
					<label class="ltitle">Block from emailing FJ:</label>
					<select name="block_email_fj">
						<option value="Yes" <?php ($row->block_email_fj == 'Yes')?'selected="selected"':''; ?>>Yes</option>
						<option value="No" <?php ($row->block_email_fj == 'No')?'selected="selected"':''; ?>>No</option>
					</select>	
				</p>

				<p>			
					<label class="ltitle">Root Cause:</label>
					<!--<textarea name="root_cause" class="input-xlarge"><?php //echo $row->root_cause; ?></textarea>	-->
					<?php echo form_dropdown('root_cause', $root_cause, $row->root_cause, ' id="root_cause" ');  ?>
				</p>
	  
				<!--<p>
					<label class="ltitle" style="width: 120px">Resolution:</label>
					<?php //echo form_dropdown('resolution', $resolution, $row->resolution_id.':'.$row->resolution, ' id="resolution"');  ?>
				</p>
			
				<div id="resolution_other_cont" style="<?php //echo ($row->resolution == "Other")?'':'display:none'; ?>">
					<label class="ltitle" style="width: 120px">Other: </label>
					<input type="text" name="resolution_other" id="resolution_other" value="" maxlength="60" value="<?php echo $row->resolution; ?>"/>
				</div>-->

				<p>
					<label class="ltitle" style="width: 120px">Resolution:</label> <br />
					<textarea name="resolution" class="input-xlarge" maxlength="250"><?php echo $row->resolution; ?></textarea>
				</p>		
				
				
				<p>
					<label class="ltitle">CR # (ORR/PSI):</label>
					<input type="text" name="cr_no" value="<?php echo $row->cr_no; ?>">
				</p>
				 
				<label class="ltitle">CR Deployment Date (ORR/PSI): </label>			
				<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
					<input id="cr_deploy_date" name="cr_deploy_date" type="text" readonly="" size="16" class="span8" value="<?php echo ($row->cr_deploy_date != '0000-00-00')?$row->cr_deploy_date:''; ?>">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
				<br /><br />		
				
				<p>
					<label class="ltitle">Potential Customer Impact (ORR/PSI):</label>
					<input type="text" name="po_cust_impact" class="span4">
				</p>
				
				<p>
				<label class="ltitle">Status:</label>
				<select name="es_status">
					<option value="Opened">Opened</option>
					<option value="Closed">Closed</option>
				</select>					
				</p>
			</div> 
			<br style="clear:both"/>
			
			<div class="row text-center">	
			<button type="submit" class="btn btn-primary">Update</button>
			</div> 
		 
	</form>	
</div>	