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
                $res = 2;
            }
            else{
                $res =$this->db->insert('user',$data);
            }
            if($res == 1){
                $data = "注册成功";
            }
            elseif($res == 0){
                $data = "注册失败";
            }
            elseif($res == 2){
                $data = "用户名已存在";
            }
            return $data;
        }
    }