<?php
    /**
     * Created by PhpStorm.
     * User: senator
     * Date: 29/05/2017
     * Time: 10:44 PM
     */


    class matrice
    {
        function str2mat($str)
        {
            $str = trim($str, "
");
            $str = explode("\n", $str);

            $i = 0;
            foreach ($str as $line) {

                $line = str_replace("\n", "", $line);
                $line = str_replace("\r", "", $line);
                $data[$i] = explode(" ", $line);

                $i++;
            }


            return $data;
        }

        function transpose($mat)
        {
            $rows = count($mat);
            $columns = count($mat[0]);

            for ($i = 0; $i < $rows; $i++) {


                for ($j = 0; $j < $columns; $j++) {
                    $temp[$j][$i] = $mat[$i][$j];
                }


            }

            return $temp;
        }

        function determinan($mat)
        {
            $a = $mat[0][0] * $mat[1][1] * $mat[2][2] +
                $mat[0][1] * $mat[1][2] * $mat[2][0] +
                $mat[0][2] * $mat[1][0] * $mat[2][1] -
                $mat[0][2] * $mat[1][1] * $mat[2][0] -
                $mat[0][1] * $mat[1][0] * $mat[2][2] -
                $mat[0][0] * $mat[1][2] * $mat[2][1];


            return $a;
        }

        function draw($mat)
        {
            $out = "<table cellpadding='0' cellspacing='0' class='matrixbrak fraction'>
                    <tr>
                        <td class='lbrak'>&nbsp;</td>
                        <td>
                            <table cellpadding='0' cellspacing='0' class='matrix' >\n";


            foreach ($mat as $rows) {
                $out .= "<tr>\n";
                foreach ($rows as $index => $value) {
                    $out .= "<td><i>$value</i></td> ";
                }
                $out .= "</tr>\n";
            }


            $out .= "
                                </table>\n
                            </td>
                            <td class='rbrak'>&nbsp;</td>
                        </tr>
                    </table>\n";

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

        public function mio($mat){
            //$mat=$this->mat;
            $rows=count($mat);
            $columns=count($mat[0]);

            for ($i=0; $i<$rows; $i++)
            {
                $sum=0;
                for($j=0; $j<$columns; $j++){
                    $sum+=$mat[$i][$j];
                }
                $temp[$i]=$sum / $j;
            }
            return $temp;
        }

        public function zarbMat1N($mat1,$mat2)
        {
            //var_dump($mat1);
            $temp[0][0]=$mat1[0] * $mat2[0];
            $temp[0][1]=$mat1[0] * $mat2[1];
            $temp[1][0]=$mat1[1] * $mat2[0];
            $temp[1][1]=$mat1[1] * $mat2[1];

            return $temp;
        }

        public function zarbMat2($num,$mat1)
        {
            //var_dump($mat1);
            $temp[0][0]=$mat1[0][0] * $num;
            $temp[0][1]=$mat1[0][1] * $num;
            $temp[1][0]=$mat1[1][0] * $num;
            $temp[1][1]=$mat1[1][1] * $num;

            return $temp;
        }

        public function sumMat($mat1,$mat2)
        {
            $rows = count($mat1);
            $columns = count($mat1[0]);

            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {

                    $temp[$i][$j]=$mat1[$i][$j] + $mat2[$i][$j];
                }
            }

            return $temp;
        }

        public function negetiveMat($mat1,$mat2)
        {
            $temp[0]=$mat1[0] - $mat2[0];
            $temp[1]=$mat1[1] - $mat2[1];

            return $temp;
        }

        public function drawMio($mat){
            //$mat=$this->mat;
            $rows=count($mat);
            $columns=count($mat[0]);
            $mio=$this-> mio($mat);
            for ($i=0; $i<$rows; $i++)
            {
                $out="(";
                for($j=0; $j<$columns; $j++){
                    $value=$mat[$i][$j];

                    if($value>=0){
                        if($j==0)
                            $opt="";
                        else
                            $opt="+";
                    }
                    else
                    {
                        $opt="";
                    }

                    $out.=$opt. $mat[$i][$j];
                }
                $out.=")/$columns = " . $mio[$i];
                $temp[$i]=$out;
            }

            return $this->drawMat($temp);
        }

        function cov1($mat){
            $matTranspose=$this->transpose($mat);
            $mio=$this->mio($mat);
            $rows = count($matTranspose);
          //echo $rows;

            $sum=[[0,0],[0,0]];
            for ($i = 0; $i < $rows; $i++) {
                $temp= $this->negetiveMat($matTranspose[$i], $mio);

                $temp2=$this->zarbMat1N($temp, $temp);

                //echo "<pre>";
                //var_dump($sum);
                $sum=$this->sumMat($temp2, $sum);

            }
            $temp=$this->zarbMat2((1/$rows), $sum);
            return $temp;

        }

        function cov($mat){
            $matTranspose=$this->transpose($mat);
            $mio=$this->mio($mat);
            $rows = count($matTranspose);
            //echo $rows;
$out="";
            $sum=[[0,0],[0,0]];
            for ($i = 0; $i < $rows; $i++) {
                $temp= $this->negetiveMat($matTranspose[$i], $mio);
                $out .=$this->drawMat($matTranspose[$i]) ." - " . $this->drawMat($mio) . " = " . $this->drawMat($temp) ." * [ $temp[0] &nbsp; &nbsp; $temp[1] ] => " ;

                $temp2=$this->zarbMat1N($temp, $temp);

                $out .="  &nbsp; " .  $this->draw($temp2). "  &nbsp; + \n<br/><br/>" ;

                $sum=$this->sumMat($temp2, $sum);

            }

            $temp[0]=$this->zarbMat2((1/$rows), $sum);
            $out .= "<br/>(1/$rows) * " .  $this->draw($sum) ." => Cov= " . $this->draw($temp[0]);
            $temp[1]= $out;
            return $temp;

        }

        function inverse($mat)
        {
            $rows = count($mat);
            if ($rows == 2) {
                return $this->inverse2($mat);
            } elseif ($rows == 3) {
                return $this->inverse3($mat);
            }
            return false;

        }
        private function  inverse2($mat){

            $tmp = 1 / ( $mat[0][0] * $mat[1][1] - $mat[0][1] * $mat[1][0] );

            $temp[0][0] = $tmp * $mat[1][1];
            $temp[0][1] = $tmp * -1*$mat[0][1];
            $temp[1][0] = $tmp * -1*$mat[1][0];
            $temp[1][1] = $tmp * $mat[0][0];


            return $temp;
        }

        private function inverse3($mat){
/*
            | a00 a01 a02 |-1             |   a22a11-a21a12  -(a22a01-a21a02)   a12a01-a11a02  |
            | a10 a11 a12 |    =  1/DET * | -(a22a10-a20a12)   a22a00-a20a02  -(a12a00-a10a02) |
            | a20 a21 a22 |               |   a21a10-a20a11  -(a21a00-a20a01)   a11a00-a10a01  |
*/
            if($this->determinan($mat)==0)
                $tmp=0;
            else
                $tmp= 1 / $this->determinan($mat);

            $temp[0][0] = $tmp * ( $mat[2][2] * $mat[1][1] - $mat[2][1] * $mat[1][2] );
            $temp[0][1] = $tmp * ( $mat[2][2] * $mat[0][1] - $mat[2][1] * $mat[0][2]  ) * -1;
            $temp[0][2] = $tmp * ( $mat[1][2] * $mat[0][1] - $mat[1][1] * $mat[0][2] );
            $temp[1][0] = $tmp * ( $mat[2][2] * $mat[1][0] - $mat[2][0] * $mat[1][2]  ) * -1;
            $temp[1][1] = $tmp * ( $mat[2][2] * $mat[0][0] - $mat[2][0] * $mat[0][2] );
            $temp[1][2] = $tmp * ( $mat[1][2] * $mat[0][0] - $mat[1][0] * $mat[0][2]  ) * -1;
            $temp[2][0] = $tmp * ( $mat[2][1] * $mat[1][0] - $mat[2][0] * $mat[1][1] );
            $temp[2][1] = $tmp * ( $mat[2][1] * $mat[0][0] - $mat[2][0] * $mat[0][1]  ) * -1;
            $temp[2][2] = $tmp * ( $mat[1][1] * $mat[0][0] - $mat[1][0] * $mat[0][1] );

            return $temp;
        }
    }