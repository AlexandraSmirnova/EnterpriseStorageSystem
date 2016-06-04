<html xmlns="http://www.w3.org/1999/xhtml">
	<div class="top-menu">
		<span class="top-menu__item">
			<a href = "index.php" >Главная</a>
		</span> >
		<span class="top-menu__item">
			<a href= "" > Списание деталей </a>
		</span>
	</div>
		
	<div class="center-block">	
		<div class="title">
			<h3>Выберите модель или подсистему</h3>
		</div>
		<form action =" ?Info"  method="POST">		
			<div class="center-block__row row">
				<select class="form__select form__select_wide" name=id>
					<?php 
						foreach ($models as $model):
							echo("<option value = ".$model['Id_C'].">".$model['Name']."</option>");
						endforeach;
					?>								
				</select>						
				 <input class="btn btn-primary" type=submit name=send value= "Отправить">
			</div>		
			<div class = "error"><?php echo $error?></div>
		</form>
	</div>	
</html>