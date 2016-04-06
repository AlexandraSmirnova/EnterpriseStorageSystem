<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<a href = "index.php" >Главная</a>->
		<a href= "" >Модели</a> 
	</div>
	<hr>
	
	<div class="title">
		<h2>Список моделей</h2>
	</div>
	<div class="center-block">
		<table class="report-table" border="1">
			<tr>
				<td> Номер </td>
				<td> Название</td> 
				<td> Цена</td> 						
			</tr><?php foreach ($models as $model):?>
			<tr> 
				<td> <?php echo $model['id'];?></td>
				<td> <a href= <?php echo " ?id=".$model['id']."&name=".$model['name']."";?> > <?php echo $model['name'];?> </a></td>
				<td> <?php echo $model['price'];?></td>						
			</tr><?php endforeach; ?>
		</table>	
	</div>
</html>