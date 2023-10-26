<?php
function captcha(){
    $v1 = rand()%9+1;
    $v2 = rand()%9+1;
    $v3 = rand()%9+1;
    $op = rand()%3;
    $calculo = 0;
    $cadena = $v1;
    if($op==0){
        $calculo = $v1 + $v2;
        $cadena.=" + ".$v2;
    }else{
    if($op==1){
        $calculo = $v1 * $v2;
        $cadena.=" * ".$v2;
    }else{
        if($op==2){
            $calculo = $v1 - $v2;
            $cadena.=" - ".$v2;
        }
    }
    }
    $op = rand()%3;
    if($op==0){
        $calculo += $v3;
        $cadena.=" + ".$v3;
    }else{
        if($op==1){
            $calculo *= $v3;
            $cadena.=" * ".$v3;
        }else{
            if($op==2){
                $calculo -= $v3;
                $cadena.=" - ".$v3;
            }
        }
    }
    $_SESSION['captcha'] = $calculo;
    return $cadena;
}
$cadena=captcha();
?>