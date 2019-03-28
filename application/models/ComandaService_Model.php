<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComandaService_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('comanda_service');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('comanda_id, service_id, barber_id');
		$this->db->where($condicao);
		$this->db->from('comanda_service');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function post($itens) {
		$res = $this->db->insert('comanda_service', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('comanda_id', $id, FALSE);
		$res = $this->db->update('comanda_service', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('comanda_id', $id, FALSE);
		return $this->db->delete('comanda_service');
	}

}
