<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dropdowns extends CI_Model {
 
    function __construct() {
        
        parent::__construct();
    }
    
    public function brands_dropdown2(){
	
		$this->db->where('disable', 0);
		$this->db->order_by('ordering', 'asc');
		$res = $this->db->get('brands')->result();
		
		$dp = array(''=>'---select brand---');
		
		foreach($res as $row){
			$dp[$row->id.':'.$row->desc] = $row->desc;
		}
		return $dp;
	}

    public function issues_dropdown2(){
	
		$this->db->where('disable', 0);
		$res = $this->db->get('issues')->result();
		
		$dp = array(''=>'---select issues---');
		foreach($res as $row){
			$dp[$row->id.':'.$row->desc] = $row->desc;
		}
		return $dp;
	}

	public function from_dropdown2(){
	
		$this->db->where('disable', 0);
		$this->db->order_by('ordering', 'asc'); 
		$res = $this->db->get('tbl_from')->result();
		
		$dp = array(''=>'---select from---');
		foreach($res as $row){
			$dp[$row->id.':'.$row->desc] = $row->desc;
		}
		return $dp;
	}
	
	public function center_dropdown1(){
	
		$this->db->where('disable', 0);
		$res = $this->db->get('center')->result();
		
		$dp ='';
		foreach($res as $row){
			$dp[$row->desc] = $row->desc;
		}
		return $dp;
	}
	
	public function system_impacting_dropdown(){
	
		$this->db->where('disable', 0);
		$res = $this->db->get('system_impacting')->result();
		
		$dp ='';
		foreach($res as $row){
			$dp[$row->id] = $row->desc;
		}
		return $dp;
	}	
	
	public function system_impacting_dropdown1(){
	
		$this->db->where('disable', 0);		
		$res = $this->db->get('system_impacting')->result();
		
		$dp ='';
		foreach($res as $row){
			$dp[$row->desc] = $row->desc;
		}
		return $dp;
	}
	
	public function system_impacting_dropdown2(){
	
		$this->db->where('disable', 0);		
		$res = $this->db->get('system_impacting')->result();
		
		$dp = array(''=>'---select system---');
		foreach($res as $row){
			$dp[$row->desc] = $row->desc;
		}
		return $dp;
	}	
	
	public function resolution_dropdown1(){
	
		$this->db->where('disable', 0);
		$res = $this->db->get('root_cause')->result();
		
		$dp = array(''=>'---select resolution---');
		foreach($res as $row){
			$dp[$row->id.':'.$row->desc] = $row->desc;
		}
		return $dp;
	}
	
	public function root_cause_dropdown2(){
	
		$this->db->where('disable', 0);
		$res = $this->db->get('root_cause')->result();
		
		$dp = array(''=>'---select root cause---');
		foreach($res as $row){
			$dp[$row->desc] = $row->desc;
		}
		return $dp;
	}	
	
}