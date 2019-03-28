<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caixa_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('caixa');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('id, nome, saldo, status');
		$this->db->where($condicao);
		$this->db->from('caixa');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function post($itens) {
		$res = $this->db->insert('caixa', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('id', $id, FALSE);
		$res = $this->db->update('caixa', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('id', $id, FALSE);
		return $this->db->delete('caixa');
	}

}
