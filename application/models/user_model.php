<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    function __construct()
    {
      parent::__construct();
    }
    
    function set_data($user, $data)
    {
      $this->db->insert($user, $data);
      return true;
    }

    function set_temp($id, $user)
    {
      $this->db->insert('temp_'.$user, $id);
    }

    function get_temp($user)
    {
      $data = '';
      $query = $this->db->get('temp_'.$user);
      if($query->num_rows != 0) {
        $row = $query->row();
        $data = $row->temp_id;
      }

      $this->delete_temp($data, $user);

      return $data;
    }

    private function delete_temp($id, $user)
    {
      $this->db->where('temp_id', $id);
      $this->db->delete('temp_'.$user);
    }

    function update_data($id, $user, $data)
    {
      $this->db->where($user.'_id', $id);
      $this->db->update($user, $data);
      return true;
    }

    function delete_data($id, $user)
    {
      $this->db->where($user.'_id', $id);
      $this->db->delete($user);
      return true;
    }

    function get_all_user($user)
    {
      if ($user == 'asisten') {
        $this->db->order_by("grade", "asc"); 
        $query = $this->db->get('asisten');
        return $query->result_array();
      }
      if ($user == 'dosen') {
        $this->db->order_by("name", "asc"); 
        $query = $this->db->get('dosen');
        return $query->result_array();
      }
    }

    function get_count($user)
    {
      return $count = $this->db->count_all($user);
    }

    function get_asisten($id)
    {
      $this->db->where('asisten_id', $id);
      $query = $this->db->get('asisten');
      return $query->row_array();
    }

    function get_dosen($id)
    {
      $this->db->where('dosen_id', $id);
      $query = $this->db->get('dosen');
      return $query->row_array();
    }

    function get_name($user)
    {
      $i = 0;
      $data = array();
      $query = mysql_query("SELECT ".$user."_id, name from $user");
      while($row = mysql_fetch_array($query)) {
        $data[$i] = array($user.'_id' => $row[$user.'_id'], 'name' => $row['name']);
        $i++;
      }
      return $data;
    }
}
?>