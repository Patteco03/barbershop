<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_Model extends CI_Model {

    public function getTotal($condicao = array()) {
        $this->db->where($condicao);
        $this->db->from('users');
        return $this->db->count_all_results();
    }

    public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
        $this->db->select('id, name, email, username, password, salt, status, roles_id');
        $this->db->where($condicao);
        $this->db->from('users');

        if ($primeiraLinha) {
            return $this->db->get()->first_row();
        } else {
            $this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
            return $this->db->get()->result();
        }
    }

    public function post($itens) {
        $res = $this->db->insert('users', $itens);
        if ($res) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function update($itens, $id) {
        $this->db->where('id', $id, FALSE);
        $res = $this->db->update('users', $itens);
        if ($res) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
        $this->db->where('id', $id, FALSE);
        return $this->db->delete('users');
    }

    public function validaEmailDuplicado($id, $email){
        $this->db->from('users');
        $this->db->where('email', $email, TRUE);
        $this->db->where('id !=', $id, TRUE);
        return $this->db->count_all_results();
    }

    public function ValidaUsuarioDuplicado($id, $username){
        $this->db->from('users');
        $this->db->where('username', $username, TRUE);
        $this->db->where('id !=', $id, TRUE);
        return $this->db->count_all_results();
    }
}
