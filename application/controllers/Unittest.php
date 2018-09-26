<?php
require (APPPATH.'/libraries/REST_Controller.php');
class Unittest extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');
        $this->load->model('Task_model');
        $this->unit->set_test_items(array('test_name', 'result', 'notes'));
    }
    
    public function index_get()
    {
        echo nl2br("<b>TODO Task list API - unit testing\n\n\n");

// **************************************************************
// test creating a Task
// **************************************************************
        $test_name = "Test task create ";
        echo nl2br("<b>$test_name\n");
        $insert_data = array(
            'subject' => "subject for unit testing",
            'detail'  => "detail for unit testing",
            'status'  => "pending"
        );
        $result = $this->Task_model->insertTask($insert_data);

        $task_id = $result['insert_id']."";
        $expected_data = array(
            'task_id' => $task_id,
            'subject' => "subject for unit testing",
            'detail'  => "detail for unit testing",
            'status'  => "pending"
        );
        $result_data = $this->Task_model->getTask($task_id);
        $noted = "Create a task and check that the data is inserted correctly";
        echo "expected result : ".json_encode($expected_data).nl2br("\n");
        echo "returned result : ".json_encode($result_data);
        echo $this->unit->run($result_data, $expected_data, $test_name, $noted);
        echo nl2br("\n");


// **************************************************************
// test searching Task
// **************************************************************
        $test_name = "Test task search";
        echo nl2br("<b>$test_name\n");
        $query_data = array('subject'=>$expected_data['subject']);
        $result_data = $this->Task_model->getAllTask($query_data);
        $noted = "Search task by subject and check whether the return result is correct";
        echo "expected result : ".json_encode(array($expected_data)).nl2br("\n");
        echo "returned result : ".json_encode($result_data);
        echo $this->unit->run($result_data, array($expected_data), $test_name, $noted);
        echo nl2br("\n");


// **************************************************************
// test updating Task's detail
// **************************************************************
        $test_name = "Test task update detail";
        echo nl2br("<b>$test_name\n");
        $update_data = array(
            'subject' => "updated subject for unit testing",
            'detail'  => "updated detail for unit testing",
        );

        $expected_data = array(
            'task_id' => $task_id,
            'subject' => "updated subject for unit testing",
            'detail'  => "updated detail for unit testing",
            'status'  => "pending"
        );

        $this->Task_model->updateTask($task_id, $update_data);
        $result_data = $this->Task_model->getTask($task_id);
        $noted = "update the task's detail and check whether the data is changed correctly";
        echo "expected result : ".json_encode($expected_data).nl2br("\n");
        echo "returned result : ".json_encode($result_data);
        echo $this->unit->run($result_data, $expected_data, $test_name, $noted);
        echo nl2br("\n");


// **************************************************************
// test seting Task's status
// **************************************************************
        $test_name = "Test task set status";
        echo nl2br("<b>$test_name\n");
        $update_data = array(
            'status' => "done"
        );

        $expected_data = array(
            'task_id' => $task_id,
            'subject' => "updated subject for unit testing",
            'detail'  => "updated detail for unit testing",
            'status'  => "done"
        );

        $this->Task_model->updateTask($task_id, $update_data);
        $result_data = $this->Task_model->getTask($task_id);
        $noted = "set the task's status and check whether the data is changed correctly";
        echo "expected result : ".json_encode($expected_data).nl2br("\n");
        echo "returned result : ".json_encode($result_data);
        echo $this->unit->run($result_data, $expected_data, $test_name, $noted);
        echo nl2br("\n");


// **************************************************************
// test deleting Task
// **************************************************************
        $test_name = "Test task delete";
        echo nl2br("<b>$test_name\n");
        $expected_data = null;
        $this->Task_model->deleteTask($task_id);
        $result_data = $this->Task_model->getTask($task_id);
        $noted = "deleted the task and check whether the data is completely removed";
        echo "expected result : ".json_encode($expected_data).nl2br("\n");
        echo "returned result : ".json_encode($result_data);
        echo $this->unit->run($result_data, $expected_data, $test_name, $noted);
        echo nl2br("\n");
    }
}
