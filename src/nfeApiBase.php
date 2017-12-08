<?php
	namespace eNotasGW\Api;

	abstract class nfeApiBase extends eNotasGWApiBase {
		protected $tipoNF;
	
		public function __construct($tipoNF, $proxy) {
			parent::__construct($proxy);
			$this->tipoNF = $tipoNF;
		}
		
		/**
		 * Emite uma Nota Fiscal
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param mixed $dadosNFe dados da NFe a ser emitida
		 */
		public function emitir($idEmpresa, $dadosNFe) {
			$result = $this->callOperation(array(
				'method' => 'POST',
				'path' => '/empresas/{empresaId}/{tipoNF}',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'tipoNF' => $this->tipoNF
					),
					'body' => $dadosNFe
				)
			));

			return $result;
		}
		
		/**
		 * Cancela uma determinada Nota Fiscal
		 * @param string $nfeId Identificador Único da Nota Fiscal
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 */
		public function cancelar($idEmpresa, $id) {
			$result = $this->callOperation(array(
				'method' => 'DELETE',
				'path' => '/empresas/{empresaId}/{tipoNF}/{id}',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'tipoNF' => $this->tipoNF,
					  'id' => $id
					)
				)
			));
			
			return $result;
		}

		/**
		 * Consulta uma Nota Fiscal pelo Identificador Único
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param string $nfeId Identificador Único da Nota Fiscal
		 * @return	mixed $dadosNFe	retorna os dados da nota como um array
		 */
		public function consultar($idEmpresa, $nfeId) {
			return $this->callOperation(array(
			  'path' => '/empresas/{empresaId}/{tipoNF}/{id}',
			  'parameters' => array(
					'path' => array(
						'empresaId' => $idEmpresa,
						'tipoNF' => $this->tipoNF,
						'nfeId' => $nfeId
					)
				)
			));
		}

		/**
		* Consulta notas fiscais emitidas em um determinado período
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param int $pageNumber numero da página no qual a pesquisa será feita
		* @param int $pageSize quantidade de registros por página
		* @param string $dataInicial data inicial para pesquisa
		* @param string $dataFinal data final para pesquisa
		* @return searchResult	$listaNFe retorna uma lista contendo os registros encontrados na pesquisa
		*/
		public function consultarPorPeriodo($idEmpresa, $pageNumber, $pageSize, $dataInicial, $dataFinal) {
			$dataInicial = eNotasGWHelper::formatDateTime($dataInicial);
			$dataFinal = eNotasGWHelper::formatDateTime($dataFinal);
		
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/{tipoNF}',
				'parameters' => array(
					'path' => array(
						'empresaId' => $idEmpresa,
						'tipoNF' => $this->tipoNF
					),
					'query' => array(
						'pageNumber' => $pageNumber,
						'pageSize' => $pageSize,
						'filter' => "dataCriacao ge '{$dataInicial}' and dataCriacao le '{$dataFinal}'"
					)
				)
			));
		}
		
		/**
		* Download do xml de uma Nota Fiscal identificada pelo seu Identificador Único
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $id Identificador Único da Nota Fiscal
		* @return string xml da nota fiscal
		*/
		public function downloadXml($idEmpresa, $id) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/{tipoNF}/{id}/xml',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'tipoNF' => $this->tipoNF,
					  'id' => $id
					)
				)
			));
		}
		
		/**
		* Download do pdf de uma Nota Fiscal identificada pelo seu id único
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $id Identificador Único da Nota Fiscal
		* @return os bytes do arquivo pdf
		*/
		public function downloadPdf($idEmpresa, $id) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/{tipoNF}/{id}/pdf',
				'decodeResponse' => FALSE,
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'tipoNF' => $this->tipoNF,
					  'id' => $id
					)
				)
			));
		}
		
		/**
		* Download do pdf de uma Nota Fiscal identificada pelo seu id único
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $id Identificador Único da Nota Fiscal
		* @return os bytes do arquivo pdf
		*/
		public function inutilizarNumeracao($idEmpresa, $dadosInutilizacao) {
			$result = $this->callOperation(array(
				'method' => 'POST',
				'path' => '/empresas/{empresaId}/{tipoNF}/inutilizar',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'tipoNF' => $this->tipoNF
					),
					'body' => $dadosInutilizacao
				)
			));

			return $result;
		}
	}
?>
