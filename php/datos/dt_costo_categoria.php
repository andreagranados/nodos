<?php
class dt_costo_categoria extends nodos_datos_tabla
{
    function costo($cat){
        //obtiene el ultimo costo de una categoria dada
        $sql="select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
            (select codigo_categ,max(desde) as desde from costo_categoria
            group by codigo_categ)sub
            where c.codigo_categ=sub.codigo_categ"
            ." and codigo_cate='".$cat."'";
    }
    function get_costos($cat){
         $sql="select c.codigo_categ,c.desde,costo_basico 
             from costo_categoria c
             where codigo_categ='".$cat."'";
       
         return toba::db('nodos')->consultar($sql);
    }
}

?>