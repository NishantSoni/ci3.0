<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class common_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function save_data($postData=array(),$id='',$feild='',$table='')
	{
	 if($id=='' || $id==0)
	 {
		 $query=$this->db->insert($table,$postData);
		 if($this->db->affected_rows() > 0)
		 {
			 return $this->db->insert_id();
		 }else
		 {
			 return false;
		 }
	 }else
	 {
		 $this->db->where($feild,$id);
		 $query=$this->db->update($table,$postData);
		 if($this->db->affected_rows() > 0)
		 {
			 return $this->db->affected_rows();
		 }else
		 {
			 return false;
		 }
	 }
	}

	function find_data($return_type='array',$conditions='',$table='',$limit=0,$offset=0,$orderby='',$order='',$orderby2='',$order2='')
	{
			$result = array();
			$this->db->select('*');
			if($conditions != '')
			{
				$this->db->where($conditions);
			}
			if($limit != 0)
			{
				$this->db->limit($limit,$offset);
			}
			$this->db->from($table);
		    $this->db->order_by($orderby,$order);
		    if($orderby2!='')
		    {
		    	$this->db->order_by($orderby2,$order2);
		    }
			$query = $this->db->get();
			switch ($return_type)
			{
				case 'array':
				case '':
					if($query->num_rows() > 0){$result = $query->result_array();}
					break;

				case 'row':
					if($query->num_rows() > 0){$result = $query->row_array();}
					break;

				case 'count':
					$result = $query->num_rows();
					break;

				default:
					$result=0;
					break;
			}
			//echo $this->db->last_query();die;
			return $result;
	 }


	function delete_data($id=0,$idfeild='',$table='')
	{
	 $this->db->where($idfeild,$id);
	 $query=$this->db->delete($table);
	 return $this->db->affected_rows();
	}

	function fetchOrderWithJoin($id , $where){
			$this->db->select('userorders.* , orderitems.*');
			$this->db->from('userorders');
			$this->db->join('orderitems' , 'orderitems.userorderid = userorders.userorderid');
			if($where == 'user'){
					$this->db->where('userorders.userid' , $id);
			}else{
					$this->db->where('userorders.userorderid' , $id);
			}

			$query = $this->db->get();
			if ($query->num_rows() > 0){
				return $query->row_array();
			}
			return array();

	}


}
