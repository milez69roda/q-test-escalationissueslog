<!DOCTYPE html>
<html>
<head>
<title>Escalation/Issues Logger</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<base href="<?php echo base_url(); ?>"/>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="print">
<link href="css/DT_bootstrap.css" rel="stylesheet" media="print"> 

<style>
	body{
		font-size: 80% !important;
	}
</style>
 

<script type="text/javascript">
 
window.print();
 window.onfocus=function(){ window.close();}
</script>

</head>
<body>

<?php //print_r($records); ?>
<h2><?php echo $title; ?></h2>
<table cellpadding="0" cellspacing="0" border="1" class="table table-striped table-bordered" id="example1" > 
	<tr>
		<?php foreach(@$header as $row): ?>
		<th><?php echo $row; ?></th>
		<?php endforeach; ?>
	</tr>
 
	<?php foreach(@$records as $row): ?>
	<tr> 
		<?php foreach($row as $val): ?>
		<td><?php echo $val; ?></td> 
		<?php endforeach; ?>	
	</tr>	
	<?php endforeach; ?>	 

</table>

</tbody>
</html>