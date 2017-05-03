<?php
class dt_tipo_categoria extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT sigla, descripcion FROM tipo_categoria ORDER BY descripcion";
		return toba::db('nodos')->consultar($sql);
	}

}

?>