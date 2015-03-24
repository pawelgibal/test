<?php

function wczytaj_podklad ($ściezka_podklad) {
    if (!FALSE == file_exists($ściezka_podklad))
    {
       // $podklad=file_get_contents($ściezka_podklad);
        $podklad=($ściezka_podklad);
        return $podklad;
    }
    else
    {
        echo ('brak podkladu<br>');
    }
}
function wczytaj_podklad_imagic ($ściezka_podklad) {
    if (!FALSE == file_exists($ściezka_podklad))
    {
        $podklad=new Imagick($ściezka_podklad);
        return $podklad;
    }
    else
    {
        echo ('brak podkladu<br>');
    }
}

function get_parametry_podkladu ($objekt_podklad)
{
    $sciezka=$objekt_podklad->getImageFilename();
    $image_szer=$objekt_podklad->getImageWidth();
    $image_wys=$objekt_podklad->getImageHeight();
    $nazwa=basename( $objekt_podklad->getImageFilename() );
    return array ("sc"=>$sciezka, "sze"=>$image_szer, "wys"=>$image_wys,"nazwa"=>$nazwa );
    
}
function get_szer_imagic ($objekt_imagic)
{
    $image_szer=$objekt_imagic->getImageWidth();
    return $image_szer;
}

function get_wys_imagic ($objekt_imagic)
{
    $image_wys=$objekt_imagic->getImageHeight();
    return $image_wys ;
}


function wyswietl_grafike ($grafika) {
      //  echo ('<p>jakis tekst i wartosc zmiennej'.$grafika.' </p>');
      //file_get_contents($filename)
         echo ('<img src="'.($grafika).'" alt="grafika" />' );
    }
function utworz_sciezke_wynikow ($sciezka_wynikow, $uprawnienia=0777 )  {
      if  (is_dir($sciezka_wynikow))
      { 
          //chown($sciezka_wynikow, $uzytkownik );
          return;    
      }
      else 
      {   
          mkdir($sciezka_wynikow, $uprawnienia,1);
          //chown($sciezka_wynikow, $uzytkownik );
          return; 
      }
}
function wczytaj_do_tablicy_pliki_wzorow($sciezka_wz) {
    if ($handle = opendir($sciezka_wz)) {

// OD tego miejca dzialamy w petli 

      while (false !== ($file = readdir($handle)))
       {  // 
            if(is_file("$sciezka_wz/$file"))
             {   //

            $i=$i+1;
            $tablica_wz[$i] = $file;

             }
	    else {
		// echo($zrodlo.$file."-NIE jestem plikiem<br>");
	         }
       } // koniec do czytania katalogu while
    
	if ($tablica_wz !== NULL) 
            { 	       // domyslne sortowanie tablicy
            sort($tablica_wz);
            return $tablica_wz;
             }
             else 
                {
                 return 'PUSTY KATALOG wzorow ?';    
                 }
    }
} // koniec funkfi wczyt_do_tab_pl_wz

function sprawdz_tyl($sciezka_tylu)
{
    if (!FALSE == file_exists($sciezka_tylu))
    {
        $tyl=new Imagick($sciezka_tylu);
        return $tyl;
    }
    else
    {
        echo ('brak tylu<br>');
    }
}  // koniec to funkcji sprawdz tyl


 function zmien_rozszerzenie ($nazwa_pliku, $rozszerzenie)
{
    $nazwa_pliku=substr($nazwa_pliku,0, -3).$rozszerzenie;
    echo('nowa nazwa:'.$nazwa_pliku);
    return $nazwa_pliku;
}

function tab_plikow_na_tab_imagic ($tab_plikow, $sc_wz)
{
    foreach ($tab_plikow as $key=> $plik)
    {
        // echo('<p>'.$plik.'</p>');
        $tab_imagic[]=new Imagick( $sc_wz.$plik  );
    }
    return $tab_imagic;
}
function oblicz_punkt_nalozenia_x($szer_podkladu, $image_szer)
{
    $punkt_x=($szer_podkladu/2)-($image_szer/2);
    echo('punktx:'.$punkt_x);
	return $punkt_x;		
			
}
function oblicz_punkt_nalozenia_y($stala_y,$image_wys)
{
    $punkt_y=$stala_y-((($image_wys/2)/2)/2);
    echo('punkty:'.$punkt_y);
     return $punkt_y;
}

function set_draw ($fontsize,$kolor)
    {
         $draw = new ImagickDraw();

	/*** set the font ***/
	$draw->setFont('Helvetica');
	$draw->setFillColor($kolor);
	/*** set the font size ***/
	$draw->setFontSize( $fontsize );
	$draw->setFontWeight(900);
        
        return $draw;
    }      
 
    
function komponuj_podpis ($podklad, $podpis_txt,$x_pod, $y_pod, $kolor)
    {
      $draw=set_draw(18,$kolor);
      $podklad->annotateImage($draw, $x_pod, $y_pod, 0, $podpis_txt);
      
      return $podklad;
    }   
    
function komponuj_przod ($podklad, $przod, $szer_podkladu, $st_wys_y)
{
    // $x, $y przekazuje szer i wysokosc podkladu
    // wys i szer podkladu przekaze w funkcji bo sa to stale dane
    // wys i szer nakladanej grafiki pobierana na bierzaco
    $wys_przod=$przod->getImageHeight();
    $szer_przod=$przod->getImageWidth();
    echo ('<p> wys:'.$wys_przod.'szer:'.$szer_przod.'</p>');
    
    $podklad->compositeImage($przod,$przod->getImageCompose(),oblicz_punkt_nalozenia_x($szer_podkladu, $szer_przod),oblicz_punkt_nalozenia_y($st_wys_y,$wys_przod)); //narzucenie wzoru
    $podklad->setImageFormat( "png" );  
    
    //$podklad->setImageCompressionQuality(95);
    return $podklad;
}
function komponuj_tyl ($podklad_kr,$tyl,$wys_podst,$szer_podst,$txt_tyl,$podklad_tyl_kolor)
{
    
	// parametry  tylu
	$tyl_szer=$tyl->getImageWidth();
	echo("szerokosc tylu:".$tyl_szer."<br>");
			
	$tyl_wys=$tyl->getImageHeight();
	echo("wysokosc tylu:".$tyl_wys."<br>");
	$podklad_tyl = new Imagick();		
	//$podklad_tyl->newImage($tyl_szer+30, $tyl_wys+50, new ImagickPixel('#0f0f0f'));  //niebieskie #1e2076, granatowe #0f1030, czarne #0f0f0f, biale #dedede nowy obraz tylu odp do wielkosci napisu
        $podklad_tyl->newImage($tyl_szer+30, $tyl_wys+50, new ImagickPixel($podklad_tyl_kolor));
	$punkt_x_podklad=$szer_podst-$tyl_szer-30-10;
	$punkt_y_podklad=$wys_podst-$tyl_wys-25-35 ;
        
        $punkt_x_tyl=$punkt_x_podklad+15;
        $punkt_y_tyl=$punkt_y_podklad+25;
        
        $punk_xntyl=$punkt_x_podklad+$tyl_szer-30;
	$punkt_yntyl=$punkt_y_podklad+15;
        
        //$napis_tyl='BACK';
        $napis_tyl=$txt_tyl;
        
        
         // podklad pod tyl
                       
	$podklad_kr->compositeImage($podklad_tyl,$podklad_tyl->getImageCompose(), $punkt_x_podklad, $punkt_y_podklad); 
                        // umieszczenie tylu na podkladnie
	$podklad_kr->compositeImage($tyl,$tyl->getImageCompose(), $punkt_x_tyl,$punkt_y_tyl);
        
        $podklad_kr=komponuj_podpis ($podklad_kr,$napis_tyl,$punk_xntyl,$punkt_yntyl, 'white');
       // komponuj_podpis ($podklad_kr,$napis_tyl,$punk_xntyl,$punkt_yntyl, $kolor)
        
        return $podklad_kr;
}    
function komponuj_logo ($podklad, $logo,$x_logo, $y_logo)
    {
      $podklad->compositeImage($logo,$logo->getImageCompose(),$x_logo,$y_logo); //narzucenie podpisu np altershop
      return $podklad;
    }


    
function wczytaj_logo_podpis_imagic ($sciezka_logo)
{
     if (!FALSE == file_exists($sciezka_logo))
    {
        $logo_p=new Imagick($sciezka_logo);
        return $logo_p;
    }
    else
    {
        echo ('brak podkladu<br>');
    }
//$logo_p==new Imagick($sciezka_logo);
   // return $logo_p;
}   
function gen_txt_podpisu ($nazwa_pliku)
{
    $nazwa_pliku=substr($nazwa_pliku,0,-4); // obeciecie rozszerzenia
    //$nazwa_pliku=str_replace("_"," ",$nazwa_pliku);
    $nazwa_pliku=strtoupper(strtolower($nazwa_pliku));
		//$text=substr($text,0,5)."_".$numer;
    //$cz=substr($string, $start, $length)
    
    $cz1=substr($nazwa_pliku,0,4); // pierwsze cztery znaki
    if ($cz1==='THE_' )
    {
    $cz1=substr($nazwa_pliku,4,4); // pomin przedrostek the_ i wczytaj dalsza czesc   
    }
    
    if (substr($cz1,3,1)==='0' )// dla nazwy  wzoru krotszej niz 4 np U2_ we 
    { 
        echo 'na pozycji 3 jest 0<br>'.substr($cz1,3,1);
        $cz1=substr($nazwa_pliku,0,2);
    }
     if (substr($cz1,4,1)==='0' )// dla nazwy  wzoru krotszej niz 4 np U2_ we 
    { 
        echo 'na pozycji 4 jest 0<br>'.substr($cz1,4,1);
        $cz1=substr($nazwa_pliku,0,3);
    }
    
    $cz2=substr($nazwa_pliku, (strlen($nazwa_pliku)-10),(strlen($nazwa_pliku))) ;
		//$text=substr($text,0,5)."_".$numer;	
     echo('cz1i2:'.$cz1.$cz2.'<br>');
    return $cz1.$cz2;
    
}
function set_nazwa_tyl ($nazwa_pliku)
{
    $przod=substr($nazwa_pliku,0,-4);
    $tyl="_tyl";
    $rozsz= substr($nazwa_pliku, (strlen($nazwa_pliku)-4),(strlen($nazwa_pliku))) ;   
    echo('nazwa_tyl'.$przod.$tyl.$rozsz.'<br>');
    return $przod.$tyl.$rozsz;
}


function ustaw_nowa_poprawna_nazwa ($surowa_nazwa_pliku)
{
    $numer=substr($surowa_nazwa_pliku,(strlen($surowa_nazwa_pliku)-13),2);
    echo(' numer:'.$numer.'');
    //zachowanie koncowki typu _kr_bla
    $tyl=substr($surowa_nazwa_pliku,(strlen($surowa_nazwa_pliku)-11),11);
    echo(' tyl:'.$tyl.'');
    
	if (substr($numer,0,1)=="_")
	{
	$numer=substr($numer,1,1);
	$numer="0".$numer;
	$surowa_nazwa_pliku=substr($surowa_nazwa_pliku,0,-12);   //usuniecie starego numeru
	}
	else {
	$surowa_nazwa_pliku=substr($surowa_nazwa_pliku,0,-13);   //usuniecie starego numeru
	}
       $surowa_nazwa_pliku=$surowa_nazwa_pliku.$numer.$tyl; // zlozenie calej nazwy z poprawnych elementow
        echo(' cala now nazwa:'.$surowa_nazwa_pliku.'<br>');
        return  $surowa_nazwa_pliku;
}

    ?>