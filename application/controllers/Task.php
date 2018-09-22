<?php
/**
 * Created by PhpStorm.
 * User: Pongsakorn Ruadsong
 * Date: 9/23/18
 * Time: 2:09 AM
 */

require (APPPATH.'/libraries/REST_Controller.php');
class Task extends REST_Controller {
    
    public function list_get(){

        $this->load->model('Task_model');
        $data = $this->Task_model->getAll();
        $this->response($data, 200);
    }
}