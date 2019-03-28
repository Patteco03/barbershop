<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('cliente');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('id, nome, observacao, email, telefone, cep, rua, cidade, bairro, uf, datanascimento');
		$this->db->where($condicao);
		$this->db->from('cliente');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function post($itens) {
		$res = $this->db->insert('cliente', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($itens, $id) {
		$this->db->where('id', $id, FALSE);
		$res = $this->db->update('cliente', $itens);
		if ($res) {
			return $id;
		} else {
			return FALSE;
		}
	}

	public function delete($id) {
		$this->db->where('id', $id, FALSE);
		return $this->db->delete('cliente');
	}

	public function validaEmailDuplicado($id, $email){
		$this->db->from('cliente');
		$this->db->where('email', $email, TRUE);
		$this->db->where('id !=', $id, TRUE);
		return $this->db->count_all_results();
	}

	public function countCliente(){
		$this->db->select('count(*)');
		$this->db->from('cliente');

		return $this->db->get()->result();
	}

}
