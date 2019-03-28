<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Rio_Branco');

class Relatorio extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Barber_Model', 'BarberM');
		$this->load->model('Relatorio_Model', 'RelatorioM');
		$this->load->model('ComandaProduto_Model', 'ComanpM');
		$this->load->model('ComandaService_Model', 'ComansM');
		$this->load->model('Product_Model', 'ProdutoM');
		$this->load->model('Service_Model', 'ServiceM');
	}

	public function index()
	{
		$data = array();

		$this->parser->parse('painel/relatorio_listar', $data);
	}

	public function getDateVendas()
	{
		$dataInicio = $this->input->post('datainicio');
		$dataFinal = $this->input->post('datafinal');

		$dataAtual = strftime('%A, %d de %B de %Y', strtotime('today'));

		$res = $this->RelatorioM->slcVendas($dataInicio, $dataFinal);
		$listProduto = array();
		$listServicos = array();
		$html = '
		<html><head>
		<style>
		.text-center {text-align: center;}
		.cabeca {font-weight: bolder;}
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
		</style>
		</head>
		<body>
		<h1>Relatório de Vendas</h1>
		<h4>Dados Gerais de vendas realizadas entre determinadas datas</h4>
		<table class="tg" cellspacing="0" width="100%">
		<thead class="text-primary">
		<tr>
		<th  class="cabeca" style="width: 5%;">Código</th>
		<th  style="width: 40%;">Nome Cliente</th>
		<th  style="width: 20%;">Data</th>
		<th  style="width: 40%;">Valor da conta</th>
		</tr>
		</thead>
		<tbody>';
		$valorTotal = 0;
		foreach ($res as $dados) {
			$comandaProduto = $this->ComanpM->get(array("comanda_id" => $dados->id), FAlSE, FALSE);
			$cpService = $this->ComansM->get(array("comanda_id" => $dados->id), FAlSE, FALSE);
			$html .= '<tr>';
			$html .= '<td class="text-center">' . $dados->id . '</td>';
			$html .= '<td>'. $dados->nome . '<br><br>Produtos e Servicos';


			if ($comandaProduto) {
				foreach ($comandaProduto as $cp) {
					$llproduto = $this->ProdutoM->get(array("id" => $cp->product_id), FALSE, FALSE);
					foreach ($llproduto as $p) {
						$valorTotal += $p->preco;
						$html .='<div>'.$p->nome.' ------------ R$ '.$p->preco.'</div>';
					}
				}
			}

			if ($cpService) {
				foreach ($cpService as $cp) {
					$llproduto = $this->ServiceM->get(array("id" => $cp->service_id), FALSE, FALSE);
					foreach ($llproduto as $p) {
						$valorTotal += $p->preco;
						$html .='<div>'.$p->nome.' ------------ R$ '.$p->preco .'</div>';
					}
				}
			}

			'</td>';
			$html .= '<td class="text-center">' . inverteData($dados->data) . '</td>';
			$html .= '<td class="text-center"> R$ ' . $dados->precofinal . ' </td>';
			$html .= '</tr>';
			$valorTotal = number_format($valorTotal,2,'.', '');
		}
		$html .='</tbody>
		<tfoot>';
		$html .= '<br>';
		$html .= '<tr>';
		$html .= '<td class="text-center" style="width: 30%;border-right:none;"> Valor Total de Vendas</td>';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td class="text-center"> R$ ' . $valorTotal . ' </td>';
		$html .= '</tr>';
		$html .= '</tfoot>
		</table>
		</body>
		</html>
		';


		$data = array();
		$data['data'] = $html;

		$this->parser->parse('relatorios/view_datevendas', $data);


	}

	public function getDatePagamentos()
	{
		$dataInicio = $this->input->post('datainicio');
		$dataFinal = $this->input->post('datafinal');

		$dataAtual = strftime('%A, %d de %B de %Y', strtotime('today'));

		$res = $this->RelatorioM->slcPagamento($dataInicio, $dataFinal);

		$html = '
		<html><head>
		<style>
		.text-center {text-align: center;}
		.cabeca {font-weight: bolder;}
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
		</style>
		</head>
		<body>
		<h1>Relatório de Pagamentos (Saída)</h1>
		<h4>Lista de Pagamentos </h4>
		<table class="tg" cellspacing="0" width="100%">
		<thead class="text-primary">
		<tr>
		<th  style="width: 30%;">Nome</th>
		<th  style="width: 20%;">Data de Registro</th>
		<th  style="width: 50%;">Observacao</th>
		<th  style="width: 20%;">Valor</th>
		</tr>
		</thead>
		<tbody>';
		$valorTotal = 0;
		foreach ($res as $dados) {
			$valor_descontado =  $dados->valor;
			$valorTotal += $dados->ValorSaida;
			$valorTotal = number_format($valorTotal,2,'.', '');
			$valor_descontado = number_format($valor_descontado,2,'.', '');
			$html .= '<tr>';
			$html .= '<td class="text-center">' . $dados->nome . '</td>';
			$html .= '<td class="text-center">' . inverteData($dados->data) . '</td>';
			$html .= '<td class="text-center">' . $dados->observacao . '</td>';
			$html .= '<td class="text-center">' . $valor_descontado . ' R$</td>';
			$html .= '</tr>';
		}
		$html .=
		'</tbody>
		<tfoot>';
		$html .= '<br>';
		$html .= '<tr>';
		$html .= '<td class="text-center" style="width: 30%;border-right:none;"> Valor Total de Produtos Vendidos</td>';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td class="text-center">' . $valorTotal . ' R$</td>';
		$html .= '</tr>';
		$html .= '</tfoot>     
		</table>
		</body>
		</html>
		';


		$data = array();
		$data['data'] = $html;

		$this->parser->parse('relatorios/view_datepagamentos', $data);


	}

	public function getDateProdutos()
	{
		$dataInicio = $this->input->post('datainicio');
		$dataFinal = $this->input->post('datafinal');

		$dataAtual = strftime('%A, %d de %B de %Y', strtotime('today'));

		$res = $this->RelatorioM->slcComandaPorProduto($dataInicio, $dataFinal);

		$html = '
		<html><head>
		<style>
		.text-center {text-align: center;}
		.cabeca {font-weight: bolder;}
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
		</style>
		</head>
		<body>
		<h1>Relatório de Produtos</h1>
		<h4>Lista de produtos vendidos por período</h4>
		<table class="tg" cellspacing="0" width="100%">
		<thead class="text-primary">
		<tr>
		<th  style="width: 40%;text-align:center;">Nome</th>
		<th  style="width: 10%;text-align:center;">Qtd por Comanda</th>
		<th  style="width: 10%;text-align:center;">Qtd em estoque</th>
		<th  style="width: 10%;text-align:center;">Valor Unitário</th>
		<th  style="width: 20%;text-align:center;">Valor Uni * Qtd</th>
		</tr>
		</thead>
		<tbody>';
		$valorTotal = 0;
		foreach ($res as $dados) {
			$valor_descontado =  $dados->ValorUniPorQtd;
			$valorTotal += $dados->ValorUniPorQtd;
			$valorTotal = number_format($valorTotal,2,'.', '');
			$valor_descontado = number_format($valor_descontado,2,'.', '');
			$html .= '<tr>';
			$html .= '<td class="text-center">' . $dados->nome . '</td>';
			$html .= '<td class="text-center">' . $dados->QtdPorComanda . '</td>';
			$html .= '<td class="text-center">' . $dados->QtdEstoque . '</td>';
			$html .= '<td class="text-center">' . $dados->preco . '</td>';
			$html .= '<td class="text-center">' . $valor_descontado . ' R$</td>';
			$html .= '</tr>';
		}
		$html .=
		'</tbody>
		<tfoot>';
		$html .= '<br>';
		$html .= '<tr>';
		$html .= '<td class="text-center" style="width: 30%;border-right:none;"> Valor Total de Produtos Vendidos</td>';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td style="border-right:none;border-left:none;">';
		$html .= '<td class="text-center">' . $valorTotal . ' R$</td>';
		$html .= '</tr>';
		$html .= '</tfoot>     
		</table>
		</body>
		</html>
		';


		$data = array();
		$data['data'] = $html;

		$this->parser->parse('relatorios/view_dateprodutos', $data);


	}

	public function getDateBarber()
	{
		$dataInicio = $this->input->post('datainicio');
		$dataFinal = $this->input->post('datafinal');
		$idbarbeiro = $this->input->post('barbeiro');

		$dataAtual = strftime('%A, %d de %B de %Y', strtotime('today'));

		$res = $this->RelatorioM->qtdServicoBarbeiro($idbarbeiro, $dataInicio, $dataFinal);
		$slc = $this->RelatorioM->slcComandaPorBarber($idbarbeiro, $dataInicio, $dataFinal);

		$html = '
		<html><head>
		<style>
		.text-center {text-align: center;}
		.cabeca {font-weight: bolder;}
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
		</style>
		</head>
		<body>
		<h1>Relatório de Serviços</h1>
		<h4>Dados Gerais para Pagamento</h4>
		<table class="tg" cellspacing="0" width="100%">
		<thead class="text-primary">
		<tr>
		<th  class="cabeca" style="width: 5%;">Código</th>
		<th  style="width: 50%;">Nome</th>
		<th  style="width: 20%;">Qtd Serviço Total</th>
		<th  style="width: 20%;">Valor a Receber</th>
		</tr>
		</thead>
		<tbody>';
		foreach ($res as $dados) {
			$valor_descontado =  $dados->valorTotal;
			$valor_descontado = number_format($valor_descontado,2,'.', '');
			$html .= '<tr>';
			$html .= '<td class="text-center">' . $dados->id . '</td>';
			$html .= '<td>' . $dados->nome . '</td>';
			$html .= '<td class="text-center">' . $dados->qtdCortes . '</td>';
			$html .= '<td class="text-center">' . $valor_descontado . ' R$</td>';
			$html .= '</tr>';
		}
		$html .='</tbody>
		</table>
		<br>
		<h4>Detalhes dos serviços</h4>
		<table class="tg" cellspacing="0" width="100%">
		<thead class="text-primary">
		<tr>
		<th  class="cabeca" style="width: 5%;">Cod Comanda</th>
		<th  style="width: 30%;">Nome do Servico</th>
		<th  style="width: 20%;">Valor do Serviço</th>
		<th  style="width: 20%;">Valor da Comissão</th>
		<th  style="width: 20%;">Data</th>
		</tr>
		</thead>
		<tbody>';
		foreach ($slc as $dados) {
			$html .= '<tr>';
			$html .= '<td class="text-center">' . $dados->comanda_id . '</td>';
			$html .= '<td>' . $dados->nome . '</td>';
			$html .= '<td class="text-center">' . $dados->preco . ' R$</td>';
			$html .= '<td class="text-center">' . $dados->valor . ' R$</td>';
			$html .= '<td class="text-center">' . inverteData($dados->data) . '</td>';
			$html .= '</tr>';
		}
		$html .='</tbody>
		</table>
		</body>
		</html>
		';

		$data = array();
		$data['data'] = $html;

		$this->parser->parse('relatorios/view_datebarber', $data);

	}

	public function relabarber()
	{
		$data = array();
		$data['datainicio'] = '';
		$data['datafinal'] = '';
		$data['BLC_BARBER'] = array();
		$data['URLFORM'] = site_url("painel/relatorio/getDateBarber");


		$res = $this->BarberM->get(array(), FALSE, FALSE);

		if ($res) {
			foreach ($res as $r) {
				$data['BLC_BARBER'][] = array(
					"barber_id" => $r->id,
					"nome" => $r->nome
				);
			}
		} else {
			$data['BLC_BARBER'][] = array();
		}


		$this->parser->parse('relatorios/rela_barber', $data);
	}

	public function vendas()
	{
		$data = array();
		$data['datainicio'] = '';
		$data['datafinal'] = '';
		$data['BLC_BARBER'] = array();
		$data['URLFORM'] = site_url("painel/relatorio/getDateVendas");

		$this->parser->parse('relatorios/rela_entrada', $data);
	}

	public function relapagamentos()
	{
		$data = array();
		$data['datainicio'] = '';
		$data['datafinal'] = '';
		$data['BLC_BARBER'] = array();
		$data['URLFORM'] = site_url("painel/relatorio/getDatePagamentos");


		$this->parser->parse('relatorios/rela_pagamentos', $data);
	}

	public function relaprodutos()
	{

		$data = array();
		$data['datainicio'] = '';
		$data['datafinal'] = '';
		$data['BLC_BARBER'] = array();
		$data['URLFORM'] = site_url("painel/relatorio/getDateProdutos");


		$this->parser->parse('relatorios/rela_produtos', $data);
	}


}
