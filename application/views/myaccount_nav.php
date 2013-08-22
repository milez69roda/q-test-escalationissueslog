<h4 style="">Manage Account</h4>

<div>
 	
<ul class="nav nav-tabs">
<?php 
$segment = $this->uri->segment(1);  
?>
<li <?php echo ($segment == 'myaccount')?'class="active"':''; ?> > <a href="myaccount">My Account</a> </li>
<?php if( $this->session->userdata('ESCISSL_ROLEID') == 1 ): ?>
<li <?php echo ($segment == 'manageaccount')?'class="active"':''; ?> ><a href="manageaccount">Manage Accounts</a></li> 
<?php endif; ?>
</ul>  
 
</div>