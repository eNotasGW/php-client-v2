<?php
	header('Content-Type: text/html; charset=utf-8');
	
	require('../../../src/eNotasGW.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;
	use eNotasGW\Api\fileParameter as fileParameter;
		
	eNotasGW::configure(array(
		'apiKey' => '<api key>'
	));
	
	try
	{		
		$dadosEmpresa = array(
			//informar apenas se quiser atualizar uma empresa existente
			//'id' => 'CB09776E-E954-4D75-BBA6-E7A99FF20100',
			'cnpj' => '56308661000199',
			'inscricaoEstadual' => '12345',
			'inscricaoMunicipal' => null, //opcional
			'razaoSocial' => 'Empresa de Teste Ltda',
			'nomeFantasia' => 'Empresa de Teste',
			'optanteSimplesNacional' => true,
			'email' => null,
			'telefoneComercial' => '3132323131',
			'endereco' => array(
				'uf' => 'RJ', 
				'cidade' => 'Rio de Janeiro',
				'logradouro' => 'Rua 01',
				'numero' => '112',
				'complemento' => 'SL 102',
				'bairro' => 'Savassi',
				'cep' => '32323111'
			),
			'emissaoNFeConsumidor' => array(
				'ambienteProducao' => array(
					'sequencialNFe' => 1,
					'serieNFe' => '2',
					'csc' => array(
						'id' => '000001', //id do Código de Segurança do Contribuiente (CSC) necessário para emsisão de NFC-e
						'codigo' => '800FA97D5C3F4219A89DCE3FCE813A6F' //Código de Segurança do Contribuiente (CSC) necessário para emsisão de NFC-e
					)
				),
				'ambienteHomologacao' => array(
					'sequencialNFe' => 1,
					'serieNFe' => '2'
				)
			)
		);
	
		$result = eNotasGW::$EmpresaApi->inserirAtualizar($dadosEmpresa);
		$empresaId = $result->empresaId;
		
		echo 'empresa inserida com sucesso!';
		echo '<br />ID: ' . $empresaId;
		echo '<br />';
		echo '<br />';
		
		echo 'inserindo certificado digital... <br /><br />';
		
		$arquivoPfxOuP12 = fileParameter::fromPath('{certificate file path}', 
		'application/x-pkcs12', '{file name}');
		$senhaDoArquivo = '{senha do arquivo .pfx ou .p12}';
		
		eNotasGW::$EmpresaApi->atualizarCertificado($empresaId, $arquivoPfxOuP12, $senhaDoArquivo);
		echo '<br/> Certificado incluído com sucesso!';
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
