<?php
class dt_tipo_doc extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo, desc_abrev FROM tipo_doc ORDER BY desc_abrev";
		return toba::db('nodos')->consultar($sql);
	}

}

?>