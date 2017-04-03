<?php
class dt_pase extends toba_datos_tabla
{
 function get_pases($id_car=null){
     if(!is_null($id_car)){
        $where="WHERE id_cargo=".$id_car;
      }else{
        $where='';
            }
    $sql="select p.*,n.descripcion as origend,n2.descripcion as destinod from pase p"
            . " left outer join nodo n on (p.origen=n.id_nodo)"
            . " left outer join nodo n2 on (p.destino=n2.id_nodo)".$where;        
    return toba::db('nodos')->consultar($sql);
 }
}
?>                