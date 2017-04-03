<?php
class dt_persona extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_persona, apellido||', '||nombre as nombre FROM persona ORDER BY nombre";
		return toba::db('nodos')->consultar($sql);
	}
        function get_listado($filtro=array()){
            $where = "";
            if (isset($filtro['id_persona'])) {
			$where.= " WHERE id_persona=".$filtro['id_persona'];
		}
            $sql="select * from persona"
                    . $where;
            return toba::db('nodos')->consultar($sql);
                
        }

}

?>