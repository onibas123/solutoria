<?php

class Welcome extends CI_Controller
{

	private $apiUrl;

	function __construct()
	{
		parent::__construct();
		$this->apiUrl = 'https://mindicador.cl/api';
	}

	public function index()
	{
		$data = array(
			'select' => $this->crate_selector('indicators', $this->getIndicators())
		);
		$this->load->view('welcome_message', $data);
	}

	private function getIndicators()
	{
		$indicators = array();
		$i = 0;

		//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
		if ( ini_get('allow_url_fopen') ) {
			$json = file_get_contents($this->apiUrl);
		} else {
			//De otra forma utilizamos cURL
			$curl = curl_init($this->apiUrl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($curl);
			curl_close($curl);
		}
		
		$dailyIndicators = json_decode($json);
		$arr_ind = (array)$dailyIndicators;
		foreach($dailyIndicators as $key => $value)
		{
			//desde el indice 3 hacia arriba
			if($i > 2 )
			{
				array_push($indicators, $key);
			}
			$i++;
		}

		return $indicators;
	}

	private function crate_selector($name, $items)
	{
		$select = '<select onchange="load_chart();" class="form-control" id="'.$name.'" name="'.$name.'">';
		$select .= '<option value="0">Todos</option>';
		foreach($items as $i)
		{
			if($i == 'uf')
				$select .= '<option value="'.$i.'" selected>'.$i.'</option>';
			else
				$select .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$select .= '<select>';

		return $select;
	}

	public function getIndicatorsValues()
	{
		$indicator = $this->input->post('indicator', TRUE);
		$date_ini = $this->input->post('date_ini', TRUE);
		$date_end = $this->input->post('date_end', TRUE);

		$category = '[';
		$dataset = '';
		//$sep = ',';

		if($indicator == '0')
		{
			//get all
			$indicators = $this->getIndicators();

			$date = new DateTime($date_ini);
			$salida = '';
			
			if($date_ini == $date_end)
			{
				$category .= '{label: "'.$date_ini.'" }';
				$category .= ']';

				$count_indicators = 0;
				$total_indicators = count($indicators);
				foreach($indicators as $i)
				{
					if (ini_get('allow_url_fopen'))
					{
						$json = file_get_contents($this->apiUrl.'/'.$i.'/'.$date->format('d-m-Y'));
					} 
					else
					{
						$curl = curl_init($this->apiUrl.'/'.$i.'/'.$date->format('d-m-Y'));
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						$json = curl_exec($curl);
						curl_close($curl);
					}
					
					$dailyIndicators = json_decode($json, true);
					$dataset .= '{ seriesname: "'.$i.'", ';
					$dataset .= 'data: [';
					if(count($dailyIndicators['serie']) > 0)
					{
						foreach($dailyIndicators['serie'] as $serie)
						{
							if(!empty($serie['valor']))
								$dataset .= '{value: "'.$serie['valor'].'"}';
							else
								$dataset .= '{value: "0"}';
						}
					}
					else
					{
						$dataset .= '{value: "0"}';
					}
					
					if($count_indicators < ($total_indicators-1))
						$dataset .= ']},';
					else
						$dataset .= ']}';

					$count_indicators++;
				}
				
			}
			else
			{
				$datetime1 = strtotime($date_ini);
				$datetime2 = strtotime($date_end);
				$interval = $datetime2 - $datetime1;
				$dif = round($interval / (60 * 60 * 24));
				$count_while = 0;

				while($date->format('Y-m-d') <= $date_end)
				{
					if($count_while < $dif)
						$category .= '{label: "'.$date->format('d-m-Y').'" }, ';
					else
						$category .= '{label: "'.$date->format('d-m-Y').'" }';

					$date->modify('+1 day');
					$count_while++;
				}

				$category .= ']';
				
				
				
				$count_indicators = 0;
				$total_indicators = count($indicators);
				foreach($indicators as $i)
				{
					$dataset .= '{ seriesname: "'.$i.'", ';
					$dataset .= 'data: [';
					$date = new DateTime($date_ini);
					$count_while = 0;
					while($date->format('Y-m-d') <= $date_end)
					{
						if (ini_get('allow_url_fopen'))
						{
							$json = file_get_contents($this->apiUrl.'/'.$i.'/'.$date->format('d-m-Y'));
						} 
						else
						{
							$curl = curl_init($this->apiUrl.'/'.$i.'/'.$date->format('d-m-Y'));
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							$json = curl_exec($curl);
							curl_close($curl);
						}
						
						$dailyIndicators = json_decode($json, true);
						
						if(count($dailyIndicators['serie']) > 0)
						{
							foreach($dailyIndicators['serie'] as $serie)
							{
								if(!empty($serie['valor']))
								{
									if($count_while < $dif)
										$dataset .= '{value: "'.$serie['valor'].'"}, ';
									else
										$dataset .= '{value: "'.$serie['valor'].'"} ';
								}	
								else
								{
									if($count_while < $dif)
										$dataset .= '{value: "0"}, ';
									else
										$dataset .= '{value: "0"} ';
								}
							}
						}
						else
						{
							if($count_while < $dif)
								$dataset .= '{value: "0"}, ';
							else
								$dataset .= '{value: "0"} ';
						}
						
						$count_while++;
						$date->modify('+1 day');
					}
					if($count_indicators < ($total_indicators) -1)
						$dataset .= ']}, ';
					else
						$dataset .= ']} ';
					$count_indicators++;						
				}
						
			}
				
			

		?>
		###
		 var dataSource = {
			chart: {
				caption: "Indicadores Económicos",
				yaxisname: "$",
				showhovereffect: "1",
				numberPrefix: "$",
				drawcrossline: "1",
				plottooltext: "<b>$dataValue</b> de $seriesName",
				theme: "fusion"
			},
			categories: [
				{
					category: <?php echo $category;?>
				}
			],
			dataset: [
				<?php echo $dataset;?>
			]
		};
		
		FusionCharts.ready(function() {
			var myChart = new FusionCharts({
				type: "msline",
				renderAt: "chart-container",
				width: "100%",
				height: "400",
				dataFormat: "json",
				dataSource: dataSource
			}).render();
		});
		###
		<?php
		}
		else
		{
			//get by indicator $indicator
			$date = new DateTime($date_ini);
			$salida = '';
			
			if($date_ini == $date_end)
			{
				$category .= '{label: "'.$date_ini.'" }';
				$category .= ']';

				if (ini_get('allow_url_fopen'))
				{
					$json = file_get_contents($this->apiUrl.'/'.$indicator.'/'.$date->format('d-m-Y'));
				} 
				else
				{
					$curl = curl_init($this->apiUrl.'/'.$indicator.'/'.$date->format('d-m-Y'));
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($curl);
					curl_close($curl);
				}
				
				$dailyIndicators = json_decode($json, true);
				$dataset .= '{ seriesname: "'.$indicator.'", ';
				$dataset .= 'data: [';
				if(count($dailyIndicators['serie']) > 0)
				{
					foreach($dailyIndicators['serie'] as $serie)
					{
						if(!empty($serie['valor']))
							$dataset .= '{value: "'.$serie['valor'].'"}';
						else
							$dataset .= '{value: "0"}';
					}
				}
				else
				{
					$dataset .= '{value: "0"}';
				}
				
				$dataset .= ']}';
				
			}
			else
			{
				$datetime1 = strtotime($date_ini);
				$datetime2 = strtotime($date_end);
				$interval = $datetime2 - $datetime1;
				$dif = round($interval / (60 * 60 * 24));
				$count_while = 0;

				while($date->format('Y-m-d') <= $date_end)
				{
					if($count_while < $dif)
						$category .= '{label: "'.$date->format('d-m-Y').'" }, ';
					else
						$category .= '{label: "'.$date->format('d-m-Y').'" }';

					$date->modify('+1 day');
					$count_while++;
				}

				$category .= ']';
				
				$dataset .= '{ seriesname: "'.$indicator.'", ';
				$dataset .= 'data: [';
				$date = new DateTime($date_ini);
				$count_while = 0;
				while($date->format('Y-m-d') <= $date_end)
				{
					if (ini_get('allow_url_fopen'))
					{
						$json = file_get_contents($this->apiUrl.'/'.$indicator.'/'.$date->format('d-m-Y'));
					} 
					else
					{
						$curl = curl_init($this->apiUrl.'/'.$indicator.'/'.$date->format('d-m-Y'));
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						$json = curl_exec($curl);
						curl_close($curl);
					}
					
					$dailyIndicators = json_decode($json, true);
					
					if(count($dailyIndicators['serie']) > 0)
					{
						foreach($dailyIndicators['serie'] as $serie)
						{
							if(!empty($serie['valor']))
							{
								if($count_while < $dif)
									$dataset .= '{value: "'.$serie['valor'].'"}, ';
								else
									$dataset .= '{value: "'.$serie['valor'].'"} ';
							}	
							else
							{
								if($count_while < $dif)
									$dataset .= '{value: "0"}, ';
								else
									$dataset .= '{value: "0"} ';
							}
						}
					}
					else
					{
						if($count_while < $dif)
							$dataset .= '{value: "0"}, ';
						else
							$dataset .= '{value: "0"} ';
					}
					
					$count_while++;
					$date->modify('+1 day');
				}
				$dataset .= ']} ';					
				
						
			}	

		?>
		###
		 var dataSource = {
			chart: {
				caption: "Indicadores Económicos",
				yaxisname: "$",
				showhovereffect: "1",
				numberPrefix: "$",
				drawcrossline: "1",
				plottooltext: "<b>$dataValue</b> de $seriesName",
				theme: "fusion"
			},
			categories: [
				{
					category: <?php echo $category;?>
				}
			],
			dataset: [
				<?php echo $dataset;?>
			]
		};
		
		FusionCharts.ready(function() {
			var myChart = new FusionCharts({
				type: "msline",
				renderAt: "chart-container",
				width: "100%",
				height: "400",
				dataFormat: "json",
				dataSource: dataSource
			}).render();
		});
		###
		<?php

		}
	}

	
}

?>
