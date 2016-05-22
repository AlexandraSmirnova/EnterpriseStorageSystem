<html xmlns="http://www.w3.org/1999/xhtml">
<div class="top-menu">
    <span class="top-menu__item">
        <a href = "index.php" >Главная</a>
    </span> >
    <span class="top-menu__item">   
        <a href= "" >План производства</a>
    </span>
</div>

<div class="title">
    <h2>План производства</h2>
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
            <td> Название </td>
            <td> Количество</td>
            <td> Дата сборки</td>
        </tr><?php foreach ($models as $model):?>
            <tr>
            <td> <a href= <?php echo "listOfModels.php?id=".$model['id_model']."&name=".$model['name']."";?> > <?php echo $model['name'];?> </a></td>
            <td> <?php echo $model['count'];?></td>
            <td> <?php echo $model['start_production'];?></td>
            </tr><?php endforeach; ?>
    </table>
    <a class="btn btn-primary" href=" ?orders">Спланировать закупки</a>
</div>
</html>