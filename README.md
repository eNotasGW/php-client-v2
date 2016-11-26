# eNotas GW PHP client v2

~~~
eNotasGW::configure(array(
	'apiKey' => '<sua api key>'
));
~~~

### Emitindo uma nota fiscal de serviço (NFS-e)
~~~

$idEmpresa = '484FB0C5-969E-46AD-A047-8A0DB54667B4';

eNotasGW::$NFSeApi->emitir($idEmpresa, array(
  // identificador único da requisição de emissão de nota fiscal 
  // (normalmente será preenchido com o id único do registro no sistema de origem)
	'id' => '5',
	'cliente' => array(
		'nome' => 'Nome Cliente',
		'email' => 'cliente@mail.com',
		'cpfCnpj' => '23857396237',
		'endereco' => array(
			'uf' => 'MG', 
			'cidade' => 'Belo Horizonte',
			'logradouro' => 'Rua 01',
			'numero' => '112',
			'bairro' => 'Savassi',
			'cep' => '32323111'
		)
	),
	'servico' => array(
		'descricao' => 'Discriminação do serviço prestado'
	),
	'valorTotal' => 10.05
));
~~~
