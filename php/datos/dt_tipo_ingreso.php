<?php
class dt_tipo_ingreso extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo, descripcion FROM tipo_ingreso ORDER BY descripcion";
		return toba::db('nodos')->consultar($sql);
	}

}

?>