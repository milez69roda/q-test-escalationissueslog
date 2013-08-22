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
	
	#example1 tfoot tr td, #example1 tfoot tr th, #example2 tfoot tr td, #example2 tfoot tr th {
		border-top: 1px solid red;
	}	
	.badge-info{
		cursor: pointer !important;
		color: #000;
		background-color: #6EACEA !important;
	}	
	
	#example1, #example2 {
		width: auto;
	 }	
</style>
<script>
	
	$(document).ready(function(){
		 
		$.get('client/escalation_source', function(data){
			$("#odiv1").html(data);
		});
		
		setTimeout(function(){
			$.get('client/escalation_issuetype', function(data){
				$("#odiv2").html(data);
			}); 
		},800);		
		

		
		$('.cdate').datepicker({ 'autoclose': true }); 
		
		OVERVIEW = {
			
			onFromClick: function(id, f){
			
				//$(f.id).popover('show');
				//alert(f.id);
				var start = $('#start_date').val();
				var end = $('#end_date').val();
				
				$.get('client/escalation_issuetype',{start:start, end:end, from_id:id, ftxt:$(f).text()}, function(data){
					$("#odiv2").html(data);
					 
					/* var target_offset = $("#escalationdetails").offset();
					var target_top = target_offset.top;
					  
					$("html, body").animate({ scrollTop: target_top }); */						
				});
			},
			
			onTypeClick: function(id, source_id){
				var start = $('#start_date').val();
				var end = $('#end_date').val();
				
				$.get('client/escalation_source',{start:start, end:end, cat_id:id, from_id:source_id  },  function(data){
					$("#odiv1").html(data);
				});
			},
			
			onBtnSearchClick: function(){
				var start = $('#start_date').val();
				var end = $('#end_date').val(); 
				
				$.get('client/escalation_source', {start:start, end:end}, function(data){
					$("#odiv1").html(data); 
				});
				 
				setTimeout(function(){
					$.get('client/escalation_issuetype', {start:start, end:end}, function(data){
						$("#odiv2").html(data); 
					});
				},800);						
				 
			},
			
			onTypeViewDetails: function(id, month, from){  
				
				window.open('client/escalationdetails/?id='+id+'&month='+month+'&from='+from);
				  
				/* $.get('client/escalationdetails',{month:month, from:from, id:id },  function(data){
					$("#odiv3").html(data);
					$("html, body").animate({ scrollTop: $(document).height()-$(window).height() });		
				});	 */			
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
			<?php if( in_array(1, $this->access) ): ?><li class="active"  style="font-weight: bold; "><a style="color: red !important;" href="client">Escalation</a> </li><?php endif; ?> 		 
			<?php if( in_array(2, $this->access) ): ?><li style="font-weight: bold"><a href="issues/overview">Issues</a></li> <?php endif; ?> 
		</ul>  
	</div>
	
	<div class="row" style=" ">
		<div class="well"> 
			<form class="form-inline" id="search_form"  method="post" action="" style="margin-bottom: 0px !important;">
				<div class="row-fluid"> 
					<label>Start Date&nbsp;&nbsp;&nbsp;&nbsp;</label>			
					<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
						<input id="start_date" name="start_date" type="text" readonly="" value="2013-01-01" size="16" class="span8">
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>End Date&nbsp;&nbsp;&nbsp;&nbsp;</label>			
					<div data-date-format="yyyy-mm-dd" class="input-append date cdate">
						<input id="end_date" name="end_date" type="text" readonly="" value="<?php echo date('Y').'-12-31'; ?>" size="16" class="span8">
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>				
					&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-primary" onclick="OVERVIEW.onBtnSearchClick()">Search</button>
				</div>			
			</form>
			<!--<div id="progress_label"></div> -->
			 
		</div>
		 
		<div id="row">
			<h4 class="text-left">Escalation Overview &nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" class="btn btn-primary" onclick="OVERVIEW.exportoverview('escalationoverviewfrom')">Export</button>
				<button type="button" class="btn btn-primary" onclick="OVERVIEW.printit('eof')">Print</button>
			</h4>
			<p><span style="padding: 4px; color: #F89406">Note: Click the FROM to see escalation details below</span></p> 
			<div id="odiv1"></div>
		</div> 
		
		<a id="escalationdetails"></a>
		<div id="row">
			<h4 class="text-left">Escalation Details &nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" class="btn btn-primary" onclick="OVERVIEW.exportoverview('escalationoverviewdetails')">Export</button>
				<button type="button" class="btn btn-primary" onclick="OVERVIEW.printit('eod')">Print</button>
			</h4>
			<p><span style="padding: 4px; color: #F89406">Note: Click the numbers in the blue boxes for additional details</span></p> 
			<div id="odiv2"></div>
		</div>	
		
		<div id="row"> 
			<div id="odiv3"></div>
		</div>
			
	</div>	
 
</div>