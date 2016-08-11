<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: undefined
 * Date: 16-8-8
 * Time: 下午3:04
 */
class Jingubang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('show_model');
        $this->load->helper('url_helper');
        session_start();
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('welcome_message');
        $this->load->view('templates/footer');
    }

    public function history()
    {

    }

    public function register()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = '注册新用户';

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['attributes'] = array('style' => '');
            $this->load->view('templates/header', $data);
            $this->load->view('user/register', $data);
            $this->load->view('templates/footer');

        } else {
            $data['msg'] = $this->show_model->register();
            $this->load->view('common/message', $data);
        }
    }

    public function sql()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('sql_model');

        $data['title'] = '金箍棒sql注入检测系统';

        $this->form_validation->set_rules('url', 'URL', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('common/sql');
            $this->load->view('templates/footer');
            $this->sql_model->saveTask("015b69afb83e9bcf");
        } else {
            $res = $this->sql_model->sql();

            $this->load->view('templates/header', $res);
            $this->load->view('user/myhistory', $res);
            $this->load->view('templates/footer');
        }

    }

    public function login()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('show_model');

        $data['title'] = '用户登陆';

        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "Password", "required");

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('user/login', $data);
            $this->load->view('templates/footer');
        } else {
            $res = $this->show_model->login();
            $this->load->view('user/location', $res);
        }
    }

    public function user()
    {
        if (isset($_SESSION['username']) && (!empty($_SESSION['username']))) {
            $res = $this->show_model->gethistory();
            $this->load->view('user/user', $res);
        } else {
            $data['msg'] = "登陆失败";
            $data['url'] = site_url("jingubang/login");
            $this->load->view("user/location",$data);
        }
    }

    public function logout()
    {
        $_SESSION['username'] = NULL;
        var_dump($_SESSION['username']);
    }
}