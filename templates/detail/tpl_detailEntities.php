<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<a href = "index.php" >Главная</a>->
		<a href= "listOfDetails.php" >Детали</a>->
		<a href= "" ><?php echo $detail?></a>
	</div>
	<hr>	
	<div class="title">
		<h3>Использование детали</h3>
	</div>
	
	<div class="center-block">
	<?php  if($details){?>
		<table class="report-table" border="1">
			<tr>
				<td> Система </td>
				<td> Количество </td> 									
			</tr><?php foreach ($details as $detail):?>
			<tr> 
				<td> <?php echo $detail['parent'];?></td>
				<td>  <?php echo $detail['entities'];?> </td>						
			</tr><?php endforeach; ?>
		</table>
	<?php }  
		else {
			echo($output);
		}
	?>
	</div>
</html>