<?php
/**
 * Created by PhpStorm.
 * User: Pongsakorn Ruadsong
 * Date: 9/23/18
 * Time: 2:09 AM
 */

require (APPPATH.'/libraries/REST_Controller.php');
class Task extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Task_model');
    }

    public function view_get($id){
        
        $data = $this->Task_model->getTask($id);
        $this->response($data, 200);
    }
    
    public function viewAll_get(){
        
        $data = $this->Task_model->getAllTask();
        $this->response($data, 200);
    }

    public function create_post(){
        
        $data = array(
            'subject' => $this->input->post('subject'),
            'detail' => $this->input->post('detail'),
            'is_done' => $this->input->post('is_done')
        );
        $result = $this->Task_model->insertTask($data);
        $this->response(array("status"=>"success"), 201);
    }

    public function update_put($id){
        
        $data = array(
            'subject' => $this->input->get('subject'),
            'detail' => $this->input->get('detail'),
            'is_done' => $this->input->get('is_done')
        );
        $result = $this->Task_model->updateTask($id, $data);
        $this->response(array("status"=>"success"), 200);
    }

    public function delete_delete($id){
        
        $data = $this->Task_model->deleteTask($id);
        $this->response($data, 204);
    }
}