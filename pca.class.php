<?php

    /**
     * Created by PhpStorm.
     * User: senator
     * Date: 30/05/2017
     * Time: 11:01 AM
     */
    class pca extends matrice
    {
        private $mat;

        public function __construct($mat)
        {

            $this->mat = $mat;

        }

        public  function drawInit()
        {
            $mat=$this->mat;
            $rows=count($mat);
            $columns=count($mat[0]);
$out="";
            for ($i=0; $i<$columns; $i++)
            {
                $out.=" x[" . ($i+1) ."]= ";
                $temp  =null;
                for($j=0; $j<$rows; $j++){
                    $temp[]+= $mat[$j][$i];
                }
                //$temp[$j]=$this->transpose($temp);

                $out.= $this  ->drawMat($temp). "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }

            return $out;

        }

        private function drawMat($mat)
        {
            $out="<table cellpadding='0' cellspacing='0' class='matrixbrak fraction'>
                    <tr>
                        <td class='lbrak'>&nbsp;</td>
                        <td>
                            <table cellpadding='0' cellspacing='0' class='matrix' >\n";


            foreach($mat as $rows)
            {
                $out.="<tr><td><i>$rows</i></td></tr> ";
            }



            $out.= "                
                                </table>\n
                            </td>
                            <td class='rbrak'>&nbsp;</td>
                        </tr>
                    </table>\n";

            return $out;

        }

        public function moadeleDaraje2($cov)
        {


            $a= $cov[0][0];
            $b= $cov[0][1];
            $c= $cov[1][0];
            $d= $cov[1][1];

            $ad=$a * $d;
            $adOpt="";
            if($ad>=0)
                $adOpt="+";

            $aLandaOpt="+";
            if($a>=0) {
                $aLandaOpt = "-";

            }

            $dLandaOpt="+";
            if($d>=0)
                $dLandaOpt="-";

            $bc=$b * $c;
            $bcOpt="";
            if($bc>=0)
                $bcOpt="+";

            $bcNegetive= -1* $bc;
            $bcNegetiveOpt="";
            if($bcNegetive>=0)
                $bcNegetiveOpt="+";

            $out= "λ<sup>2</sup> + ( $a * $d ) + ( $a * -λ ) + ( $d * -λ ) - ( $b * $c ) = 0 <br/> <br/>";

            $out.= "λ<sup>2</sup> $adOpt $ad $aLandaOpt ".$a."λ $dLandaOpt ".$d. "λ $bcNegetiveOpt $bcNegetive = 0 <br/> <br/>";


            $aNew=-1* $a;
            $dNew=-1* $d;

            $adSum=$aNew+$dNew;

            $adSumOpt="";
            if($adSum>=0)
                $adSumOpt="+";

            $adSumBc=$ad + $bcNegetive;
            if($adSumBc>=0)
                $adSumBcOpt="+";

            $out.= "λ<sup>2</sup>  $adSumOpt $adSum λ $adSumBcOpt $adSumBc = 0 <br/><br/>";
            $delta=$adSum *$adSum - 4*$adSumBc;
            $out.= "Δ = b<sup>2</sup> - 4ac => &nbsp; &nbsp; ($adSum)<sup>2</sup> - (4 * 1 * $adSumBc) = $delta<br/> <br/>";

            $adSumNegetaive=-1*$adSum;


            $sqrDelta= sqrt($delta);

            $landa1=($adSumNegetaive -  $sqrDelta) / 2;
            $out.= "λ1 = (-b - √Δ)/2a => &nbsp; &nbsp; ( $adSumNegetaive - √$delta ) / ( 2 * 1 ) = $landa1 <br/> <br/>";

            $landa2=($adSumNegetaive +  $sqrDelta) / 2;
            $out.= "λ2 = (-b + √Δ)/2a => &nbsp; &nbsp; ( $adSumNegetaive + √$delta ) / ( 2 * 1 ) = $landa2<br/> <br/>";
            $result=[$landa1, $landa2, $out];
            return $result;
        }

        public function phi($cov, $landa){
            $out="";
            $phi=$this-> drawMat(["Φ<sub>1</sub>", "Φ<sub>2</sub>"]);
            $covMat[0][0]=$cov[0][0][0];
            $covMat[0][1]=$cov[0][0][1] ;
            $covMat[1][0]=$cov[0][1][0];
            $covMat[1][1]=$cov[0][1][1];

            $optQ1= "";
            if($covMat[0][1]>0)
                $optQ1= "+";

            $optQ2= "";
            if($covMat[1][1]>0)
                $optQ2= "+";

            $covDraw=parent::draw($covMat);

            foreach($landa as $rows) {

                $out.=$covDraw . " * " .  $phi ." = $rows * ". $phi . "<br/><br/>";

                $out.= $covMat[0][0] . "Φ<sub>1</sub> $optQ1 ". $covMat[0][1] . "Φ<sub>2</sub> = $rows Φ<sub>1</sub>  => &nbsp; &nbsp; &nbsp; ".($covMat[0][0] - $rows) ."Φ<sub>1</sub> = ". $covMat[0][1] * -1  . " Φ<sub>2</sub> <br/><br/>";
                $out.= $covMat[1][0] . "Φ<sub>1</sub> $optQ2 ". $covMat[1][1] . "Φ<sub>2</sub> = $rows Φ<sub>2</sub>  => &nbsp; &nbsp; &nbsp; ".$covMat[1][0]  ."Φ<sub>1</sub> = ". ( $rows + ($covMat[1][1] * -1))  . " Φ<sub>2</sub> <br/><br/>";

                $out.="<br/><br/><br/><br/>";

            }

            $temp[1]=$out;
            return $temp;

        }


    }