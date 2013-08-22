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
		
		save: function(f){
		
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
	<form name="form1" id="form1" action="" class="form-inline" method="post" onsubmit="return ESCALATION.save(this);"> 
		<input type="hidden" name="ftype" value="new"  />
		<div class="span6 pull-left">
			
			 
			<label class="ltitle">Date Received: </label>			
			<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
				<input id="date_received" name="date_received" type="text" readonly="" value="<?php echo ( isset($_GET['from']))?$_GET['from']:date('Y-m-d'); ?>" size="16" class="span8">
				<span class="add-on"><i class="icon-calendar"></i></span>
			</div>	
			<br style="clear:both" />
			<br/>
			 			
			<p>	
				<label class="ltitle" style="width: 80px">From: <strong style="color:red">*</strong></label> 
				<?php echo form_dropdown('es_from', $from, '', '');  ?>
			</p>
			
			<p>
				<label class="ltitle">Customer Name: <strong style="color:red">*</strong></label>
				<input type="text" name="cust_name" >				
			</p>
			
			<p>
				<label class="ltitle" style="width: 80px">Email:</label>
				<input type="text" name="email_address" >			
			</p>
			
			<p>
				<label class="ltitle" style="width: 80px">Serial #:</label>
				<input type="text" name="serial_no" >		 
			</p>
			
			<p>
				<label class="ltitle" style="width: 80px">MIN:</label>
				<input type="text" name="es_min" >	
			</p>
			
			<p>
			<label class="ltitle" style="width: 80px">Contact #:</label>
			<input type="text" name="es_contact" >		
			</p>
			
			<p>
				<label class="ltitle" style="width: 80px">Brands: <strong style="color:red">*</strong></label>
				<?php echo form_dropdown('brands', $brands, '', '');  ?>	
			</p>
			
			<p>
				<label class="ltitle">Issues Category: <strong style="color:red">*</strong></label> 
				<?php echo form_dropdown('issues_cat', $issues, '', ' id="issues_cat" ');  ?>				
			</p>
			
			
			<div id="issues_other_cont" style="display:none">
				<label class="ltitle">Other: </label>
				<input type="text" name="issues_cat_other" id="issues_cat_other" value="" maxlength="60"/>
			</div>			
			
			
			<p>
				<label class="ltitle">Issue Details:</label> <br />
				<textarea name="issues_details" class="input-xlarge" maxlength="250"></textarea>
			</p>
			
		</div>
		
		<div class="span5 pull-left">
			<p>
				<label class="ltitle" style="width: 120px">System:</label>
				<?php echo form_dropdown('system', $system, '', ' id="system" ');  ?>
			</p>			
			
			<p>
			<label class="ltitle" style="width: 120px">CA Ticket # :</label>
			<input type="text" name="ca_ticket_no" class="span5">	
			</p>
			
			<p>
			<label class="ltitle" style="width: 120px">Sent only to FJ:</label>
			<select name="sent_fj">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>	
			<p>
			
			<p>
			<label class="ltitle">Block from emailing FJ:</label>
			<select name="block_email_fj">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>	
			</p> 
			
			<p>
				<label class="ltitle" style="width: 120px">Root Cause:</label> 
				<?php echo form_dropdown('root_cause', $root_cause, '', ' id="root_cause" ');  ?>
			</p>
			
			<p>
				<label class="ltitle" style="width: 120px">Resolution:</label> <br />
				<textarea name="resolution" class="input-xlarge" maxlength="250"></textarea>
			</p>
			
			
			<!--<div id="resolution_other_cont" style="display:none">
				<label class="ltitle" style="width: 120px">Other: </label>
				<input type="text" name="resolution_other" id="resolution_other" value="" maxlength="60"/>
				<br /><br />
			</div>-->				
			
			<p>
				<label class="ltitle" style="width: 120px">CR #(ORR/PSI):</label>
				<input type="text" name="cr_no" >	
			</p>
			
			
			<label class="ltitle">CR Deployment Date (ORR/PSI):</label>			
			<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
				<input id="cr_deploy_date" name="cr_deploy_date" type="text" readonly="" value="" size="16" class="span8">
				<span class="add-on"><i class="icon-calendar"></i></span>
			</div>
			<br /><br />			
			<p>
				<label class="ltitle">Potential Customer Impact (ORR/PSI): </label>
				<input type="text" name="po_cust_impact" class="span4">
			</p>
			
			<p>
				<label class="ltitle" style="width: 120px">Status:</label>
				<select name="es_status">
					<option value="Opened">Opened</option>
					<option value="Closed">Closed</option>
				</select>				
			</p>
		</div>
		<br style="clear:both"/>
		
		<div class="row text-center">		
		<button type="submit" class="btn btn-primary">Submit</button>
		</div> 
		 
	</form>	
</div>	