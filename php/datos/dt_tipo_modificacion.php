<?php
class dt_tipo_modificacion extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo, descripcion FROM tipo_modificacion ORDER BY descripcion";
		return toba::db('nodos')->consultar($sql);
	}

}

?>