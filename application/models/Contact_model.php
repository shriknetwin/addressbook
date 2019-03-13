<?php
/**
* @Programmer: Shrikrushna
* @Created: 13 March 2019
* @Modified: 
* @Description: Contact model to manage all its operations
**/

class Contact_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	 * Function to get list blog categories
	 * @param: filter parameters
	 * @return: contact list
	 **/
	function get_all_conatct()
	{
		$order_by = $this->input->get('SortBy');
		$SortType = $this->input->get('SortType');
		$PerPage = $this->input->get('PerPage');
		$Page = $this->input->get('Page');
		$this->db->order_by($order_by, $SortType);
		//$this->db->order_by('id');
		$query  = $this->input->get('Search');
		if($query != '')
		{
			$this->db->like('firstName',$query);
			$this->db->or_like('lastName',$query);
		}
		if($Page == 1){
			$this->db->limit($PerPage);
		}else{
			$this->db->limit($PerPage,(($Page-1)*$PerPage));	
		}
		
		$query = $this->db->get('contact');
		//echo $last_query = $this->db->last_query();  
		return $query->result_array();
	}
	
	/**
	 * Function to get count of contacts
	 * @param: filter parameters
	 * @return: count
	 **/
	function get_conatct_counts()
	{
		$query  = $this->input->get('Search');
		if($query != '')
		{
			$this->db->like('firstName',$query);
			$this->db->or_like('lastName',$query);
		}
		$count = $this->db->count_all_results("contact");
		//echo $last_query = $this->db->last_query();  
		return $count;
	}
	
	/**
	 * Function to add/edit contact details
	 * @param: contact details
	 * @return: updated contact id
	 **/
	function add_edit_contact($data = null)
	{
		if($data != null)
		{
			if($data['id'] == '')
			{
				$this->db->insert('contact', $data);						
				return $this->db->insert_id();   	
			}else{
				$this->db->where('id', $data['id']);
				$this->db->update('contact', $data);	
				return $data['id'];   
			}			
		}		
	}
	
	/**
	 * Function to add/edit contact details
	 * @param: details
	 * @return: updated details id
	 **/
	function add_edit_contact_details($data = null)
	{
		if($data != null)
		{
			if($data['id'] == '')
			{
				$this->db->insert('contact_details', $data);						
				return $this->db->insert_id();   	
			}else{
				$this->db->where('id', $data['id']);
				$this->db->update('contact_details', $data);	
				return $data['id'];   
			}			
		}		
	}
	
	/**
	 * Function to delete contact 
	 * @param: contact id
	 * @return: null
	 **/
	function delete_contact($id = null)
	{
		if($id != null)
		{
			$this->db->where('id', $id);
			$this->db->delete('contact');			
		}		
	}
	
	/**
	 * Function to delete contact details
	 * @param: contact details id
	 * @return: null
	 **/
	function delete_contact_details($id = null)
	{
		if($id != null)
		{
			$this->db->where('id', $id);
			$this->db->delete('contact_details');			
		}		
	}
	
	/**
	 * Function to get contact details for provided contact id
	 * @param: contact id contact details
	 **/
	function get_contact_details($id = null)
	{
		if($id != null)
		{
			$this->db->order_by('id');	
			$this->db->where('contact_id', $id);
			$query = $this->db->get('contact_details');
			return $query->result_array();			
		}		
	}	
}
?>