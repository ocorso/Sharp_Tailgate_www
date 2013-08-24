<?php

class Winners_Model extends CI_Model
{
	var $table = "winners";
	var $pk = "id";
	
	var $fields = array(
		'id' => 'str',
		'img_id' => 'str'
	);

	function Winners_Model()
    {
        //parent::Model();
    }
	
	/** Utility Methods **/
	function _required($required, $data)
	{
		foreach($required as $field)
			if(!isset($data[$field])) return false;
			
		return true;
	}
	
	function _default($defaults, $options)
	{
		return array_merge($defaults, $options);
	}
	
	function _fields(){
		return $this->fields;
	}
	
	function _pk(){
		return $this->pk;
	}
	
	/** CRUD Methods **/
	function Get( $options = array(), $inOptions = array() ){
		foreach ($this->fields as $key => $value) {
			if(isset($options[$key]))
				$this->db->where($key, $options[$key]);
			
			if(isset($inOptions[$key]))
				$this->db->where_in($key, $inOptions[$key]);
		}
		
		if(isset($options[$this->pk]))
				$this->db->where($this->pk, $options[$this->pk]);
		
		// limit / offset
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		else if(isset($options['limit']))
			$this->db->limit($options['limit']);
		
		// sort
		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		
		$query = $this->db->get($this->table);
		
		if(isset($options['count'])) return $query->num_rows();
		
		if(isset($options[$this->pk])) return $query->row(0);
			
		return $query->result();
	}
	
	function Add($options = array())
	{
		$this->db->insert($this->table, $options);
		
		return $this->db->insert_id();
	}
	
	function Update($options = array())
	{
		foreach ($this->fields as $key => $value) {
			if(isset($options[$key]))
				$this->db->set($key, $options[$key]);
		}

		$this->db->where($this->pk, $options[$this->pk]);
		
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function Delete($pId)
	{
		$this->db->delete($this->table, array($this->pk => $pId)); 	
	}
}

?>