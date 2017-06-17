<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' href='math.css' type='text/css' />

<?php
    /**
     * Created by PhpStorm.
     * User: senator
     * Date: 30/05/2017
     * Time: 11:35 AM
     */

    include "matrice.class.php";
    include "pca.class.php";
    $matrice= new matrice();

    $mat = $_GET["mat"];
    $mat=$matrice->str2mat($mat);

    $pca= new pca($mat);

    echo "<h3>مقادیر زیر را با روش پی سی ای، کاهش ابعاد دهید</h3>";
    echo $pca->drawInit() ."<br/>";

    echo "<hr/><h3>مرحله اول: محاسبه میانگین ماتریس</h3>";
    echo "mio= ". $matrice->drawMio($mat). "<br/>";

    echo "<hr/><h3>مرحله دوم: محاسبه ماتریس کواریانس</h3>";

    $cov= $matrice->cov($mat) ;
    echo $cov[1];

    echo "<hr/><h3>مرحله سوم: کشف مقادیر لاندا</h3>";
    echo "Cov - λI = 0 <br/><br/>";

    echo $matrice->draw($cov[0])." - λ * ". $matrice->draw([[1,0],[0,1]]) . " = 0 <br/><br/>";

    $matLanda[0][0]= $cov[0][0][0] ."- λ";
    $matLanda[0][1]= $cov[0][0][1] ;
    $matLanda[1][0]= $cov[0][1][0] ;
    $matLanda[1][1]= $cov[0][1][1] ."- λ";

    echo $matrice->draw($matLanda) . " = 0<br/><br/> => &nbsp;&nbsp;&nbsp;". " ( ". $matLanda[0][0]. " ) * ( ". $matLanda[1][1] ." ) - ( " . $matLanda[0][1] . " * " .   $matLanda[1][0] ." ) = 0 <br/> <br/>" ;

    $landa= $pca ->moadeleDaraje2($cov[0]);
    echo $landa[2];

    echo "<hr/><h3>مرحله چهارم: کشف فی</h3>";
    echo "Cov * Φ = λ<sub>i</sub> * Φ <br/><br/>";

    ;
    $phi=$pca ->phi($cov, [$landa[0] ,$landa[1]]);

    echo $phi[1];

