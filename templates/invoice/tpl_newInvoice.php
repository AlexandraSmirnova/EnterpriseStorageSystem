<html xmlns="http://www.w3.org/1999/xhtml">
<div class="top-menu">
    <span class="top-menu__item">
        <a href="index.php">Главная</a>
    </span> >
    <span class="top-menu__item">
        <a href=""> Поставка </a>
    </span>
</div>

<div class="title">
    <h2> Поставка деталей </h2>
</div>
<div class="left-block">
    <a class="btn btn-default" href="reserveStock.php">Расчитать страховой запас</a>
</div>

<div class="center-block">

    <form action=" ?Info" method="POST">
        <table border=0 width=50% align=center>
            <tr width=25%>
                <td align=right><label for="detail1"> Деталь*<label></td>
                <td align=left>
                    <select id="detail1" class="form__input form__input_wide" name=id_d>
                        <?php
                        foreach ($details as $detail):
                            echo("<option value = " . $detail['Id_C'] . ">" . $detail['Name'] . "</option>");
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr width=25%>
                <td align=right> <label for="count1">Количество*<label></td>
                <td align=left><input id="count1" class="form__input" type=text name=count required></td>
            </tr>
            <tr width=25%>
                <td align=right><label for="supp1"> Поставщик*<label></td>
                <td align=left>
                    <select id="supp1" class="form__input form__input_wide" name=id_s>
                        <?php
                        foreach ($suppliers as $supp):
                            echo("<option value = " . $supp['id'] . ">" . $supp['name'] . "</option>");
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align=right width=50%><label> Цена(1шт)*</label></td>
                <td align=left><input id="price1" class="form__input" type=text name=cost required></td>
            </tr>
            <tr>
                <td align=right width=50%> <label for="date1">Дата поставки*<label></td>
                <td align=left><input id="date1" class="form__input form__input_wide" type=date name=date required></td>
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