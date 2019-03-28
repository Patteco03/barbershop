<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_Model extends CI_Model {

	public function getTotal($condicao = array()) {
		$this->db->where($condicao);
		$this->db->from('product');
		return $this->db->count_all_results();
	}

	public function get($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('id, category_id, nome, preco, observacao');
		$this->db->where($condicao);
		$this->db->from('product');

		if ($primeiraLinha) {
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			return $this->db->get()->result();
		}
	}

	public function qtdServicoBarbeiro($id = null, $datainicio = null, $datafinal = null){
		$this->db->select('com.valor, count(service_id) as "qtdCortes", b.nome, b.id, sum(com.valor) as "valorTotal"');
		$this->db->where("co.data between  '$datainicio' and '$datafinal'");
		$this->db->where("b.id = $id");
		$this->db->from('comanda_service c');
		$this->db->join('barber b','c.barber_id=b.id','inner');
		$this->db->join('comanda co','co.id=c.comanda_id','inner');
		$this->db->join('service s','s.id=c.service_id','left');
		$this->db->join('comissao com','com.id = s.comissao_id','inner');
		$this->db->group_by('b.nome');

		return $this->db->get()->result();
	}

	public function slcComandaPorBarber($id = null, $datainicio = null, $datafinal = null){
		$this->db->select('b.nome, co.data, com.valor, comanda_id, s.nome, s.preco');
		$this->db->where("co.data between  '$datainicio' and '$datafinal'");
		$this->db->where("b.id = $id");
		$this->db->from('comanda_service c');
		$this->db->join('barber b','c.barber_id=b.id','inner');
		$this->db->join('comanda co','co.id=c.comanda_id','inner');
		$this->db->join('service s','s.id=c.service_id','left');
		$this->db->join('comissao com','com.id = s.comissao_id','inner');

		return $this->db->get()->result();
	}

	public function slcComandaPorProduto($datainicio = null, $datafinal = null){
		$this->db->select('p.nome, p.preco, co.data, co.id, count(co.id) as "QtdPorComanda", e.quantidade as "QtdEstoque", sum(p.preco) as "ValorUniPorQtd"');
		$this->db->where("co.data between  '$datainicio' and '$datafinal'");
		$this->db->from('comanda_product c');
		$this->db->join('product p','c.product_id = p.id','inner');
		$this->db->join('estoque e','e.product_id = p.id','inner');
		$this->db->join('comanda co','co.id=c.comanda_id','inner');
		$this->db->group_by('co.id, p.nome, p.preco');

		return $this->db->get()->result();
	}

	public function slcPagamento($datainicio = null, $datafinal = null){
		$this->db->select('p.nome, p.data, p.valor, p.observacao, sum(p.valor) as "ValorSaida"');
		$this->db->where("p.data between  '$datainicio' and '$datafinal'");
		$this->db->from('pagamento p');
		$this->db->join('caixa c','p.caixa_id = c.id','inner');
		$this->db->group_by('p.valor');

		return $this->db->get()->result();
	}

	public function slcVendas($datainicio = null, $datafinal = null){
		$this->db->select('co.id, co.data, cl.nome, co.precofinal');
		$this->db->where("co.data between  '$datainicio' and '$datafinal'");
		$this->db->from('caixa c');
		$this->db->join('comanda co','co.caixa_id = c.id','inner');
		$this->db->join('cliente cl','co.cliente_id = cl.id','inner');


		return $this->db->get()->result();
	}

	public function comanda_product($condicao = array()) {
		
		$this->db->where($condicao);
		$this->db->from('comanda_product');
		
		return $this->db->get()->result();
		
	}

	public function comanda_service($condicao = array()) {

		$this->db->where($condicao);
		$this->db->from('comanda_service');
		
		return $this->db->get()->result();
		
	}








}
