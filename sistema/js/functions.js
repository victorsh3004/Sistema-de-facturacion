$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

        if ($("#foto_actual") && $("#foto_remove")) {
            $("#foto_remove").val('img_producto.png');
        }

    });


    // Modal Form Add Product
    $('.add_product').click(function(e) {
        /* Act on the event */
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){
                if (response != 'error') {
                    var info = JSON.parse(response);
                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                                '<h1><i class="fas fa-cubes" styles="font-size: 45pt;"></i> <br> Agregar Producto</h1>'+
                                                '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
                                                '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del producto" required><br>'+
                                                '<input type="text" name="precio" id="txtPrecio" placeholder="Precio del producto">'+
                                                '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                                '<input type="hidden" name="action" value="addProduct" required>'+
                                                '<div class="alert alertAddProduct"></div>'+
                                                '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
                                                '<a href="#" class="btn_ok closeModal" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                                
                                            '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }

        });

        $('.modal').fadeIn();
        
    });

        

    //Modal Form Delete Product
    $('.del_product').click(function(e) {
        /* Act on the event */
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){
                if (response != 'error') {
                    var info = JSON.parse(response);
                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delProduct();">'+
                                                '<h1><i class="fas fa-cubes" styles="font-size: 45pt;"></i> <br> Eliminar Producto</h1>'+

                                                '<p>¿Está seguro de eliminar el siguiente registro?</p>'+

                                                '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
                                                '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                                '<input type="hidden" name="action" value="delProduct" required>'+
                                                '<div class="alert alertAddProduct"></div>'+

                                                '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cancelar</a>'+
                                                '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>'+
                                            '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }

        });

        $('.modal').fadeIn();
        
    });


});

function sendDataProduct(){
    $('.alertAddProduct').html('');

    $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){
                if (response == 'error') {
                    $('.alertAddProduct').html('<p style="color: red;">Error al agregar el producto.</p>');
                }else{
                    var info = JSON.parse(response);
                    $('.row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
                    $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
                    $('#txtCantidad').val('');
                    $('#txtPrecio').val('');
                    $('.alertAddProduct').html('<p>Producto guardado correctamente.</p>');
                }
            },

            error: function(error){
                console.log(error);
            }

        });
}



//Eliminar producto
function delProduct(){

    var pr = $('#producto_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: $('#form_del_product').serialize(),

            success: function(response){
                console.log(response);
                
                if (response == 'error') {
                    $('.alertAddProduct').html('<p style="color: red;">Error al eliminar el producto.</p>');
                }else{
                    $('.row'+pr).remove();
                    $('#form_del_product .btn_ok').remove();
                    $('.alertAddProduct').html('<p>Producto eliminado correctamente.</p>');
                }
            },

            error: function(error){
                console.log(error);
            }

        });
}

function coloseModal(){
        $('.alertAddProduct').html('');
        $('#txtCantidad').val('');
        $('#txtPrecio').val('');
        $('.modal').fadeOut();
    }
