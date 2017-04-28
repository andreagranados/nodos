<?php
class dt_desempenio extends toba_datos_tabla
{
        function get_depdesemp($id_cargo){
            $sql="select d.id_cargo,d.id_nodo,n.descripcion as nodo,d.descripcion "
                    . " from desempenio d"
              . " left outer join nodo n on (n.id_nodo=d.id_nodo)"
              . "where d.id_cargo=".$id_cargo;
            return toba::db('nodos')->consultar($sql);
         }
	function get_descripciones()
	{
            $sql = "SELECT id_nodo, descripcion FROM desempenio ORDER BY descripcion";
            return toba::db('nodos')->consultar($sql);
	}

}
?>