<?php

/*class classname extends anotherClass{
    function __construct(argument){
        // code...
    }
}
tipo_de_Dato Nombre(Parametros){
    //code


    SEGURIDAD
    1)TODA APLICACION DEBE TENER USUARIO Y CONTRASEÑA
    2)DEBES EVITAR INYECCION DE CODIGO
    3)NADIE PUEDE VER LA CONTRASEÑA(UTILIZAREMOS (PASSWORD COMO ENCRIPTACION Y SERA 41) Y  AMD5 32)
}


class baseDatos {
    var $a_conexion;
    var $a_numRegistros;
    var $a_error = false;
    var $a_registros;
    function m_conecta(){
        $this->a_conexion = mysqli_connect("localhost","root","","dentart");    
    }

    function m_desconecta(){
        mysqli_close($this->a_conexion);
    }

    function m_query($pQuery){
        $this->m_conecta();
        $this->a_error = false;
        $this->a_registros =  mysqli_query($this->a_conexion, $pQuery);
        if (mysqli_error($this->a_conexion)>""){
            $this->a_error = true;
        }
        if(strpos(strtoupper($pQuery), "SELECT") !== false){
            $this->a_numRegistros = mysqli_num_rows($this->a_registros);
        }
        $this->m_desconecta();
    }

    function m_obtenerRegistro($query){
        $this -> m_query($query);
        return mysqli_fetch_array($this->a_registros);
    }

    function m_recuRegistro(){
        return mysqli_fetch_array($this->a_registros);
    }
    function m_crearLista($tabla,$PK,$nombCampo,$ordenarPor,$seleccionado=-1){
        
        $cad = "Select ".$PK.", ".$ordenarPor." from ".$tabla." order by ".$ordenarPor;"";
        $this->m_query($cad);
        $result = '<select id="'.$PK.'" class="form-control" name="'.$PK.'">';
        foreach ($this->a_registros as $row ) {
            $result .= '<option id="'.$row[$PK].'" '.(($row[$PK]==$seleccionado)?"selected":"").' name"'.$tabla.'" value="'.$row[$PK].'">'.$row[$nombCampo].'</option>';
            //$result.='<input type="hidden" name="id_Servicio" value="'.$row[$PK].'" />';
        }
        $result .= '</select>';
        return $result;
    }
}
$oDB = new baseDatos();*/
class BaseDatos {
    private $conexion;
    var $a_numRegistros;
    private $error = false;
    private $registros;

    public function m_conecta() {
        $host = "localhost";
        $usuario = "root";
        $clave = "";
        $baseDatos = "dentart";

        $dsn = "mysql:host=$host;dbname=$baseDatos;charset=utf8";

        try {
            $this->conexion = new PDO($dsn, $usuario, $clave);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            die();
        }
    }

    public function m_desconecta() {
        $this->conexion = null;
    }

    public function m_query($pQuery) {
        $this->m_conecta();
        $this->error = false;

        try {
            $this->registros = $this->conexion->query($pQuery);

            if ($this->conexion->errorCode() != '00000') {
                $this->error = true;
            }

            if (strpos(strtoupper($pQuery), "SELECT") !== false) {
                $this->a_numRegistros = $this->registros->rowCount();
            }
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
            $this->error = true;
        }

        $this->m_desconecta();
    }

    public function m_obtenerRegistro($query) {
        $this->m_query($query);
        return $this->registros->fetch(PDO::FETCH_ASSOC);
    }
    

    public function m_recuRegistro() {
        return $this->registros->fetch(PDO::FETCH_ASSOC);
    }

    public function m_crearLista($tabla, $PK, $nombCampo, $ordenarPor, $seleccionado = -1) {
        $cad = "SELECT $PK, $ordenarPor FROM $tabla ORDER BY $ordenarPor";
        $this->m_query($cad);

        $result = '<select id="'.$PK.'" class="form-control" name="'.$PK.'">';
        foreach ($this->registros as $row) {
            $result .= '<option id="'.$row[$PK].'" '.(($row[$PK] == $seleccionado) ? "selected" : "").' name"'.$tabla.'" value="'.$row[$PK].'">'.$row[$nombCampo].'</option>';
        }
        $result .= '</select>';

        return $result;
    }
}

$oDB = new BaseDatos();
?>