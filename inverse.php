<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' href='math.css' type='text/css' />

<?php
    include "matrice.class.php";
    $matrice= new matrice();

    $mat = $_GET["mat"];
    $mat=$matrice->str2mat($mat);


    $matInverse= $matrice->inverse($mat);

    echo "<h3>معکوس ماتریس</h3>";
    echo $matrice->draw($mat)  ." = ". $matrice->draw($matInverse) . "<br/>";
