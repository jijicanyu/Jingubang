<?php

/**
 * Created by PhpStorm.
 * User: undefined
 * Date: 16-8-10
 * Time: 下午2:03
 */
class Sql_model extends CI_Model
{
    private $api = "http://127.0.0.1:8775";

    public function __construct()
    {
        $this->load->database();
    }


    public function sql()
    {
        $this->load->helper('url');
        $data = array(
            'url' => $this->input->post('url')
        );
        $data['url'] = $this->checkurl($data['url']);
        $json = $this->getNewTaskid();
        $id = $json['taskid'];
        $this->setOptionValue($id,"url",$data['url']);
        $res['engineid'] = $this->startScan($id);
        $res['taskid'] = $id;
        $res['api'] = $this->api;
        return $res;
    }

    public function startScan($taskid){
        require_once("application/libraries/Requests/library/Requests.php");
        Requests::register_autoloader();
        $scanurl = $this->getOptionValue($taskid,"url");
        $url = $this->api . "/scan/" . $taskid . "/start";
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $content = array(
            "url" => $scanurl
        );
        $options = array(
            "timeout" => 60
        );
        $content = json_encode($content);
        $response = Requests::post($url,$headers,$content,$options);
        $response = json_decode($response->body, true);
        if($response['success']){
            return $response['engineid'];
        }
        return -1;
    }

    public function getOptionValue($taskid, $opkey)
    {
        require_once("application/libraries/Requests/library/Requests.php");
        Requests::register_autoloader();
        $opkey = trim($opkey);
        $url = $this->api . "/option/" . $taskid . "/get";
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $content = array(
            "option" => $opkey
        );
        $options = array(
            "timeout" => 60
        );
        $content = json_encode($content);
        $response = Requests::post($url, $headers, $content, $options);
        $response = json_decode($response->body, true);
        if ($response['success'] = "true") {
            return $response[$opkey];
        } else {
            return "Unknown option";
        }

    }

    public function setOptionValue($taskid,$opkey,$opvalue){
        require_once("application/libraries/Requests/library/Requests.php");
        Requests::register_autoloader();
        $opkey = trim($opkey);
        $opvalue = trim($opvalue);
        $url = $this->api . "/option/" . $taskid . "/set";
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $content = array(
            $opkey => $opvalue
        );
        $options = array(
            "timeout" => 60
        );
        $content = json_encode($content);
        $response = Requests::post($url, $headers, $content, $options);
        $response = json_decode($response->body, true);
        return $response;
    }

    public function listOptions($taskid)
    {
        $json = json_decode(file_get_contents($this->api . '/option/' . $taskid . '/list'), true);
        if ($json['success'] == "true") {
            return $json;
        } else {
            return false;
        }
    }

    public function deleteTaskid($id)
    {
        $json = json_decode(file_get_contents($this->api . '/task/' . $id . '/delete'), true);
        return $json;
    }

    private function getNewTaskid()
    {
        $api = $this->api;
        $json = json_decode(file_get_contents($api . '/task/new'), true);
        if (!$json['success'] == "true") {
            die('获取taskid失败');
        }
        return $json;
    }

    private function checkurl($url)
    {
        $pattern = '/[\s]*(https?\:\/\/[^\s]+)[\s]*/';
        if (!preg_match($pattern, $url, $matchurl)) {
            $url = 'http://' . $url;
        } else {
            $url = $matchurl[1];
        }
        return $url;
    }

}

// get taskid http://192.168.1.173:8775/task/new