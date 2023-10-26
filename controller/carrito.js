function carrito(cual, para1, para2, para3) {
  switch (cual) {
    case "delete":
      $.confirm({
        title: "Eliminar promoción",
        content: "¿Está seguro de eliminar esta promoción?",
        columnClass: "col-md-6 col-md-offset-3",
        type: "red",
        buttons: {
          confirm:function() {
            $.ajax({
              data:{"id_Carrito":para1},
              type:"post",
              url:"../php/classCarrito.php?accion=delete",
              beforeSend:function(){
                principal.innerHTML=".......Espere....... ";
                $.alert({
                  title: "Eliminando promoción",
                  content: "Carrito eliminada",
                  columnClass: "col-md-6 col-md-offset-3",
                  type: "red",
                });
              },
              success:function(resu){
                principal.innerHTML=resu;
              }
            });
          },
          cancel:function(){
          }
        }
      });
    break;
    case "editForm":
      $.ajax({
        data:{"id_Carrito":para1},
        type:"post",
        url:"../php/classCarrito.php?accion=editForm",
        success:function(resu){
            ventana = $.dialog({
              title:'Carrito',
              content: resu,
              columnClass: 'col-md-6 col-md-offset-3',
              type:"green",
            });
          }
      });
    break;
    case "newForm":
      ventana = $.dialog({
        title:'Nueva Promoción',
        content: 'url:../php/classCarrito.php?accion=newForm',
        columnClass: 'col-md-6 col-md-offset-3',
        type:"green",
      });
    break;
    case "insert":
      $.ajax({
        data:$("#formCarrito").serialize(),
        type:"post",
        url:"../php/classCarrito.php?accion=insert",
        beforeSend:function(){
          principal.innerHTML=".......Espere....... ";
        },
        success:function(resu){
          principal.innerHTML=resu;
        }
      });

      ventana.close();
    break;
    case "update":
      $.ajax({
        data:$("#formCarrito").serialize(),
        type:"post",
        url:"../php/classCarrito.php?accion=update",
        beforeSend:function(){
          principal.innerHTML=".......Espere....... ";
        },
        success:function(resu){
          principal.innerHTML=resu;
        }
      });
      ventana.close();
    break;
    default:
      $.alert({
        title: "Atencion!",
        content:
          '<span class="text-danger" La opcion <b>' +
          cual + "</b> No esta programada en carrito.js</span>",
      });
      break;
  }
}

function alerta(titulo,contenido){
  $.alert({
    title: titulo,
    content: contenido,
    columnClass: "col-md-6 col-md-offset-3",
    type: "red",
  });
}