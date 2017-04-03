<?php
class dt_tipo_subrogancia extends toba_datos_tabla
{

	function get_descripciones()
	{
		$sql = "SELECT sigla, descripcion FROM tipo_subrogancia ORDER BY descripcion";
		return toba::db('nodos')->consultar($sql);
	}

}
?>