<?php $segment = $this->uri->segment(2);  ?>

<?php if($navlog == 'escalation'): ?>
<div> 
	<ul class="nav nav-tabs">
		
		<?php if( isset($_GET['edit']) ):?>	
		<li><a href="escalation/form">Escalation Form</a> </li>		 
		<li class="active"><a href="escalation/form/?edit=<?php echo $_GET['edit']; ?>">Escalation Edit Form</a></li>		 
		<?php else: ?>
		<li <?php echo ($segment == 'form')?'class="active"':''; ?> > <a href="escalation/form">Escalation Form</a></li>		 
		<?php endif;?>
		
		<li <?php echo ($segment == 'summary')?'class="active"':''; ?> ><a href="escalation/summary">Summary</a></li> 
		 
	</ul>  
</div>
<?php endif; ?>

<?php if($navlog == 'issues'): ?>
<div> 
	<ul class="nav nav-tabs"> 
	
		<?php if( isset($_GET['edit']) ):?>	
		<li><a href="issues/form">Issues Form</a> </li>		 
		<li class="active"><a href="issues/form/?edit=<?php echo $_GET['edit']; ?>">Issues Edit Form</a></li>		 
		<?php else: ?>
		<li <?php echo ($segment == 'form')?'class="active"':''; ?> > <a href="issues/form">Issues Form</a> </li>		 
		<?php endif;?>
		 	 
		<li <?php echo ($segment == 'summary')?'class="active"':''; ?> ><a href="issues/summary">Summary</a></li> 
	</ul>  
</div>
<?php endif; ?>