# eNotas GW PHP client v2


### Instalação

```bash
composer require enotas/php-client-v2
```

### Configuração

```php
eNotasGW::configure(array(
	'apiKey' => '<sua api key>'
));
```

### Emitindo uma nota fiscal de serviço (NFS-e)
Para emitir NFS-e utilize a versão a API v1 (link abaixo)

https://github.com/eNotasGW/php-client

### Emitindo uma nota fiscal de produto (NF-e)
```php
$idEmpresa = '484FB0C5-969E-46AD-A047-8A0DB54667B4';

eNotasGW::$NFeProdutoApi->emitir($idEmpresa, array(
	// identificador único da requisição de emissão de nota fiscal 
	// (normalmente será preenchido com o id único do registro no sistema de origem)
	'id' => '5',
	'ambienteEmissao' => 'Homologacao', //'Producao' ou 'Homologacao'
	'consumidorFinal' => true,
	'indicadorPresencaConsumidor' => 'OperacaoPelaInternet',

	'cliente' => array(
		'nome' => 'Nome Cliente',
		'email' => 'cliente@mail.com',
		'cpfCnpj' => '23857396237',
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
					'origem' => 0 //0 - Nacional
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
```

### Emitindo uma nota fiscal de consumidor (NFC-e)
```php
$idEmpresa = '484FB0C5-969E-46AD-A047-8A0DB54667B4';

$result = eNotasGW::$NFeConsumidorApi->emitir($idEmpresa, array(
	// identificador único da requisição de emissão de nota fiscal 
	// (normalmente será preenchido com o id único do registro no sistema de origem)
	'id' => '5',
	'ambienteEmissao' => 'Homologacao', //'Producao' ou 'Homologacao'
	'pedido' => array(
		'presencaConsumidor' => 'OperacaoPresencial',
		'pagamento' => array(
			'tipo' => 'PagamentoAVista',
			'formas' => array(
				array(
					'tipo' => 'Dinheiro',
					'valor' => 0.01
				)
			)
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
					'origem' => 0 //0 - Nacional
				)
			)
		)
	),
	'informacoesAdicionais' => 'Documento emitido por ME ou EPP optante pelo Simples Nacional. Não gera direito a crédito fiscal de IPI.'
));
```
