<?php

class Employee_Model extends CI_Model{

    function __construct(){
        
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    
    //insert employee details to employee table
    public function insertEmployee($data){
        
        return $this->db->insert('employee',$data);
      
    }
    
    public function loginUser($username, $password){
        //$this->db->where(array('username' = >$username, 'password' => $password));
        $query = $this->db->get_where('employee', array('username' => $username, 'password' => $password,'status'=> 0));   //status sholud be 1
        
        if($query->num_rows() == 1){
            
            $userArr = array();
            foreach($query->result() as $row){
                $userArr[0] = $row->emp_id;
                $userArr[1] = $row->emp_name;
                
            }
            $userData = array(
                'emp_id' => $userArr[0],
                'emp_name' => $userArr[1],
                'logged_in'=> TRUE
            );
            $this->session->set_userdata($userData);
            
            return $query->result();
        }else{
            return false;
        }
    }
    
    
   
    
    //activate account
    function verifyEmail($key){
        $data = array('status' => 1);
        $this->db->where('md5(email)',$key);
        return $this->db->update('employee', $data);    //update status as 1 to make active user
    }
    
}

?>