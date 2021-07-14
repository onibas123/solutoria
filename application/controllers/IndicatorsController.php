<?php

class IndicatorsController extends CI_Controller
{

	private $apiUrl;

	function __construct()
	{
		parent::__construct();
		$this->load->model('IndicatorsModel', 'model');
		$this->apiUrl = 'https://mindicador.cl/api';
	}

    ################SECTION REDIRECT VIEWS CRUD#################################
    ############################################################################
	public function index()
	{
        $indicators = $this->model->get(0);
        $data = array(
            'indicators' => $indicators
        );
        $this->load->view('indicators/index', $data);
	}

    public function add()
    {
        $this->load->view('indicators/add');
    }

    public function edit()
    {
        $id = $this->input->get('id', true);
        $indicator = $this->model->get($id);
        $data = array(
            'indicator' => $indicator
        ); 
        $this->load->view('indicators/edit', $data);
    }

    ############################################################################
    ############################################################################

    ################SECTION FUNCTIONS VIEWS CRUD################################
    ############################################################################
    public function save()
    {
        $date_time = date('Y-m-d H:i:s');
        //inputs from view via ajax post [code: code, name: name, value: value, date: date_]
        $indicator = array(
            'code' => $this->input->post('code', true),
            'name' => $this->input->post('name', true),
            'value' => $this->input->post('value', true),
            'date' => $this->input->post('date', true),
            'created' => $date_time

        );
        if($this->model->save($indicator))
            echo 1;
        else
            echo 0;
    }

    public function update()
    {
        $id = $this->input->post('id', true);
        //inputs from view via ajax post [code: code, name: name, value: value, date: date_]
        $indicator = array(
            'value' => $this->input->post('value', true),
            'date' => $this->input->post('date', true)
        );
        if($this->model->update($indicator, $id))
            echo 1;
        else
            echo 0;
    }

    public function delete()
    {
        $id = $this->input->post('id', true);
        if($this->model->delete($id))
            echo 1;
        else
            echo 0;
    }


    ############################################################################
    ############################################################################
	
}

?>
