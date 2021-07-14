<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST SOLUTORIA</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<!-- Step 1 - Include the fusioncharts core library -->
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <!-- Step 2 - Include the fusion theme -->
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>

<?php $this->load->view('nav');?>
  <div class="container">
	
	<br>
  <div class="row">
	<div class="col-md-3"> 
		
		<label>Tipo Indicador: </label>
		<?php
		if(!empty($select))
			echo $select;
		?>
	</div>

	<div class="col-md-3"> 
		<label>Desde: </label>
		<input class="form-control" id="date_ini" type="date" value="<?php echo date('Y-m-d'); ?>" />
	</div>

	<div class="col-md-3"> 
		<label>Hasta: </label>
		<input class="form-control" id="date_end" type="date" value="<?php echo date('Y-m-d'); ?>" />
	</div>

	<div class="col-md-3" > 
		<button  style="margin-top:30px;" class="btn btn-success" onclick="load_chart();">Consultar</button>
	</div>

  </div>
  <div class="row">
		<div class="col-md-12">
			<div id="chart-container" style="width:100%; height: 500px;">

			</div>
		</div>
	</div>
	<br>
	<div class="row">
	<p>Nota: El despliegue de información puede tardar si el intervalo de tiempo es muy grande o si se seleccionan todos los tipos de indicadores.</p>
	</div>
</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<script>
		$(document).ready(function()
		{
			load_chart();
		});

		function load_chart()
		{
			let indicator = $('#indicators').val();
			let date_ini = $('#date_ini').val();
			let date_end = $('#date_end').val();

			$.ajax({
				url: '<?php echo base_url();?>index.php/Welcome/getIndicatorsValues',
				type: 'post',
				data: {indicator: indicator, date_ini: date_ini, date_end: date_end},
				dataType: "html",
             	contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				success: function(data)
				{
					var arr = new Array();
					arr = data.split('###');
					eval(arr[1]);
				},
				beforeSend:function(){
					$('#chart-container').html('<br><center><h5>Cargando Gráfico...</h5></center>');
				}
			});

			
			
		}
	</script>

</body>

</html>