<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendas_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('comanda');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('id, users_id, cliente_id, precofinal, data, observacao, status, caixa_id, formapagamento');
		$this->db->where($condicao);
		$this->db->from('comanda');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function post($itens) {
		$res = $this->db->insert('comanda', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('id', $id, FALSE);
		$res = $this->db->update('comanda', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('id', $id, FALSE);
		return $this->db->delete('comanda');
	}

}
