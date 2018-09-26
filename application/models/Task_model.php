<?php
/**
 * Created by PhpStorm.
 * User: Pongsakorn
 * Date: 9/23/18
 * Time: 2:18 AM
 */

class Task_model extends CI_Model {

    function getAllTask($data){
        if(isset($data['subject'])){
            $this->db->like('subject', $data['subject']);
        }
        
        if(isset($data['status'])){
            $this->db->where('status', $data['status']);
        }
        
        if(isset($data['offset'])){
            $this->db->offset($data['offset']);
        }
        
        if(isset($data['limit'])){
            $this->db->limit($data['limit']);
        }

        $order_by = isset($data['order_by']) ? $data['order_by'] : "task_id";
        $order_direction = isset($data['order_direction']) ? $data['order_direction'] : "asc";

        $this->db->order_by($order_by, $order_direction);

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