<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComandaProduto_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('comanda_product');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('comanda_id, product_id');
		$this->db->where($condicao);
		$this->db->from('comanda_product');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function post($itens) {
		$res = $this->db->insert('comanda_product', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('comanda_id', $id, FALSE);
		$res = $this->db->update('comanda_product', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('comanda_id', $id, TRUE);
		return $this->db->delete('comanda_product');
	}

}
