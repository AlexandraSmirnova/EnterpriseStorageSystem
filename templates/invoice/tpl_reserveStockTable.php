<html xmlns="http://www.w3.org/1999/xhtml">
<div class="top-menu">
    <a href="index.php">Главная</a>->
    <a href="newInvoice.php"> Поставка </a> ->
    <a href=""> Страховой запас </a>
</div>
<hr>
<div class="title">
    <h2> Cтраховой запас по плану производства  </h2>
</div>

<div class="center-block">
    <?php  if($details){?>
        <table class="report-table" border="1">
            <tr>
                <td> Деталь </td>
                <td> Количество </td>
            </tr>
            <?php foreach ($details as $detail):?>
                <tr>
                    <td> <?php echo $detail['name'];?> </td>
                    <td> <?php echo $detail['reserve'];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <!--<a class="btn btn-primary" href = "modelTree.php<?php echo "?id_m=".$id."&name_m=".$model."";?>">Структура Модели</a>-->
    <?php }
    else {
        echo($output);
    }
    ?>
</div>
</html>			