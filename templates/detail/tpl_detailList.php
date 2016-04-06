<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<a href = "index.php" >Главная</a>->
		<a href= "" >Детали</a> 
	</div>
	<hr>
	<div class="title">
		<h3>Список деталей</h3>
	</div>
	<div class="center-blok">
		<table class="report-table" border="1">
			<tr>
				<td> Номер </td>
				<td> Название</td> 
				<td> Цена</td> 						
			</tr><?php foreach ($details as $detail):?>
			<tr> 
				<td> <?php echo $detail['id'];?></td>
				<td> <a href= <?php echo " ?id=".$detail['id']."&name=".$detail['name']."";?> > <?php echo $detail['name'];?> </a></td>
				<td> <?php echo $detail['price'];?></td>						
			</tr><?php endforeach; ?>
		</table>						
	</div>
</html>