<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<a href = "index.php" >Главная</a>->
		<a  onclick="location.href=' ?Del'">Списание деталей</a>->
		<a href= "" > <?php echo $model_name['Name']?> </a> 
	</div>
	<hr>
	<div class="center-block">	
		<div class="title">
			<h3>Выберите необходимые детали</h3>
		</div>		
		<?php if($output):?>
			<div class="errors"><?php echo $output;?></div>
		<?php endif; ?>
			
		<table class="report-table" border = '1'>
			<tr>
				<td>Деталь</td>
				<td>На складе</td>
				<td>Необходимо</td>
				<td></td>
			</tr>
			<?php foreach ($details as $detail):?>
			<tr>
				<td> <?php echo $detail['name'];?> </td>
				<td> <?php echo $detail['storage'];?></td>
				<td> <?php echo $detail['count'];?> </td>				
				<td>
					<form action =" ?Detail"  method="POST"> 
						<input class="form__input" type="hidden" name="name" value=<?php echo $detail['name'] ?>>
						<input class="form__input" type="number" name = "count" min="1" max=<?php echo $detail['storage'];?>>
						<input class="btn btn-primary" type="submit" value="Добавить">						
					</form>
				</td>
			</tr>
			<?php endforeach; ?>				
		</table>
		
		<form action=" ?Show" method="POST">
			<input class="btn btn-primary" type=submit name=send value= "Посмотреть выбранное">
		</form>
		
	</div>
</html>
