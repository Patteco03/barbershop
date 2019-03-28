<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HistoricoCaixa_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('historicocaixa');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('id, data, valor, caixa_id');
		$this->db->where($condicao);
		$this->db->from('historicocaixa');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function post($itens) {
		$res = $this->db->insert('historicocaixa', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('id', $id, FALSE);
		$res = $this->db->update('historicocaixa', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('id', $id, FALSE);
		return $this->db->delete('historicocaixa');
	}

	public function validaDataDuplicada($id, $data){
		$this->db->from('historicocaixa');
		$this->db->where('data', $data, TRUE);
		$this->db->where('id !=', $id, TRUE);
		return $this->db->count_all_results();
	}

}
