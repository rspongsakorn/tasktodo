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
    
    public function viewAll_get(){

        $tasks = $this->Task_model->getAllTask();
        $this->response($tasks, 200);
    }
    
    public function view_get($id){

        $task = $this->Task_model->getTask($id);
        if($task){
            $this->response($task, 200);
        }else{
            $this->response(array("status" => "Task ID could not be found"), 404);
        }
    }

    public function create_post(){
        
        $data = array(
            'subject' => $this->input->post('subject'),
            'detail' => $this->input->post('detail'),
            'is_done' => $this->input->post('is_done') ? 1 : 0
        );
        $result = $this->Task_model->insertTask($data);
        if($result){
            $this->response(array("status" => "The Task is successfully created",
                "data" => $data), 201);
        }else{
            $this->response(array("status" => "Fail to create task, Please try again later"), 500);
        }
    }

    public function update_put($id){
        $task = $this->Task_model->getTask($id);
        if($task){
            $data = array(
                'subject' => $this->input->get('subject'),
                'detail' => $this->input->get('detail'),
                'is_done' => $this->input->get('is_done')
            );
            $result = $this->Task_model->updateTask($id, $data);
            if($result) {
                $this->response(array("status" => "The Task is successfully updated"), 200);
            }else{
                $this->response(array("status" => "Fail to update the task, Please try again later"), 500);
            }
        }else{
            $this->response(array("status" => "Task ID could not be found"), 404);
        }
    }

    public function delete_delete($id){
        $task = $this->Task_model->getTask($id);
        if($task){
            $result = $this->Task_model->deleteTask($id);
            if($result) {
                $this->response(array("status" => "The Task is successfully deleted"), 204);
            }else{
                $this->response(array("status" => "Fail to delete the task, Please try again later"), 500);
            }
        }else{
            $this->response(array("status" => "Task ID could not be found"), 404);
        }
    }
}