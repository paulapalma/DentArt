<?php
include "../php/classBaseDeDatos.php";

class Roles extends baseDatos{
    function ejecuta($accion){
        $html = '';
        switch ($accion){
            case 'insert':
                $this->m_query("INSERT into rol SET Rol='".$_POST['Rol']."'");
                $html = $this->listar();
            break;
            case 'update':
                $cad = "UPDATE rol SET Rol = '".$_POST['Rol']."' where id_Rol = ".$_POST['id_Rol'];
                $this->m_query($cad);
                $html=$this->listar();
            break;
            case 'delete':
                $this->m_query("DELETE from rol where id_Rol =".$_POST['id_Rol']);
                $html = $this->listar();
            break;
            case 'editForm':
                $registro = $this->m_obtenerRegistro("SELECT * from rol where id_Rol =".$_POST['id_Rol']);
            case 'newForm':
                $html.='<div class="container">
                <form method="post">';
                if (isset($registro)) 
                $html.='<input type="hidden" name="id_Rol" value="'.$_POST['id_Rol'].'" />';
                $html.='<div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                <div class="form-group">
                <label class="form-label mt-4">'.((isset($registro))?"Rol":"Nuevo Rol").'</label>
                <div class="form-group">
                <div class="input-group mb-3">
                <span class="input-group-text">Rol</span>
                <input type="text" class="form-control" name="Rol" placeholder="Nombre del rol" value="'.((isset($registro))? $registro["Rol"] :"").'">
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                <button  class="btn btn-info" >'.((isset($registro))? "Actualizar":"Registrar").'</button>
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
        <th>Eliminar</th></td><th>Id</th><th/>Nombre</th></tr>';
        //Fin de cabezera
        $this->m_query("SELECT * from rol order by id_Rol");
        for($i = 0; $i < $this->a_numRegistros; $i++){
            $tupla = $this->m_recuRegistro();
            $res.='<tr class="table-prymari"><td>
            <form method="post">
            <input type="hidden" name="accion" value = "editForm"/>
            <input type="hidden" name="id_Rol" value = "'.$tupla["id_Rol"].'"/>
            <input type="image" width = "35 px" src="../img/edit.png">
            </form>
            </td>
            
            <td>
            <form method="post">
            <input type="hidden" name="accion" value = "delete"/>
            <input type="hidden" name="id_Rol" value ="'.$tupla["id_Rol"].'"/>
            <input type="image" width="35px" src="../img/basura.png"/>
            </form>
            </td>
            <td>'.$tupla["id_Rol"].'</td><td>'.$tupla["Rol"].'</td></tr>';
        }
        return $res.'</table></div></div>';
    }
}

$oRoles = new Roles();
?>