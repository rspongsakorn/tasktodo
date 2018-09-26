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

        $query_data = array();
        if(isset($_GET['subject']) && $_GET['subject']){
            $query_data['subject'] = $_GET['subject'];
        }

        if(isset($_GET['status']) && $_GET['status']){
            $query_data['status'] = $_GET['status'];
        }

        if(isset($_GET['order_by']) && $_GET['order_by']){
            $query_data['order_by'] = $_GET['order_by'];
        }

        if(isset($_GET['order_direction']) && $_GET['order_direction']){
            $query_data['order_direction'] = $_GET['order_direction'];
        }

        if(isset($_GET['offset']) && $_GET['offset']){
            $query_data['offset'] = $_GET['offset'];
        }

        if(isset($_GET['limit']) && $_GET['limit']){
            $query_data['limit'] = $_GET['limit'];
        }
        $tasks = $this->Task_model->getAllTask($query_data);
        if($tasks){
            $this->response($tasks, 200);
        }else{
            $this->response(array(), 200);
        }

    }
    
    public function view_get($id){

        $task = $this->Task_model->getTask($id);
        if($task){
            $this->response($task, 200);
        }else{
            $this->response(array("message" => "Task ID could not be found"), 404);
        }
    }

    public function create_post(){
        if(isset($_POST['subject'])){
            $data = array(
                'subject' => $_POST['subject'],
                'detail' => isset($_POST['detail']) ? $_POST['detail'] : "",
                'status' => isset($_POST['status']) && $_POST['status'] == "done" ? "done" : "pending"
            );
            $result = $this->Task_model->insertTask($data);
            if($result['result']){
                $this->response(array("message" => "The Task is successfully created"), 201);
            }else{
                $this->response(array("message" => "Fail to create task, Please try again later"), 500);
            }
        }else{
            $this->response(array("message" => "'subject' is required and could not be null"), 400);
        }

    }

    public function update_put($id){
        $task = $this->Task_model->getTask($id);
        if($task){
            $data = array();
            if($this->put('subject') && !empty($this->put('subject'))){
                $data['subject'] = $this->put('subject');
            }

            if($this->put('detail') && !empty($this->put('detail'))){
                $data['detail'] = $this->put('detail');
            }

            if($this->put('status') && !empty($this->put('status'))){
                $data['status'] = $this->put('status');
            }
            if($data){
                $result = $this->Task_model->updateTask($id, $data);
                if($result) {
                    $this->response(array("message" => "The Task is successfully updated"), 200);
                }else{
                    $this->response(array("message" => "Fail to update the task, Please try again later"), 500);
                }
            }else{
                $this->response(array("message" => "'subject' or 'detail' data is need for update"), 400);
            }

        }else{
            $this->response(array("message" => "Task ID could not be found"), 404);
        }
    }

    public function setStatus_put($id){
        $task = $this->Task_model->getTask($id);
        if($task){
            if (in_array($this->put('status'), array("done", "pending"))) {
                $data['status'] = ( $this->put('status') && ($this->put('status') == "done")) ? "done" : "pending";

                $result = $this->Task_model->updateTask($id, $data);
                if($result) {
                    $this->response(array("message" => "The Task's status is successfully set"), 200);
                }else{
                    $this->response(array("message" => "Fail to update the task, Please try again later"), 500);
                }
            }else{
                $this->response(array("message" => "Task's status could be 'pending' or 'done' only"), 404);
            }

        }else{
            $this->response(array("message" => "Task ID could not be found"), 404);
        }
    }

    public function delete_delete($id){
        $task = $this->Task_model->getTask($id);
        if($task){
            $result = $this->Task_model->deleteTask($id);
            if($result) {
                $this->response(array("message" => "The Task is successfully deleted"), 200);
            }else{
                $this->response(array("message" => "Fail to delete the task, Please try again later"), 500);
            }
        }else{
            $this->response(array("message" => "Task ID could not be found"), 404);
        }
    }
}