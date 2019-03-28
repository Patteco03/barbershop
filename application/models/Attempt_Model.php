<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Attempt_Model extends CI_Model{

	public function TotalDeTentaticas($condicao = array()) {
        $this->db->where($condicao);
        $this->db->from('login_attempts');
        return $this->db->count_all_results();
    }


    public function RegistrarTentativa($itens)
    {
        $res = $this->db->insert('login_attempts', $itens);
        if ($res) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function LimparTentativas($user_id){
    	$this->db->where('users_id', $user_id, FALSE);
        return $this->db->delete('login_attempts');
    }

    

	/*

	 public static function TotalDeTentaticas($condicao = array()) {
        $this->db->where($condicao);
        $this->db->from('login_attempts');
        return $this->db->count_all_results();
    }

    public static function RegistrarTentativa($itens){
   		$res = $this->db->insert('login_attempts', $itens);
        if ($res) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public static function LimparTentativas($user_id){
    	$this->db->where('user_id', $user_id, FALSE);
        return $this->db->delete('login_attempts');
    }

    */


}