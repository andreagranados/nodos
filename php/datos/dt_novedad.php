<?php
class dt_novedad extends toba_datos_tabla
{
    function get_novedades($id_car=null){
        $where ="";
                            
        if(isset($id_car)){
                    $where=" WHERE id_cargo=".$id_car;
                }
        $sql="select * from novedad ".$where;
        return toba::db('nodos')->consultar($sql);
        
    }
}

?>