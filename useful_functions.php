<?php
	function soNumero($str) {
		return preg_replace("/[^0-9]/", "", $str);
	}
?>