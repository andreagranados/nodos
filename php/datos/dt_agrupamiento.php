<?php
class dt_agrupamiento extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT codc_agrup, descripcion FROM agrupamiento ORDER BY descripcion";
		return toba::db('nodos')->consultar($sql);
	}

}

?>