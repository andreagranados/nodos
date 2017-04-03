<?php
class dt_puesto extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_puesto, categ FROM puesto ORDER BY categ";
		return toba::db('nodos')->consultar($sql);
	}
        //retorna los puestos del nodo que ingresa como argumento
        function get_puestos($id_nodo=null){
            $where ="";
                            
            if(isset($id_nodo)){
                    $where=" WHERE pertenece_a=".$id_nodo;
                }
            $sql="select id_puesto,case when tipo=1 then 'P_' else 'T_' end ||categ  as descripcion "
                    . "from puesto ".$where
                    ." order by descripcion";
            return toba::db('nodos')->consultar($sql);
            
        }

}

?>