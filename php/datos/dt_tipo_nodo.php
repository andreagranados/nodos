<?php
class dt_tipo_nodo extends toba_datos_tabla
{
    function get_descripciones(){
        $sql="select id_tipo,descripcion from tipo_nodo order by descripcion";
        return toba::db('nodos')->consultar($sql);
    }
}

?>