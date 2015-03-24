<?php


include_once ('functions.php');
echo ('<p>wywolany plik imagic.php</p>');

$plik_podklad=$_POST['plik_podklad'];
$plik_podpis=$_POST['plik_podpis'];
$sciezka_wzorow=$_POST['sciezka_wzorow'];
$sciezka_tylow=$_POST['sciezka_tylow'];

$sciezka_wynikow=$_POST['sciezka_wynikow'];
$punkt_x=$_POST['punkt_x'];
$stala_y=$_POST['stala_y'];

var_dump($_POST);
var_dump($_FILES);

$podklad_kr_alter=wczytaj_podklad_imagic($plik_podklad); // wczytuje pierwszy raz zeby pobrac tylko raz parametry do dalszych obliczen
$logo_podpis=wczytaj_logo_podpis_imagic($plik_podpis);
//$szer_podkl=$podklad_kr_alter->getImageWidth();
//$wys_podkl=$podklad_kr_alter->getImageHeight();
$szer_podpis=get_szer_imagic($logo_podpis);
$wys_podpis=get_wys_imagic($logo_podpis);
// sprawdzanie reczne zamieniam na uniwersalne funkcje
$szer_podkl=get_szer_imagic($podklad_kr_alter);  
$wys_podkl=get_wys_imagic($podklad_kr_alter);

echo ('<p> wys podkl:'.$wys_podkl.'szer podkl:'.$szer_podkl.'</p>');
        
$wynik_sciezka= utworz_sciezke_wynikow($sciezka_wynikow,0777);
echo('<p>wynik sciezka:'.$wynik_sciezka.'</p>');

// ta funkcja malo przydatna, ale napisana dla sprawdzenia przekazywania wynikow funkci w tablicy
//var_dump (( get_parametry_podkladu($podklad_kr_alter)));
//$tab_param_podkladu=get_parametry_podkladu($podklad_kr_alter);

//dopisuje pojedyncze proste funkcje dla imagic - pob szerokosc i pob wys

var_dump (( wczytaj_do_tablicy_pliki_wzorow($sciezka_wzorow)));
$tab_plikow_wzorow=wczytaj_do_tablicy_pliki_wzorow($sciezka_wzorow);

//echo('tablica TYLOW <br>');
//var_dump(wczytaj_do_tablicy_pliki_tylow($sciezka_tylow));
//$tab_plikow_tylow=wczytaj_do_tablicy_pliki_tylow($sciezka_tylow);


//var_dump ($tab_imagic_wzorow=tab_plikow_na_tab_imagic($tab_plikow_wzorow,$sciezka_wzorow ));
$tab_imagic_wzorow=tab_plikow_na_tab_imagic($tab_plikow_wzorow,$sciezka_wzorow );
//$wz1=new Imagick( $sciezka_wzorow.'/'.$tab_plikow_wzorow[0]  );
//$wz1=$tab_imagic_wzorow[1];
//echo $wz1->getformat();

$i=0;
foreach ($tab_imagic_wzorow as $wz_imagic)
{
   $podklad_kr_alter=wczytaj_podklad_imagic($plik_podklad); // za kazdym razem swiezy podklad, bo pozniej niszoczony
   $podklad_kr_alter=komponuj_przod($podklad_kr_alter, $wz_imagic, $szer_podkl, $stala_y); // np 350 -stala wys y
    // tu po prostu sprawdzaj cyz jest tyl i jezeli jest to komponuj i w zaleznosci od tego czy jest czy nie ma tylu inaczej
   //umieszczaj logo altershop
   // echo basename($wz_imagic->getimagefilename() );
    $nazwa_tyl=set_nazwa_tyl($tab_plikow_wzorow[$i]);
    //sprawdz czy jest tyl
    $tyl=sprawdz_tyl($sciezka_tylow.$nazwa_tyl);
    if (is_object ($tyl))
        {
         echo("<p>jestem obiektem tylu</p>");
         $podklad_kr_alter=komponuj_tyl($podklad_kr_alter, $tyl, $wys_podkl, $szer_podkl,'TYŁ','#0f0f0f'); // //niebieskie #1e2076, granatowe #0f1030, czarne #0f0f0f,
         
         // $podklad_kr_alter=komponuj_logo($podklad_kr_alter, $logo_podpis, $szer_podkl-$szer_podpis-10, 5);
         //dla bluz z kapturem na dole po lewej
            $podklad_kr_alter=komponuj_logo($podklad_kr_alter, $logo_podpis, 25, 460);
        }
        else {
            $podklad_kr_alter=komponuj_logo($podklad_kr_alter, $logo_podpis, $szer_podkl-$szer_podpis-30, $wys_podkl-$wys_podpis-18);
        }
   
   
   
   $poprawna_nazwa=ustaw_nowa_poprawna_nazwa($tab_plikow_wzorow[$i]);
   $podpis_txt=gen_txt_podpisu($poprawna_nazwa);
   $x_pod=5;
   $y_pod=15;
   $podklad_kr_alter=komponuj_podpis($podklad_kr_alter, $podpis_txt, $x_pod, $y_pod,'black');
   //$podklad_kr_alter->writeImage($sciezka_wynikow.zmien_rozszerzenie($tab_plikow_wzorow[$i],jpg)); 
   
   $podklad_kr_alter->writeImage($sciezka_wynikow.$poprawna_nazwa); 
    $podklad_kr_alter->removeImage(); 
   $i++;
   echo $i;
 //echo '<p>'.$sciezka_wynikow.$wz_imagic->.'</p';
   
}
// $podklad_kr_alter->compositeImage($wz1,$wz1->getImageCompose(),$punkt_x,$punkt_y); //narzucenie wzoru

/* $podklad_kr_alter->setImageFormat( "jpg" );  
$podklad_kr_alter->setImageCompressionQuality(90); */



//$podklad_kr_alter->removeImage();  	
        
// $koszulka_alter->compositeImage($rek,$rek->getImageCompose(),$punkt_x_rek, $pinkt_y_rek);}       
    

echo ('<p>koniec wywolwania pliku imagic.php</p>');



?>