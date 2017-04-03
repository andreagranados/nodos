<?php
class dt_subroga extends toba_datos_tabla
{
    function get_subrogancias($id_car=null){
        if(!is_null($id_car)){
            $where="WHERE id_cargo=".$id_car;
        }else{
            $where='';
            }
        $sql=" select * from subroga ".$where;
        return toba::db('nodos')->consultar($sql);
    }
}
?>