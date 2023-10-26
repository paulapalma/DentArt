<?php
include "../php/classBaseDeDatos.php";

class Productos extends baseDatos{
    function ejecuta($accion){
        $rutaImagen = "../img/productos/";
        $nomFinal = "";
        $html = '';
        switch ($accion){
            case 'insert':
                //print_r($_POST);
                if($_POST['nombre']!=''&&$_POST['precio']!=''&&$_POST['unidades_en_stock']&&$_POST['puntos_reorden']!=''&&$_POST['unidades_comprometidas']!=''&&$_POST['costo']!=''&&
                is_numeric($_POST['precio'])&&is_numeric($_POST['unidades_en_stock'])&&is_numeric($_POST['puntos_reorden'])&&is_numeric($_POST['unidades_comprometidas'])&&is_numeric($_POST['costo'])){
                    if ($_FILES['img']['name']!=="") {
                        $extension = explode(".",$_FILES['img']['name']);
                        $extension = $extension[count($extension)-1];
                        $nomFinal = $_POST['id'].".".$extension;
                        move_uploaded_file($_FILES['img']['tmp_name'],$rutaImagen.$nomFinal);
                        $cad="INSERT INTO productos SET nombre ='".$_POST['nombre']."',
                         precio='".$_POST['precio']."', unidades_en_stock='".$_POST['unidades_en_stock']."',
                         puntos_reorden='".$_POST['puntos_reorden']."', unidades_comprometidas='".$_POST['unidades_comprometidas']."',
                          costo='".$_POST['costo']."', url_imagen='".$nomFinal."'";
                    }else{
                        $cad="INSERT INTO productos SET id_Usuario='".$_POST['id_Usuario']."', nombre ='".$_POST['nombre']."',
                        precio='".$_POST['precio']."', unidades_en_stock='".$_POST['unidades_en_stock']."',
                        puntos_reorden='".$_POST['puntos_reorden']."', unidades_comprometidas='".$_POST['unidades_comprometidas']."',
                         costo='".$_POST['costo']."';";
                    }
                    //print $cad;
                    $this->m_query($cad);
                    $html = $this->listar();
                }else{
                    echo '<div class="conntainer">
                        <div class="alert alert-danger" role="alert">
                        <div class="col-4">';
                        echo "Falto algun dato o algun dato esta mal";
                        echo'</div></div></div>';
                }
            break;
            case 'update':
                if($_POST['nombre']!=''&&$_POST['precio']!=''&&$_POST['unidades_en_stock']&&$_POST['puntos_reorden']!=''&&$_POST['unidades_comprometidas']!=''&&$_POST['costo']!=''&&
                is_numeric($_POST['precio'])&&is_numeric($_POST['unidades_en_stock'])&&is_numeric($_POST['puntos_reorden'])&&is_numeric($_POST['unidades_comprometidas'])&&is_numeric($_POST['costo'])){
                    if ($_FILES['img']['name']!=="") {
                        $extension = explode(".",$_FILES['img']['name']);
                        $extension = $extension[count($extension)-1];
                        $nomFinal = $_POST['id'].".".$extension;
                        move_uploaded_file($_FILES['img']['tmp_name'],$rutaImagen.$nomFinal);
                        $cad = "UPDATE productos SET nombre ='".$_POST['nombre']."', precio='".$_POST['precio']."',
                        unidades_en_stock='".$_POST['unidades_en_stock']."',puntos_reorden='".$_POST['puntos_reorden']."', unidades_comprometidas='".$_POST['unidades_comprometidas']."',
                        costo='".$_POST['costo']."', url_imagen='".$nomFinal."' where id=".$_POST['id'];
                    }else{
                    $cad = "UPDATE productos SET nombre ='".$_POST['nombre']."', precio='".$_POST['precio']."',
                    unidades_en_stock='".$_POST['unidades_en_stock']."',puntos_reorden='".$_POST['puntos_reorden']."', unidades_comprometidas='".$_POST['unidades_comprometidas']."',
                    costo='".$_POST['costo']."' where id=".$_POST['id'];
                    }
                    //print_r($_FILES);
                    //print $extension;
                    $this->m_query($cad);
                    $html=$this->listar();
                }else{
                    echo '<div class="conntainer">
                        <div class="alert alert-danger" role="alert">
                        <div class="col-4">';
                        echo "Falto algun dato o algun dato esta mal";
                        echo'</div></div></div>';
                }
            break;
            case 'delete':
                //print_r($_POST);
                $cad="SELECT * FROM carrito C JOIN productos P ON P.id=C.idProducto WHERE C.idProducto='".$_POST['id']."';";
                $this->m_obtenerRegistro($cad);
                //print_r($this->a_numRegistros);
                if($this->a_numRegistros==0){
                    $this->m_query("DELETE from productos where id =".$_POST['id']);
                }else{
                    echo "No porque esta en carrito de alguien";
                }
                $html = $this->listar();
                break;
            case 'editForm':
                $registro = $this->m_obtenerRegistro("SELECT * from productos P JOIN usuario U ON U.id_Usuario=P.id_Usuario where id=".$_POST['id']);
            case 'newForm':
                $html.='<div class="container">
                <form method="post" enctype="multipart/form-data">';
                if (isset($registro))
                $html.='<input type="hidden" name="id" value="'.$_POST['id'].'" />';
                $html.='<div class="row">
                <div class="col-4"></div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label mt-4">'.(isset($registro)?"Producto":"Nuevo Producto").'</label>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                    <input type="file" accept=".jpg,.png,.jpeg,.gif" class="form-control" name="img" placeholder="Imagen" value="">
                                    <img src="../img/productos/'.$registro['Imagen'].'" alt="" height = "36 px" class="Foto"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Producto</span>
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre del Servicio" value="'.((isset($registro))?$registro['nombre']:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Precio</span>
                                    <input type="text" class="form-control" name="precio" placeholder="Precio del producto" value="'.((isset($registro))?$registro['precio']:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Unidades en stock</span>
                                    <input type="text" class="form-control" name="unidades_en_stock" placeholder="Unidades en stock" value="'.((isset($registro))?$registro['unidades_en_stock']:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Puntos Reorden</span>
                                    <input type="text" class="form-control" name="puntos_reorden" placeholder="Puntos Reorden" value="'.((isset($registro))?$registro['puntos_reorden']:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Unidades Comprometidas</span>
                                    <input type="text" class="form-control" name="unidades_comprometidas" placeholder="Unidades Comprometidas" value="'.((isset($registro))?$registro['unidades_comprometidas']:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Costo</span>
                                    <input type="text" class="form-control" name="costo" placeholder="Costo" value="'.((isset($registro))?$registro['costo']:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                            <div class="input-group mb-3">
                            <span class="input-group-text">Vendedor</span>
                            '.$this->m_crearLista('usuario','id_Usuario','Nombre','Nombre').'
                            </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                <button  class="btn btn-info" >
                '.((isset($registro))? "Actualizar":"Registrar").'
                </button>
                <input type="hidden" name="accion" value="'.((isset($registro))? "update":"insert").'" />
                </div>
                </div>
                </form>
                </div>';
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
        <td colspan="1">
        <form method="post">
        <input type="hidden" name="accion" value="newForm">
        <input type="image" width = "35 px" src="../img/agregar.png">
        </form>
        </td>
        <th>Eliminar</th><th>Id</th><th>Producto</th><th>Vendedor</th><th>Precio de venta</th><th>Costo</th><th>Stock</th><th>Imagen</th>
        </tr>';
        //Fin de cabezera
        $this->m_query("SELECT * from productos P JOIN usuario U ON U.id_Usuario = P.id_Usuario");
        for($i = 0; $i < $this->a_numRegistros; $i++){
            $tupla = $this->m_recuRegistro();
            //print_r($tupla);
            $res.='<tr class="table-prymari">
            <td>
            <form method="post">
            <input type="hidden" name="accion" value = "editForm"/>
            <input type="hidden" name="id" value = "'.$tupla["id"].'"/>
            <input type="image" width = "35 px" src="../img/edit.png">
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
            <td>'.$tupla["nombre"].'</td>
            <td>'.$tupla["Nombre"].' '.$tupla["Apellido"].'</td>
            <td>'.$tupla['precio'].'</td>
            <td>'.$tupla['costo'].'</td>
            <td>'.$tupla["unidades_en_stock"].'</td>
            <td><img src="../img/productos/'.$tupla['url_imagen'].'" alt="'.$tupla["nombre"].'" height = "100px" class="Foto/"></td></tr>';
        }
        return $res.'</table></div></div>';
    }
}

$oProductos = new Productos();
?>