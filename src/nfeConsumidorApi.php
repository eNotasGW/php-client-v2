<?php
	namespace eNotasGW\Api;

	class nfeConsumidorApi extends nfeApiBase {
		public function __construct($proxy) {
			parent::__construct('nfc-e', $proxy);
		}
	}
?>