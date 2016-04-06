<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<a href = "index.php" >Главная</a>->			
		<a href = "delaitingDetail.php" > Списание деталей </a> 
	</div>
	<hr>
	<div class="center-block">	
		<div class="title">
			<h3>Выбранные детали</h3>
		</div>		
		<table class="report-table" border = '1'>
			<tr>
				<td>Деталь</td>				
				<td>Количество</td>				
			</tr>
			<?php for ($i = 0; $i < count($names); $i++):?>
			<tr>
				<td> <?php echo $names[$i];?> </td>				
				<td> <?php echo $count[$i];?> </td>								
			</tr>
			<?php endfor; ?>	
			
		</table>
		<table align="center">
			<tr>
				<td>
					<form action=" ?Del" method="POST">
						<input class="btn btn-primary" type=submit name=send value="Очистить выбор">
					</form>
				</td>
				<td>
					<form action=" ?Ok" method="POST">
						<input class="btn btn-primary" type=submit name=send value="Подтвердить списание">
					</form>
				</td>
			</tr>
		</table>
	</div>
</html>