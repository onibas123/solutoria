<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST SOLUTORIA</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<?php $this->load->view('nav');?>
    
  <div class="container">
	<br>
    <h5>Agregar nuevo valor UF</h5>
    <div class="row">
        <div class="col-md-3"> 
            <label>Fecha </label>
            <input class="form-control" id="date" type="date" value="<?php echo date('Y-m-d'); ?>" />
        </div>
        <div class="col-md-3" > 
            <button id="btn_query_uf"  style="margin-top:30px;" class="btn btn-primary" onclick="queryUF();">Consultar UF</button>
        </div>
        
    </div>
    
	<hr>
    <p id="p-message"></p>
	<div class="row">
		<div class="col-md-6">
            <input type="number" class="form-control" id="uf_value" name="uf_value" value="0">
		</div>
	</div>
    <br>
    <div class="row">
		<div class="col-md-4">
            <button id="btn_save" class="btn btn-success" onclick="add();">Guardar</button>
		</div>
	</div>

</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<script>
        
        var code = '';
        var name = '';
        var value = '';
        var date_ = '';

		$(document).ready(function()
		{
			queryUF();
		});

		function queryUF()
		{
			let date = $('#date').val();

            let temp_date = date.split('-');
            let year = temp_date[0];
            let month = temp_date[1];
            let day = temp_date[2];

            let new_date = day + '-' + month + '-' + year
            $.ajax({
                url: 'https://mindicador.cl/api/uf/'+new_date,
                type: 'get',
                dataType: 'json',
                success: function(response)
                {
                    $('#p-message').html('Valor UF sugerido desde https://mindicador.cl/ con Fecha '+new_date);
                    $('#btn_query_uf').attr('disabled', false);
                    if(response['codigo'] != null && response['codigo'] != undefined && response['codigo'] != '')
                        code = response['codigo'];
                    if(response['nombre'] != null && response['nombre'] != undefined && response['nombre'] != '')
                        name = response['nombre'];
                    if(response['serie'][0]['valor'] != null && response['serie'][0]['valor'] != undefined && response['serie'][0]['valor'] != '')
                        value = response['serie'][0]['valor'];
                    //if(response['serie'][0]['fecha'] != null && response['serie'][0]['fecha'] != undefined && response['serie'][0]['fecha'] != '')
                    date_ = date;
                    $('#uf_value').val(value);
                    value = value+"".replace(',','.');
                },
                beforeSend:function(){
                    $('#uf_value').val(0);
                    $('#btn_query_uf').attr('disabled', true);
                    $('#p-message').html('Cargando datos desde https://mindicador.cl/...');
                }
            });
		}

        function add()
        {
            if(value != '' && value != '0')
            {
                var c = confirm('Confirme agregar un nuevo registro.');
                if(c)
                {
                    $.ajax({
                        url: '<?php echo base_url();?>index.php/IndicatorsController/save',
                        type: 'post',
                        dataType: 'text',
                        data: {code: code, name: name, value: value, date: date_},
                        success: function(response)
                        {
                            $('#btn_save').attr('disabled', false);
                            if(response == '1')
                            {
                                var c = confirm('Registro guardado.\n¿Desea ir al listado?');
                                if(c)
                                    location.href = '<?php echo base_url();?>index.php/IndicatorsController/index';
                                else
                                    location.reload();
                            }
                            else
                                alert('Ocurrio un problema en el servidor ERROR 500');
                        },
                        beforeSend:function(){
                            $('#btn_save').attr('disabled', true);
                        }
                    });
                }
                
            }
            else
                alert('El valor de la UF debe ser superior a 0');
            
        }
	</script>

</body>

</html>