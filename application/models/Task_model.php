<?php
/**
 * Created by PhpStorm.
 * User: Pongsakorn
 * Date: 9/23/18
 * Time: 2:18 AM
 */

class Task_model extends CI_Model {

    function getAllTask(){
        $query = $this->db->get('tasks');
        return $query->result_array();
    }
    
    function getTask($id){
        $this->db->where('task_id', $id);
        $query = $this->db->get('tasks');
        return $query->row_array();
    }

    function insertTask($data){
        $result = $this->db->insert('tasks', $data);
        return $result;
    }
    
    function updateTask($id, $data){
        $this->db->where('task_id', $id);
        $this->db->set( $data);
        $result = $this->db->update('tasks');
        return $result;
    }

    function deleteTask($id){
        $this->db->where('task_id', $id);
        $result = $this->db->delete('tasks');
        return $result;
    }


}