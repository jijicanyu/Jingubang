<?php
/**
 * Created by PhpStorm.
 * User: undefined
 * Date: 16-8-10
 * Time: 下午2:03
 */
    class Sql_model extends CI_Model{
        public function __construct()
        {
            $this->load->database();
        }
        public function sql(){
            $this->load->helper('url');
            $data = array(
                'sqlmapapi'=>$this->input->post('sqlmapapi'),
                'url'=>$this->input->post('url')
            );
            echo $data;


        }

    }

    // get taskid http://192.168.1.173:8775/task/new
i feel never so good;
i_never_feel_so_good.