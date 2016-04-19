<html xmlns="http://www.w3.org/1999/xhtml">
<div class="top-menu">
    <a href="index.php">Главная</a>->
    <a href="newInvoice.php"> Поставка </a> ->
    <a href=""> Страховой запас </a>
</div>
<hr>
<div class="title">
    <h2> Расчет страхового запаса </h2>
</div>

<div class="center-block">

    <form action=" ?Info" method="POST">
        <table border=0 width=50% align=center>
<!--            <tr width=25%>
                <td align=right><label for="detail1"> Модель*<label></td>
                <td align=left>
                    <select id="detail1" class="form__input form__input_wide" name=id_m>
                        <?php
/*                        foreach ($models as $model):
                            echo("<option value = " . $model['Id_M'] . ">" . $model['Name'] . "</option>");
                        endforeach;
                        */?>
                    </select>
                </td>
            </tr>-->

            <tr width=25%>
                <td align=right> <label for="date">Месяц и Год производства<label></td>
                <td align=left><input id="date" class="form__input" type="month" name=date   required></td>
            </tr>
            <tr width=25%>
                <td align=right> <label for="count1">Необходимое качество <br>обслуживания<br> P( < 1.0)<label></td>
                <td align=left><input id="count1" class="form__input" type=number name=t_param min="0" max="1" step="0.01" required></td>
            </tr>
            <tr>
                <td align=center><input class="btn btn-primary" type=reset value="Очистить"></td>
                <td align=center><input class="btn btn-primary" type=submit name=send value="Отправить"></td>
            </tr>
        </table>
        <?php if ($error_str): ?>
            <div class="errors"><?php {
                    echo $error_str;
                } ?></div>
        <?php endif ?>
    </form>
</div>
</html>			