 <style>
 
 </style>
<script>
	
	$(document).ready(function(){
		
		ACCOUNT = {
			save: function(f){
				if( confirm('Are you sure you want to submit?') ){
			
					$.ajax({
						type: 'post',
						url: "client/ajax_changepassword/",
						data: $(f).serialize(),
						dataType: 'json',
						success: function(json){
							if(json.status){							
								COMMON.alert('Success', json.msg, 'alert-success', '');									 
								//COMMON.clearForm(f);
							}else{								
								COMMON.alert('Warning', json.msg, 'alert-error', '');
							}
						},
						error: function(){
							
						}
					});
				}
				
				return false;			
			}
		}
		
	}); 
	
</script>
<div class="row-fluid">
	  
	<?php echo $nav; ?>
	
	<div class="row">
		<form name="form1" id="form1" action="" method="post" onsubmit="return ACCOUNT.save(this)" >		
			<label title="Username">Username</label>
			<input type="text" name="user45" class="disabled" value="<?php echo $this->username?>" readonly >
			
			<label title="Password">Password</label>
			<input type="text" name="pass45" >		

			<br />
			<button type="submit" class="btn btn-warning">Change Password</button>			
		</form>
	</div> 
</div>	