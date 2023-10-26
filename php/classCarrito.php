<?php
session_start();
include "../php/classBaseDeDatos.php";

class Carrito extends baseDatos{
    function ejecuta($accion){
        $html = '';
        switch ($accion){
            case 'insert':
                //print_r($_POST);
                $cad="SELECT * FROM carrito C JOIN productos P ON P.id=C.idProducto WHERE C.idProducto='".$_POST['id']."' AND C.idUsuario='".$_POST['id_Usuario']."';";
                $row=$this->m_obtenerRegistro($cad);
                $con=$this->a_numRegistros;
                $cantidadProdComprome = $this->m_obtenerRegistro("SELECT * FROM productos WHERE id='".$_POST['id']."';");
                $cantidadCar = $row['cantidad']+$_POST['cantidad'];
                $cantidadStock=$row['unidades_en_stock']-$cantidadCar+$cantidadProdComprome['unidades_comprometidas'];
                //print_r($this->a_numRegistros);
                if($con==1){
                    if (isset($_SESSION['admin'])) {
                        $cad2="UPDATE productos SET unidades_en_stock = '".$cantidadStock."', unidades_comprometidas=".$cantidadCar." WHERE id = ".$_POST['id'].";";
                        $this->m_query($cad2);
                        $cad="UPDATE carrito SET cantidad = '".$cantidadCar."' WHERE carrito.id = ".$row['id'].";";
                        $this->m_query($cad);
                        $html = $this->listar();
                    }else{
                        //print_r($_POST);
                        $cad2="UPDATE productos SET unidades_en_stock = '".$cantidadStock."', unidades_comprometidas=".$cantidadCar." WHERE id = ".$_POST['id'].";";
                        $this->m_query($cad2);
                        $cad="UPDATE carrito SET cantidad = ".$cantidadCar." WHERE idProducto = ".$_POST['id']." AND idUsuario = ".$_SESSION['id_Usuario'].";";
                        //print_r($cad);
                        $this->m_query($cad);
                    }
                }else{
                    $cad="INSERT INTO carrito (idProducto, idUsuario, cantidad) VALUES ('".$_POST["id"]."', '".$_SESSION["id_Usuario"]."', '".$_POST["cantidad"]."');";
                    $this->m_query($cad);
                    //print_r($cad);
                    $cad2="UPDATE productos SET unidades_en_stock = ".$cantidadStock.", unidades_comprometidas=".$cantidadCar." WHERE id = ".$_SESSION['id_Usuario'].";";
                    $this->m_query($cad2);
                    //print_r($cad2);
                    if(isset($_SESSION['admin'])){
                        $html = $this->listar();
                    }
                }
            break;
            case 'update':
                $cad="SELECT * FROM carrito C JOIN productos P ON P.id=C.idProducto WHERE C.id=".$_POST['idCarrito'].";";
                $row=$this->m_obtenerRegistro($cad);
                    $cantidadProdComprome = $this->m_obtenerRegistro("SELECT * FROM productos WHERE id='".$_POST['idCarrito']."';");
                    $cantidadCar = $row['cantidad']+$_POST['cantidad'];
                    $cantidadStock=$row['unidades_en_stock']-$cantidadCar+$cantidadProdComprome['unidades_comprometidas'];

                    if (isset($_SESSION['admin'])) {
                        $cad2="UPDATE productos SET unidades_en_stock = ".$cantidadStock.", unidades_comprometidas=".$cantidadCar." WHERE id = ".$_POST['idCarrito'].";";
                        $this->m_query($cad2);
                        $cad="UPDATE carrito SET cantidad = '".$_POST['cantidad']."' WHERE carrito.id = ".$_POST['idCarrito'].";";
                        $this->m_query($cad);
                        $html = $this->listar();
                    }else{
                        $cad2="UPDATE productos SET unidades_en_stock = ".$cantidadStock.", unidades_comprometidas=".$cantidadCar." WHERE id = ".$_SESSION['idCarrito'].";";
                        $this->m_query($cad2);
                        $cad="UPDATE carrito SET cantidad = '".$_POST['cantidad']."' WHERE id = ".$_POST['idCarrito'].";";
                        $this->m_query($cad);
                    }
                $html = $this->listar();
            break;
            case 'delete':
                //print_r($_POST);
                $this->m_query("DELETE FROM Carrito where id =".$_POST['id']);
                $html = $this->listar();
            break;
            case 'editForm':
                $cad="SELECT * from Carrito C JOIN productos P ON P.id=C.idProducto where C.id=".$_POST['id'].";";
                $registro = $this->m_obtenerRegistro($cad);
                $html.='<form method="post">
                <div class="container">';
                if (isset($registro))
                $html.='<input type="hidden" name="idCarrito" value="'.$_POST['id'].'" />';
                $html.='<div class="row">
                    <div class="">
                        <div class="form-group">
                        <label class="form-label mt-4">Carrito</label>
                            <div class="form-group">
                            <div class="input-group mb-3">
                            <span class="input-group-text">Cantidad</span>
                            <input id="cantidad" type="number" class="form-control" min="-'.$registro['cantidad'].'" max="'.$registro["unidades_en_stock"].'" name="cantidad" placeholder="Nombre de la carrito " value="'.$registro["cantidad"].'">
                        </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-4">
                <button  class="btn btn-info" >
                '.((isset($registro))? "Actualizar":"Registrar").'
                </button>
                <input type="hidden" name="accion" value="'.((isset($registro))? "update":"insert").'" />
                </div>
                </div>
                </form>';
            break;
            case 'newForm':
                $html.='<form form method="post">
                <div class="container">';
                $html.='<div class="row">
                    <div class="">
                        <div class="form-group">
                        <label class="form-label mt-4">Nuevo Carrito</label>
                        <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Cantidad</span>
                            <input  id="cantidad" type="number" class="form-control" min="1" max="1" name="cantidad" placeholder="Cantidad" value="1">
                        </div> 
                        </div>
                        <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Usuario</span>'.$this->m_crearLista('usuario','id_Usuario','Nombre','Nombre').'
                        </div> 
                        </div>
                        <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Producto</span>'.$this->m_crearLista('productos','id','nombre','nombre').'
                        </div> 
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-4">
                <button  class="btn btn-info" >
                '.((isset($registro))? "Actualizar":"Registrar").'
                </button>
                <input type="hidden" name="accion" value="'.((isset($registro))? "update":"insert").'" />
                </div>
                </div>
                </form>';
                break;
            case 'list':
                $html = $this->listar();
                break;
            default:
                $html.= $_REQUEST['accion']." Accion no programada";
            break;
        }
            return $html;
    }


    function listar(){
        $res = '<div class="container"><div class="row"><table border="1" class="table table-hover">';
        //Cabecera
        $res.= '<tr>
        <td colspan="1">';
        if(isset($_SESSION['admin'])){
            $res.='<form method="post">
            <input type="hidden" name="accion" value = "newForm"/>
            <input type="hidden" name="id" value =""/>
            <input type="image" width="35px" src="../img/agregar.png"/>
            </form>';
        }
        $res.='</td><th>Eliminar</th><th>Id</th><th>Producto</th><th>Usuario</th><th>Cantidad</th></tr>';
        //Fin de cabezera
        if($_SESSION['admin']){
            $this->m_query("SELECT * FROM  productos P JOIN Carrito C ON P.id=C.idProducto JOIN usuario U ON C.idUsuario=U.id_Usuario");
            for($i = 0; $i < $this->a_numRegistros; $i++){
            $tupla = $this->m_recuRegistro();
            //print_r($tupla);
            $res.='<tr class="table-prymari"><td>
            <form method="post">
            <input type="hidden" name="accion" value = "editForm"/>
            <input type="hidden" name="id" value ="'.$tupla["id"].'"/>
            <input type="image" width="35px" src="../img/edit.png"/>
            </form>
            </td>
            <td>
            <form method="post">
            <input type="hidden" name="accion" value = "delete"/>
            <input type="hidden" name="id" value ="'.$tupla["id"].'"/>
            <input type="image" width="35px" src="../img/basura.png"/>
            </form>
            </td>
            <td>'.$tupla["id"].'</td>
            <td>'.$tupla['nombre'].'</td>
            <td>'.$tupla['Nombre'].'</td>
            <td>'.$tupla["cantidad"].'</td></tr>';
        }
    }else{
        $this->m_query("SELECT * FROM productos P JOIN Carrito C ON P.id=C.idProducto JOIN usuario U ON C.idUsuario=U.id_Usuario WHERE U.id_Usuario=".$_SESSION['id_Usuario']);
        for($i = 0; $i < $this->a_numRegistros; $i++){
            $tupla = $this->m_recuRegistro();
            //print_r($tupla);
            $res.='<tr class="table-prymari"><td>
            <form method="post">
            <input type="hidden" name="accion" value = "editForm"/>
            <input type="hidden" name="id" value ="'.$tupla["id"].'"/>
            <input type="image" width="35px" src="../img/edit.png"/>
            </form>
            </td>
            <td>
            <form method="post">
            <input type="hidden" name="accion" value = "delete"/>
            <input type="hidden" name="id" value ="'.$tupla["id"].'"/>
            <input type="image" width="35px" src="../img/basura.png"/>
            </form>
            </td>
            <td>'.$tupla["id"].'</td>
            <td>'.$tupla['nombre'].'</td>
            <td>'.$tupla['Nombre'].'</td>
            <td>'.$tupla["cantidad"].'</td></tr>';
            }
    }
        return $res.'</table></div></div>';
    }
}

$oCarrito = new Carrito();
?>