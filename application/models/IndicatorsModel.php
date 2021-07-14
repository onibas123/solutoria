<?php

class IndicatorsModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        if($id > 0)
        {
            //by id
            $this->db->select('id, code, name, value, date, created, modified');
            $this->db->from('indicators');
            $this->db->where('id', $id);
            $this->db->limit(1);

            return $this->db->get()->result_array();
        }
        else
        {
            //all
            $this->db->select('id, code, name, value, date, created, modified');
            $this->db->from('indicators');
            $this->db->order_by('code','asc');

            return $this->db->get()->result_array();
        }
    }

    public function save($data)
    {
        if($this->db->insert('indicators', $data))
            return true;
        else
            return false;
    }

    public function update($data, $id)
    {
        $this->db->where('id', $id);
        if($this->db->update('indicators', $data))
            return true;
        else
            return false;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if($this->db->delete('indicators'))
            return true;
        else
            return false;
    }
}

?>