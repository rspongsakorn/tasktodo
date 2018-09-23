<?php
/**
 * Created by PhpStorm.
 * User: Pongsakorn
 * Date: 9/23/18
 * Time: 2:18 AM
 */

class Task_model extends CI_Model {

    function getTask($id){
        $this->db->where('task_id', $id);
        $query = $this->db->get('tasks');
        return $query->row_array();
    }


    function getAllTask(){
        $query = $this->db->get('tasks');
        return $query->result_array();
    }

    function insertTask($data){
        $this->db->insert('tasks', $data);
    }
    
    function updateTask($id, $data){
        $this->db->where('task_id', $id);
        $this->db->set( $data);
        $this->db->update('tasks');
    }

    function deleteTask($id){
        $this->db->where('task_id', $id);
        $this->db->delete('tasks');
    }


}