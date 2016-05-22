<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<span class="top-menu__item">
			<a href = "index.php" >Главная</a>
		</span> >		
		<span class="top-menu__item">
			<a href= "storage.php" >Склад</a>
		</span>
	</div>
	<div class="title">
		<h3> Просмотр склада </h3>
	</div>
	
	<div class="center-block">	
		<form action =" ?Info"  method="POST"> 
			<div class="center-block__row row">
				<span>Выберите дату</span>				
				<input class="form__input" type=date name=date required> 						
				<input class="btn btn-primary" type=submit value= "Отправить"> 				
			</div>
		</form>		
		<?php if($error_str): ?>
			<div class="errors"><?php echo $error_str;?></div> 
		<?php endif ?>
		<table class="report-table" border="1">
			<tr>
				<td> Деталь </td>
				<td> Количество </td> 	
				<td> Время инвентаризации </td>
			</tr><?php foreach ($details as $detail):?>
			<tr> 
				<td> <?php echo $detail['name_c'];?></td>
				<td>  <?php echo $detail['count'];?> </td>						
				<td>  <?php echo $detail['time'];?> </td>
			</tr><?php endforeach; ?>
		</table>
		<form action =" ?Inventory"  method="POST">  				
			<input class="btn btn-primary"type=submit value= "Провести инвентаризацию"> 					 															 					
		</form>
	</div>			
</html>			