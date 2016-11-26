<?php
	header('Content-Type: text/html; charset=utf-8');
	
	require('../src/eNotasGW.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;

	eNotasGW::configure(array(
		'apiKey' => '<sua api key>'
	));
	
	$idEmpresa = '484FB0C5-969E-46AD-A047-8A0DB54667B4';
	
	try
	{
		eNotasGW::$NFeProdutoApi->emitir($empresaId, array(
			'ambienteEmissao' => 'Homologacao',
			'id' => '10',
			'consumidorFinal' => true,
			'indicadorPresencaConsumidor' => 'OperacaoPelaInternet',
			'cliente' => array(
				'nome' => 'Jonathan Souza',
				'email' => 'jonathan.souza@mail.com',
				'cpfCnpj' => '84629821708',
				'endereco' => array(
					'uf' => 'MG', 
					'cidade' => 'Belo Horizonte',
					'logradouro' => 'Rua 01',
					'numero' => '112',
					'complemento' => 'AP 402',
					'bairro' => 'Savassi',
					'cep' => '32323111'
				)
			),
			'itens' => array(
				array(
					'cfop' => '5101',
					'codigo' => '1',
					'descricao' => 'Produto XYZ',
					'ncm' => '49019900',
					'quantidade' => 1,
					'unidadeMedida' => 'UN',
					'valorUnitario' => 1.39,
					'impostos' => array(
						'percentualAproximadoTributos' => array(
							'simplificado' => array(
								'percentual' => 31.45
							),
							'fonte' => 'IBPT'
						),
						'icms' => array(
							'situacaoTributaria' => '102',
							'origem' => 0
						),
						'pis' => array(
							'situacaoTributaria' => '08'
						),
						'cofins' => array(
							'situacaoTributaria' => '08'
						)
					)
				)
			),
			'informacoesAdicionais' => 'Documento emitido por ME ou EPP optante pelo Simples Nacional. Não gera direito a crédito fiscal de IPI.'
		));
		
		echo 'Sucesso! </br>';
	}
	catch(Exceptions\invalidApiKeyException $ex) {
		echo 'Erro de autenticação: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\unauthorizedException $ex) {
		echo 'Acesso negado: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\apiException $ex) {
		echo 'Erro de validação: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\requestException $ex) {
		echo 'Erro na requisição web: </br></br>';
		
		echo 'Requested url: ' . $ex->requestedUrl;
		echo '</br>';
		echo 'Response Code: ' . $ex->getCode();
		echo '</br>';
		echo 'Message: ' . $ex->getMessage();
		echo '</br>';
		echo 'Response Body: ' . $ex->responseBody;
	}
?>
