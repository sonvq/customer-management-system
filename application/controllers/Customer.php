<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Customer 
 */
class Customer extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('customer');
        $this->lang->load('common');
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
            $this->data = [
                'content' => 'customer/index',
                'javascript' => 'partials/customer/index_javascript',
                'extra_footer' => 'partials/customer/index_extra_footer',
                'page_heading' => lang('customer_index_heading')
            ];
			$this->_render_page('layout/master', $this->data);
		}
	}
    
    public function customer_create_ajax() {
        $this->load->model("Customer_model"); 
        
        $email = $this->input->post('email');
        $fullname = $this->input->post('fullname');
        
        if (empty($email) ||empty($fullname)) {
            echo json_encode([
                "status" => "error",
                "message" => lang('customer_create_email_fullname_required')
            ]);
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "status" => "error",
                "message" => lang('customer_create_email_invalid_format')
            ]);
        } else {
            // Check if there is already customer email created
            $count = $this->Customer_model->count_existing_customer($email); 
            if ($count > 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => lang('customer_existed')
                ]);
            } else {
                // Success validation, start create new customer record
                $this->Customer_model->customer_create($email, $fullname); 
                echo json_encode([
                    "status" => "success",
                    "message" => lang('customer_create_success')
                ]);
            }
        }
    }
    
    public function customer_create()
	{        
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}	
        
        $this->data = [
            'content' => 'customer/customer_create',
            'page_heading' => lang('customer_create_heading'),
            'javascript' => 'partials/customer/customer_create_javascript'
        ];
      	        
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'email',
            'class' => 'form-control',
            'placeholder' => lang('customer_email_label'),
            'required' => true
        );
       
        $this->data['fullname'] = array(
            'name' => 'fullname',
            'id' => 'fullname',
            'class' => 'form-control',
            'placeholder' => lang('customer_fullname_label'),
            'type' => 'text',
            'required' => true
        );
          
        $this->data['submit'] = array('name' => 'submit',
            'id' => 'submit',
            'type' => 'submit',
            'class' => 'btn btn-primary btn-flat pull-left submit-create-customer',
        );
                    
        $this->_render_page('layout/master', $this->data);
	}
    
    public function customer_edit_ajax($id) {
        $this->load->model("Customer_model"); 
        
        $email = $this->input->post('email');
        $fullname = $this->input->post('fullname');
        
        if (empty($email) ||empty($fullname)) {
            echo json_encode([
                "status" => "error",
                "message" => lang('customer_create_email_fullname_required')
            ]);
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "status" => "error",
                "message" => lang('customer_create_email_invalid_format')
            ]);
        } else {
            // Check if there is already customer email created
            $count = $this->Customer_model->count_existing_customer_except($id, $email); 
            if ($count > 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => lang('customer_existed')
                ]);
            } else {
                // Success validation, start create new customer record
                $this->Customer_model->customer_edit($id, $email, $fullname); 
                echo json_encode([
                    "status" => "success",
                    "message" => lang('customer_update_success')
                ]);
            }
        }
    }
    
    /**
	 * Edit a customer
	 *
	 * @param int|string $id
	 */
	public function customer_edit($id)
	{
        $this->load->model("Customer_model"); 
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
        
        $existingCustomer = $this->Customer_model->find_existing_customer($id);        
        if (empty($existingCustomer)) {
            redirect('auth', 'refresh');
        }
        
		$this->data = [
            'content' => 'customer/customer_edit',
            'page_heading' => lang('customer_edit_heading'),
            'javascript' => 'partials/customer/customer_edit_javascript',
            'id' => $id
        ];      				        

       $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'email',
            'class' => 'form-control',
            'value' => $existingCustomer->email,
            'placeholder' => lang('customer_email_label'),
            'required' => true
        );
       
        $this->data['fullname'] = array(
            'name' => 'fullname',
            'id' => 'fullname',
            'class' => 'form-control',
            'value' => $existingCustomer->fullname,
            'placeholder' => lang('customer_fullname_label'),
            'type' => 'text',
            'required' => true
        );
          
        $this->data['submit'] = array('name' => 'submit',
            'id' => 'submit',
            'type' => 'submit',
            'class' => 'btn btn-primary btn-flat pull-left submit-create-customer',
        );
                    
        $this->_render_page('layout/master', $this->data);
    }
    
    public function customer_destroy($customer_id = null) {
        $this->load->model("Customer_model"); 
        if (!empty($customer_id)) {
            $this->Customer_model->delete_customer($customer_id);                  
            echo json_encode([
                "status" => "success",
                "message" => lang('customer_delete_success')
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => lang('bad_request')
            ]);
        }
    }
    
    public function customer_ajax() {
        $this->load->model("Customer_model");  
        $fetch_data = $this->Customer_model->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->fullname;
            $sub_array[] = $row->email;
            $sub_array[] = date("d F Y H:i", $row->created_on);
            $sub_array[] = '<div class="btn-group">
                                <a href="' . base_url() . 'customer/customer_edit/'. $row->id . '" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="'. base_url() . 'customer/customer_destroy/' . $row->id . '"><i class="fa fa-trash"></i></button>
                            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->Customer_model->get_all_data(),
            "recordsFiltered" => $this->Customer_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

}
