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
    <h5>Históricos UF</h5>
    <a href="<?php echo base_url();?>index.php/IndicatorsController/add" class="btn btn-primary">Agregar</a>
    <br><br>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table" id="table-indicators">
					<thead>
						<tr>
						<th>#</th>
                        <th>Código</th>
						<th>Nombre</th>
						<th>Valor</th>
                        <th>Fecha Consulta</th>
						<th>Creado</th>
						<th>Modificado</th>
                        <th>Acciones</th>
						</tr>
					</thead>
					<tbody id="tbody-indicators">
						<?php
                        if(!empty($indicators))
                        {
                            foreach($indicators as $ind)
                            {
                                echo '<tr>';
                                echo '<td>'.$ind['id'].'</td>';
                                echo '<td>'.$ind['code'].'</td>';
                                echo '<td>'.$ind['name'].'</td>';
                                echo '<td>$ '.$ind['value'].'</td>';
                                echo '<td>'.$ind['date'].'</td>';
                                echo '<td>'.$ind['created'].'</td>';
                                echo '<td>'.$ind['modified'].'</td>';
                                echo '<td><a href="'.base_url().'index.php/IndicatorsController/edit?id='.$ind['id'].'" class="btn btn-warning btn-sm"><font color="white">editar</font></a>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" onclick="delete_('.$ind['id'].');">eliminar</button></td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo '<tr><td colspan="7" align="center">No hay data en el CRUD.</td></tr>';
                        }
                        ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<script>
		$(document).ready(function()
		{

		});

        function delete_(id)
        {
            let c = confirm('Confirme la eliminación del registro.');
            if(c)
            {
                $.ajax({
				url: '<?php echo base_url();?>index.php/IndicatorsController/delete',
				type: 'post',
				data: {id: id},
				dataType: "text",
             	contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				success: function(data)
				{
                    if(data == '1')
                    {
                        alert('Se ha eliminado correctamente');
                        location.reload();
                    }
                    else
                        alert('Ocurrio un problema en el servidor ERROR 500');
				}
			});
            }
            
        }
	</script>

</body>

</html>