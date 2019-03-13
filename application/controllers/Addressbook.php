<?php
/**
* @Programmer: Shrikrushna
* @Created: 13 March 2019
* @Modified: 
* @Description: Controller for all contact related operations
**/

defined('BASEPATH') OR exit('No direct script access allowed');

class Addressbook extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->template->set_layout('default');		
		$this->load->model('contact_model');	
	}
	
	/**
	 * show the list of current contact in the addressbook
	 *@param: null
	 *@return: Contact list 
	 */
	 
	public function index()
	{
		$this->template->build('addressbook/contact_listing');	
	}
	
	/**
	 * get list of all available contacts
	 *@param: null
	 *@return: Contact list 
	 */
	 
	public function all()
	{	
		$counts = $this->contact_model->get_conatct_counts();
		$this->load->library('pagination');
		$config['base_url'] = base_url().'/Company/index';
		$config['total_rows'] = $counts;
		$this->pagination->initialize($config);
		
		$contacts = $this->contact_model->get_all_conatct();
		
		$response = array('total' => $counts,
						'contacts' => $contacts);
		echo json_encode($response);
	}
	
	/**
	 * function for creating new contact
	 *@param: contact data
	 *@return: message
	 */
	 
	public function create()
	{
		
		$data['firstName'] = $this->input->post('firstName');
		$data['lastName'] = $this->input->post('lastName');
		$data['id'] = $this->input->post('id');		
		$contacts_id = $this->contact_model->add_edit_contact($data);
		
		if($data['id'] == ''){
			$response = array('status' => true, 'message' => "Contact inserted successfully");
		}else{
			$response = array('status' => true, 'message' => "Contact updated successfully");
		}
		echo json_encode($response);
	}
	
	/**
	 * Function to create contact details
	 *@param: contact details data
	 *@return: message
	 */
	 
	public function create_details()
	{
		
		$data['type'] = $this->input->post('type');
		$data['value'] = $this->input->post('value');
		$data['id'] = $this->input->post('id');		
		$data['contact_id'] = $this->input->post('contact_id');		
		$contacts_id = $this->contact_model->add_edit_contact_details($data);
		
		if($data['id'] == ''){
			$response = array('status' => true, 'message' => "Contact details inserted successfully");
		}else{
			$response = array('status' => true, 'message' => "Contact details updated successfully");
		}
		echo json_encode($response);
	}
	
	/**
	 * Delete records for contact
	 *@param: contact id
	 *@return: bool
	 */
	 
	public function delete_contact()
	{
		
		$id = $this->input->post('id');
		$this->contact_model->delete_contact($id);
		$response = array('status' => true, 'message' => "Contact deleted successfully");
		echo json_encode($response);
	}	
	
	/**
	 * Delete records for contact details
	 *@param: details id
	 *@return: bool
	 */
	 
	public function delete_contact_details()
	{
		
		$id = $this->input->post('id');
		$contact_id = $this->input->post('contact_id');
		$this->contact_model->delete_contact_details($id);
		$response = array('status' => true, 'message' => "Contact details deleted successfully",'contact_id'=>$contact_id);
		echo json_encode($response);
	}
	
	/**
	 * get details about contact
	 *@param: contact id
	 *@return: Contact details 
	 */
	 
	public function get_details()
	{	
		$id = $this->input->post('id');
		if($id != '')
		{
			$contact_details = $this->contact_model->get_contact_details($id);
			$response = array('details' => $contact_details);
			echo json_encode($response);
		}
	}
}