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
    
    public function customer_create()
	{
        $this->data = [
            'content' => 'customer/customer_create',
            'page_heading' => lang('customer_create_heading'),
            'javascript' => 'partials/customer/customer_create_javascript'
        ];
      
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}		        

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
    
    /**
	 * Edit a customer
	 *
	 * @param int|string $id
	 */
	public function customer_edit($id)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
        $this->load->model("Customer_model");
        
		$customer = $this->Customer_model->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'company' => $this->input->post('company'),
					'phone' => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					// Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData))
					{

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

				}

			}
		}
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
                                <a href="customer/customer_edit/'. $row->id . '" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
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
