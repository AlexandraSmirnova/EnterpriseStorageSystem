<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<span class="top-menu__item">
			<a href = "index.php" >Главная</a>
		</span> >		
		<span class="top-menu__item">
			<a href= "" > Поставка </a> 
		</span>
	</div>
	
	<div class="title">
		<h2> Отчет по поставке </h2>
	</div>
	<div class="center-block">		
		<form action =" ?Delete"  method="POST">  
			<table class="report-table" border="1">
				<tr>
					<td> Деталь </td>
					<td><?php echo($detail);?></td>
				</tr> 
						
				<tr width=25%>
					<td> Количество </td>
					<td> <?php echo($count);?> </td>   
				</tr> 
				<tr>
					<td> Поставщик </td>
					<td> <?php echo($supplier);?></td>
				</tr>
				<tr> 
					<td> Цена(1шт) </td>
					<td> <?php echo($cost);?> </td>
				</tr>
				<tr> 
					<td> Общая цена </td>
					<td> <?php echo($cost * $count);?> </td>
				</tr>
				<tr> 
					<td> Дата поставки </td>
					<td> <?php echo($date);?> </td>
				</tr>
			</table>
			<table align="center">
				<tr>							
					<td>
						<br>
						<input type="hidden" name="id_i" value=<?php echo $id_i; ?>>
						<input class="btn btn-primary" type="submit" value="Отменить заявку">
					</td>
					<td>								
						<br>
						<input class="btn btn-primary"  type="button" value="Подтвердить" onclick="location.href=' ?Success'">
					</td>
				</tr> 
			</table>
		</form>	
	</div>		
</html>			