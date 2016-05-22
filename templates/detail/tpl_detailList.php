<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<span class="top-menu__item">
			<a href = "index.php" >Главная</a>
		</span> >
		<span class="top-menu__item">
			<a href= "" >Детали</a> 
		</span>
	</div>
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
				<td> <?php echo $detail['Id_C'];?></td>
				<td> <a href= <?php echo " ?id=".$detail['Id_C']."&name=".$detail['Name']."";?> > <?php echo $detail['Name'];?> </a></td>
				<td> <?php echo $detail['Cost'];?></td>						
			</tr><?php endforeach; ?>
		</table>						
	</div>
</html>