<?php
/**
 * Created by PhpStorm.
 * User: undefined
 * Date: 16-8-8
 * Time: 下午3:34
 */
    class Show_model extends CI_Model{
        public function __construct()
        {
            $this->load->database();
        }
        public function register(){
            $this->load->helper('url');

            $data = array(
                'username'=>$this->input->post('username'),
                'password'=>md5($this->input->post('password')),
                'email'=>$this->input->post('email'),
                'mobile'=>$this->input->post('mobile')
            );
            $query = $this->db->get_where('user',array('username'=>$data['username']));
            if($query->row_array() !== NULL){
                return 2;
            }
            else{
                return $this->db->insert('user',$data);
            }
        }
    }