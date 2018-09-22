<?php
/**
 * Created by PhpStorm.
 * User: Pongsakorn
 * Date: 9/23/18
 * Time: 2:18 AM
 */

class Task_model extends CI_Model {

    function getAll(){
        $q  = $this->db->query("SELECT * from task");
        if($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data [] = $row;
            }
            return $data;
        }
    }
}