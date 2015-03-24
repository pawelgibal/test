<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'functions.php';
        ?>
        <form name="parametry_wejsciowe" action="imagic.php" method="POST" enctype="multipart/form-data">
            
            
            
            
            
            
            <p><label for="plik_podklad">plik podkladu</label>
                <input type="text" name="plik_podklad" value="/home/pawel/as_2013/altershop_pl_2014/koszulki/podklady/alafruit_czarny_kr450.png"  size="100"/><br</p>
            <p><label for="plik_podpis">plik podpis</label>
                <input type="text" name="plik_podpis" value="/home/pawel/as_2013/altershop_pl_2014/koszulki/podklady/podpis_hurt_alter_all.png"size="100" /></p>
            <p><label for="sciezka_wzorow">sciezka wzorow</label>
                <input type="text" name="sciezka_wzorow" value="/home/pawel/as_2013/altershop_pl_2014/koszulki/wzory/" size="100" /></p>
            <p><label for="sciezka_wzorow">sciezka tylow</label>
                <input type="text" name="sciezka_tylow" value="/home/pawel/as_2013/altershop_pl_2014/koszulki/wzory/tyl/" size="100" /></p>
            <p><label for="sciezka_wynikow">sciezka wynikow</label>
                <input type="text" name="sciezka_wynikow" value="/home/pawel/as_2013/altershop_pl_2014/koszulki/wyniki_nowy_podklad_imagic/"  size="100"/></p>
            <p><label for="stala_y">stala y - wysokosc wzoru</label>
                <input type="text" name="stala_y" value="130" size="5" /></p>
            <p><label for="punkt_x">punkt x - nie uzywany</label>
                <input type="text" name="punkt_x" value="100" size="5" /></p>
            <p><input type="submit" value="potwierdz" name="potwierdz" /></p>
        </form>
    </body>
</html>
