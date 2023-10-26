<?php
include "../php/classBaseDeDatos.php";

class Users extends baseDatos{
    function ejecuta($accion){
        $rutaImagen = "../img/usuarios/";
        $nomFinal = "";
        $html = '';
        switch ($accion){
            case 'insert':
                if($_POST['nombres']!=''&&$_POST['apellidos']!=''&&$_POST['correo']!=''&&$_POST['pwd']!=''){
                    $extension = explode(".",$_FILES['Foto']['name']);
                $extension = $extension[count($extension)-1];
                $nomFinal = $_SESSION['id_Usuario'].".".$extension;
                move_uploaded_file($_FILES['Foto']['tmp_name'],$rutaImagen.$nomFinal);
                $cad="INSERT INTO usuario set Nombre='".$_POST['nombres']."', Apellido='".$_POST['apellidos']."', Email='".$_POST['correo']."',
                 Pwd=PASSWORD('".$_POST['pwd']."'), id_Rol ='".$_POST['Rol']."', Fecha_ulti_acceso='".$_POST['Fecha_Ulti_Acceso']."',
                  Accesos = '".$_POST['Accesos']."', Genero='".(($_POST['Genero']=="F")?"Femenino":(($_POST['Genero']=="M")?"Masculino":"Otro"))."', Foto='".$nomFinal."'";
                $this->m_query($cad);
                $html = $this->listar();
                }else{
                    echo '<div class="conntainer">
                    <div class="alert alert-danger" role="alert">
                    <div class="col-4">';
                    echo "Falto algun dato";
                    echo'</div></div></div>';}
            break;
            case 'update':
                if ($_POST['nombres']!=''&&$_POST['apellidos']!=''&&$_POST['correo']!=''&&$_POST['pwd']!='') {
                    $cad = "UPDATE usuario SET Nombre = '".$_POST['nombres']."', Apellido='".($_POST['apellidos'])."', Email='".$_POST['correo']."', Pwd = PASSWORD('".$_POST['pwd']."'), id_Rol='".$_POST[ 'Rol']."' where id_Usuario = ".$_POST['id_Usuario'].";";
                $this->m_query($cad);
                $html=$this->listar();
                }else{
                    echo '<div class="conntainer">
                        <div class="alert alert-danger" role="alert">
                        <div class="col-4">';
                        echo "Falto algun dato";
                        echo'</div></div></div>';
                }
            break;
            case 'updateProfile':
                if ($_POST['nombres']!=''&&$_POST['apellidos']!=''&&$_POST['correo']!=''&&$_POST['pwd']!='') {
                    if($_POST['pwd']==""){
                        echo '<div class="conntainer">
                        <div class="alert alert-danger" role="alert">
                        <div class="col-4">';
                        echo "Escribe tu contraseña porque si no no se puede actualizar";
                        echo'</div></div></div>';
                    }else{
                        if($_FILES['Foto']['name'] != ''){
                        $extension = explode(".",$_FILES['Foto']['name']);
                        $extension = $extension[count($extension)-1];
                        $nomFinal = $_SESSION['id_Usuario'].".".$extension;
                        move_uploaded_file($_FILES['Foto']['tmp_name'],$rutaImagen.$nomFinal);
                        $cad = "UPDATE usuario set Foto = '".$nomFinal."', Nombre='".$_POST['nombres']."', Apellido='".$_POST['apellidos']."', Pwd=PASSWORD('".$_POST['pwd']."'), Genero='".(($_POST['Genero']=="F")?"Femenino":(($_POST['Genero']=="M")?"Masculino":"Otro"))."' where id_Usuario = ".$_SESSION['id_Usuario'];
                        $this->m_query($cad);
                        $_SESSION['Foto'] = $nomFinal;
                        }else{
                            $cad = "UPDATE usuario set Nombre='".$_POST['nombres']."',
                             Apellido='".$_POST['apellidos']."', Pwd=PASSWORD('".$_POST['pwd']."'),
                              Genero='".(($_POST['Genero']=="F")?"Femenino":(($_POST['Genero']=="M")?"Masculino":"Otro"))."' where id_Usuario = "
                              .$_SESSION['id_Usuario'];
                            $this->m_query($cad);
                        }
                    }
                    $html=$this->viewProfile();
                }
            break;
            case 'delete':
                $this->m_query("DELETE from usuario where id_Usuario =".$_POST['id_Usuario']);
                $html = $this->listar();
                break;
            case 'editForm':
                $registro = $this->m_obtenerRegistro("SELECT * from usuario where id_Usuario =".$_POST['id_Usuario']);
            case 'newForm':
                $html.='<div class="container">
                <form method="post">';
                if (isset($registro))
                $html.='<input type="hidden" name="id_Usuario" value="'.$_POST['id_Usuario'].'" />';
                $html.='<div class="row">
                <div class="col-4"></div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label mt-4">'.(isset($registro)?"Usuario":"Nuevo Usuario").'</label>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Nombre</span>
                                    <input type="text" class="form-control" name="nombres" placeholder="Nombre del Usuario" value="'.((isset($registro))? $registro["Nombre"] :"").'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Apellidos</span>
                                    <input type="text" class="form-control" name="apellidos" placeholder="Apellido del usuario" value="'.((isset($registro))?$registro['Apellido']:"").'" required>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Email</span>
                                    <input type="text" class="form-control" name="correo" placeholder="Email" value="'.((isset($registro))?$registro['Email']:"").'" required>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Password</span>
                                    <input type="text" class="form-control" name="pwd" placeholder="Contraseña" value="" required>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Fecha del ultimo acceso</span>
                                    <input type="date" class="form-control" name="Fecha_Ulti_Acceso" placeholder="Fecha del ultimo acceso" value="'.((isset($registro))?$registro['Fecha_ulti_acceso']:date("Y-m-d")).'" '.((isset($registro))?"disabled":"").' required>
                                    </div>
                            </div>'.((isset($registro))?"":"").'
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Accesos</span>
                                    <input type="text" class="form-control" name="Accesos" placeholder="Cuantos accesos tiene" value="'.((isset($registro))?$registro['Accesos']:"").'" '.((isset($registro))?"disabled":"").' required>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <fieldset class="form-group"> 
                                    <legend class="mt-4">Genero</legend>
                                    <div class="row">
                                    <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" id="Fem" value="F" name="Genero" '.((isset($registro))?(($registro['Genero']=='Femenino')?"checked":""):"").' required>
                                        <label class="form-check-label" for="Fem">Femenino</label >
                                    </div>
                                    </div>
                                    <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" value="M" id="masc" name="Genero" '.((isset($registro))?(($registro['Genero']=='Masculino')?"checked":""):"").' required>
                                        <label class="form-check-label" for="masc">Mascúlino</label>
                                    </div>
                                    </div>
                                    <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" value="Otro" id="O" name="Genero" '.((isset($registro))?(($registro['Genero']=='Otro')?"checked":""):"").' required>
                                        <label class="form-check-label" for="otro">Otro</label>
                                    </div>
                                    </div>
                                    </div>
                                    </fieldset>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <fieldset class="form-group"> 
                                    <legend class="mt-4">Rol</legend>
                                    <div class="row">
                                    <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" id="Rol" value="1" name="Rol" '.((isset($registro))?(($registro['id_Rol']=='1')?"checked":""):"").' required>
                                        <label class="form-check-label" for="Fem">Administrador</label>
                                    </div>
                                    </div>
                                    <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" value="2" id="Rol" name="Rol" '.((isset($registro))?(($registro['id_Rol']=='2')?"checked":""):"").' required>
                                        <label class="form-check-label" for="masc">Usuario</label>
                                    </div>
                                    </div>
                                    <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" value="3" id="Rol" name="Rol" '.((isset($registro))?(($registro['id_Rol']=='3')?"checked":""):"").' required>
                                        <label class="form-check-label" for="masc">Vendedor</label>
                                    </div>
                                    </div>
                                    </fieldset>
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
            case 'viewProfile':
                $html = $this->viewProfile();
            break;
            default:
                $html.= $_REQUEST['accion']." Accion no programada";
            break;
        }
        return $html;
    }
    function viewProfile(){
                $rutaImagen = "../img/fotos/";
                $registro = $this->m_obtenerRegistro("SELECT * from usuario where id_Usuario =".$_SESSION['id_Usuario']);
                $res = '<div class="container">
                <form method="post" enctype="multipart/form-data">';
                if (isset($registro))
                $res.='<input type="hidden" name="id_Usuario" value="'.$_SESSION['id_Usuario'].'" />';
                $res.='<div class="row">
                <div class="col-4">
                    </div>
                        <div class="col-4">
                        <div class="form-group">
                                <label class="form-label mt-4">Editar Perfil</label>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="file" accept=".jpg,.png,.jpeg,.gif " class="form-control" name="Foto" placeholder="Nombre del Usuario" value='.((isset($registro))? $registro["Foto"] :"").'>
                                    <img src="'.(($registro["Foto"]!=="")?$rutaImagen.$registro["Foto"]:$rutaImagen."user.png").'" alt="" height = "36 px" class="Foto"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Nombre</span>
                                    <input type="text" class="form-control" name="nombres" placeholder="Nombre del Usuario" value="'.((isset($registro))?$registro["Nombre"]:"").'">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Apellidos</span>
                                    <input type="text" class="form-control" name="apellidos" placeholder="Apellido del usuario" value="'.((isset($registro))?$registro["Apellido"]:"").'">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <span class="input-group-text">Password</span>
                                    <input type="text" class="form-control" name="pwd" placeholder="Contraseña" value="">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group mb-3">
                                    <fieldset class="form-group"> 
                                    <legend class="mt-4">Genero</legend>
                                    <div class="row">
                                    <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" id="Fem" value="F" name="Genero" '.((isset($registro))?(($registro['Genero']=='Femenino')?"checked":""):"").'>
                                        <label class="form-check-label" for="Fem">Femenino</label>
                                    </div>
                                    </div>
                                    <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" value="M" id="masc" name="Genero" '.((isset($registro))?(($registro['Genero']=='Masculino')?"checked":""):"").'>
                                        <label class="form-check-label" for="masc">Mascúlino</label>
                                    </div>
                                    </div>
                                    <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" value="Otro" id="O" name="Genero" '.((isset($registro))?(($registro['Genero']=='Otro')?"checked":""):"").'>
                                        <label class="form-check-label" for="otro">Otro</label>
                                    </div>
                                    </div>
                                    </div>
                                    </fieldset>
                                    </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                <button  class="btn btn-info" >Actualizar</button>
                <input type="hidden" name="accion" value="updateProfile" />
                </div>
                </div>
                </form>
                </div>';
                return $res;
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
        <th>Eliminar</th></td><th>Id</th><th/>Nombre Completo<th>Email</th><th>Fecha de ultimo acceso</th><th>Accesos</th><th>Genero</th><th>Rol</th><th>Foto</th>
        </tr>';
        //Fin de cabezera
        $this->m_query("SELECT * from usuario order by id_usuario");
        for($i = 0; $i < $this->a_numRegistros; $i++){
            $tupla = $this->m_recuRegistro();
            $res.='<tr class="table-prymari">
            <td>
            <form method="post">
            <input type="hidden" name="accion" value = "editForm"/>
            <input type="hidden" name="id_Usuario" value = "'.$tupla["id_Usuario"].'"/>
            <input type="image" width = "35 px" src="../img/edit.png">
            </form>
            </td>
            <td>
            <form method="post">
            <input type="hidden" name="accion" value = "delete"/>
            <input type="hidden" name="id_Usuario" value ="'.$tupla["id_Usuario"].'"/>
            <input type="image" width="35px" src="../img/basura.png"/>
            </form>
            </td>
            <td>'.$tupla["id_Usuario"].'</td>
            <td>'.$tupla["Nombre"].' '.$tupla['Apellido'].'</td>
            <td>'.$tupla['Email'].'</td>
            <td>'.$tupla['Fecha_ulti_acceso'].'</td>
            <td>'.$tupla['Accesos'].'</td>
            <td>'.$tupla['Genero'].'</td>
            <td>'.(($tupla['id_Rol']=='1')?"Administrador":(($tupla['id_Rol']=='2')?"Usuario":"Vendedor")).'</td>
            <td><img src="../img/usuarios/'.$tupla['Foto'].'"height="36px" alt="'.$tupla["Nombre"]." ".$tupla["Apellido"].'"/></td>
            </tr>';
        }
        return $res.'</table></div></div>';
    }
}

$oUsers = new Users();
?>