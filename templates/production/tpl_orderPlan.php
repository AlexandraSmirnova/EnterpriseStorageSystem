<html xmlns="http://www.w3.org/1999/xhtml">
<div class="top-menu">
    <span class="top-menu__item">
        <a href = "index.php" >Главная</a>
    </span> >
    <span class="top-menu__item">   
        <a href= "productionPlan.php" >План производства</a>
    </span>
</div>

<div class="title">
    <h2>План поставок</h2>
</div>
<div class="center-block">
    <?php if($error_str): ?>
        <div class="errors"><?php echo $error_str;?></div>
    <?php endif ?>
    <table class="report-table" border="1">
        <tr>
            <td> Название </td>
            <td> Поставщик </td>
            <td> Количество</td>
            <td> Дата заказа</td>
        </tr><?php foreach ($new_details as $detail):?>
            <tr>
            <td> <a href= <?php echo "listOfModels.php?id=".$model['id_model']."&name=".$model['name']."";?> > <?php echo $detail['name'];?> </a></td>
            <td> <?php echo $detail['supplier'];?></td>
            <td> <?php echo $detail['count'];?></td>
            <td> <?php echo $detail['date_order'];?></td>
            </tr><?php endforeach; ?>
    </table>
</div>
</html>