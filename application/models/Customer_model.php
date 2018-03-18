<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Customer Model
 */
class Customer_model extends CI_Model {

    var $table = "customer";
    var $select_column = array("id", "fullname", "email", "created_on");
    var $order_column = array("id", "fullname", "email", "created_on");

    function find_existing_customer($id) {
        $query = $this->db->where('id', $id)->get($this->table);
        return $query->row();        
    }
    
    function customer_create($email, $fullname) {
        $data = [
            'email' => $email,
            'fullname' => $fullname,
            'created_on' => time()
        ];
		// insert the new customer
		$this->db->insert($this->table, $data);
    }
    
    function customer_edit($id, $email, $fullname) {
        $data = [
            'email' => $email,
            'fullname' => $fullname
        ];
		// insert the new customer
		$this->db->update($this->table, $data, "id = $id");
    }
    
    function count_existing_customer($email) {
        $this->db->where('email', $email);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function count_existing_customer_except($id, $email) {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function make_query() {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("fullname", $_POST["search"]["value"]);
            $this->db->or_like("email", $_POST["search"]["value"]);
            $this->db->or_like("id", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }
    
    function delete_customer($customer_id){
        return $this->db->delete($this->table, array('id' => $customer_id));
    }

    function make_datatables() {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data() {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data() {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

}
