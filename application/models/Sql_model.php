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
        require_once("application/libraries/Requests/library/Requests.php");
        Requests::register_autoloader();
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
        $this->saveTask($id);
        $res['api'] = $this->api;
        $res['url'] = $data['url'];
        return $res;
    }

    public function startScan($taskid){
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
        $user['taskid'] = $taskid;
        $user['uid'] = $_SESSION['username'];
        if($response['success']){
            $this->db->insert('history',$user);
            return $response['engineid'];
        }
        $this->error();
    }

    public function saveTask($taskid){
        $status = $this->isFinish($taskid);
        if($status == "terminated"){
            $this->save($taskid);
        }
        return $status;
    }

    private function save($taskid){
        $data['taskid'] = $taskid;
        $data['url'] = $this->getOptionValue($taskid,'url');
        $res = $this->getscan($taskid);
        $data['isVulnerable'] = $res['isVulnerable'];
        $data['HttpMethod'] = $res['place'];
        $data['banner'] = "os:".$res['os'].";dbms:".$res['dbms'];
        $data['parameter'] = $res['parameter'];
        $this->db->insert('Jingubang',$data);
        $log['taskid'] = $taskid;
        $log['details'] = $res['log'];
        $this->db->insert('log',$log);

    }

    public function getscan($taskid){
        $url = $this->api.'/scan/'.$taskid.'/data';
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $options = array(
            "timeout" => 60
        );
        $response = Requests::get($url,$headers,$options);
        $response = $response->body;
        $response = json_decode($response,true);
        $res['isVulnerable'] = !empty($response['data']);
        if(!$res['isVulnerable']){
            return $res;
        }
        $response= $response['data'][0]['value'][0];
        $res['dbms'] = $response['dbms'][0];
        $res['place'] = $response['place'];
        $res['os'] = $response['os'];
        $res['parameter'] = $response['parameter'];
        $res['data'] = json_encode($response['data']);
        $res['log'] = $this->getlog($taskid);
        return $res;
    }

    private function getlog($taskid){
        $url = $this->api.'/scan/'.$taskid.'/log';
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $options = array(
            "timeout" => 60
        );
        $response = Requests::get($url,$headers,$options);
        $response = $response->body;
        return $response;
    }

    private function isFinish($taskid){
        $url = $this->api.'/scan/'.$taskid.'/status';
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $options = array(
            "timeout" => 60
        );
        $response = Requests::get($url,$headers,$options);
        $response = json_decode($response->body,true);
        if($response['success']){
            return $response['status'];
        }
        else{
            $this->error();
        }
    }

    public function error($msg=""){
        $msg = "出现未知错误:".$msg." at:".date('y-m-d h:i:s',time()).PHP_EOL;
        file_put_contents("error.log",$msg,FILE_APPEND);
    }

    public function getOptionValue($taskid, $opkey)
    {
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
