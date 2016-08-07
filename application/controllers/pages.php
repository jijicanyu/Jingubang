<?php
/**
 * Created by PhpStorm.
 * User: undefined
 * Date: 16-8-7
 * Time: 下午3:36
 */
    class pages extends CI_Controller {
        public function view($page = 'home'){
            if(!file_exists(APPPATH.'/views/pages'.$page.'.php'))
            {
                show_404();
            }
            $data['title'] = ucfirst($page);

            $this->load->view('templates/header',$data);
            $this->load->view('pages'.$page,$data);
            $this->load->view('templates/footer',$data);
        }
    }