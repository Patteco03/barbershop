<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movimentacao_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('movimentacao');
		return $this->db->count_all_results();
	}

	public function get($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('movimentacao');

		return $this->db->get()->result();
	}

	public function post($itens) {
		$res = $this->db->insert('movimentacao', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('id', $id, FALSE);
		$res = $this->db->update('movimentacao', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('id', $id, FALSE);
		return $this->db->delete('movimentacao');
	}

}
