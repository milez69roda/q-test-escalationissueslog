<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

<link href="css/datepicker.css" rel="stylesheet" media="screen">
<script src="js/bootstrap-datepicker.js"></script>
 <style>
	#example2 a{
		cursor: pointer !Important;
	}
	
	.well{
		padding: 2px !important;
	}	
	
	td.cuYear, th.cuYear{
		background-color: #FFFCBF !important;
	}
	
	.badge-info{
		cursor: pointer !important;
		color: #000;
		background-color: #6EACEA !important;
	}		
	
	#example1{
		width: auto;
	 }		
 </style>
<script>
	
	$(document).ready(function(){
	
	
		//oTable = $('#example').dataTable();
		
		$.get('client/issue_source', function(data){ 
			$("#odiv1").html(data);
		});
		
 
		$('.cdate').datepicker({ 'autoclose': true }); 
		
		OVERVIEW = {
		
			getDetails: function( s, d, c ){
							
				/* $.get('client/issue_details', {date:d, id:s, col:c}, function(data){
					$("#odiv2").html(data);
					$("html, body").animate({ scrollTop: $(document).height()-$(window).height() });						
									  
				}); */

							
				window.open('<?php echo base_url(); ?>client/issue_details/?date='+d+'&id='+s+'&col='+c);
			},
			
			onBtnSearchClick: function(){
			
				var start = $('#start_date').val();
				var end = $('#end_date').val(); 
				
				$.get('client/issue_source', {start:start, end:end}, function(data){
					$("#odiv1").html(data);
					  
				});			
			
			},
			
			exportoverview: function( name ){
				window.location = "<?php echo base_url(); ?>client/export/?channel="+name;
			},
				
			printit: function(name){
				window.open('<?php echo base_url(); ?>client/printit/?c='+name);	
			}
			
		}	
	});
	  
</script>
<div class="row-fluid">
	<div style="font-size: 15px;"> 
		<ul class="nav nav-tabs"> 
			<?php if( in_array(1, $this->access) ): ?><li style="font-weight: bold"><a href="client">Escalation</a> </li><?php endif; ?> 		 
			<?php if( in_array(2, $this->access) ): ?><li class="active" style="font-weight: bold; "><a style="color: red !important;" href="issues/overview">Issues</a></li>	<?php endif; ?> 	  
		</ul>  
	</div>
	
	<div class="row">
		<div class="well"> 
			<form class="form-inline" id="search_form"  method="post" action="" style="margin-bottom: 0px !important;">
				<div class="row-fluid"> 
					<label>Start Date&nbsp;&nbsp;&nbsp;&nbsp;</label>			
					<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
						<input id="start_date" name="start_date" type="text" readonly="" value="2013-01-01" size="16" class="span8">
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>End Date&nbsp;&nbsp;</label>			
					<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
						<input id="end_date" name="end_date" type="text" readonly="" value="<?php echo date('Y').'-12-31'; ?>" size="16" class="span8">
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>				
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-primary" onclick="OVERVIEW.onBtnSearchClick()">Search</button>
				</div>			
			</form> 
		</div>	
		
		<h4 class="text-left">Issues Overview &nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-primary" onclick="OVERVIEW.exportoverview('issuessource')">Export</button>
			<button type="button" class="btn btn-primary" onclick="OVERVIEW.printit('is')">Print</button>
		</h4>	
		 
		<p style="font-size: 14px;">Legend: <strong><span class="badge badge-info">I</span></strong> - Number of Times Impacted, <strong><span class="badge badge-info">A</span></strong> - Number of Agents Impacted, <strong><span class="badge badge-info">D</span></strong>-DownTime Calculation (hrs/mins)</p>		
		<div id="row"> 
			<div id="odiv1"></div>
		</div>
		
		<div id="row"> 
			<div id="odiv2"></div>
		</div>		
		 
	</div>
</div>