<?php
class dt_categoria extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT c.codigo_categ, c.descripcion, c.tipo_cat,sub2.costo_basico "
                    . " FROM categoria c"
                    . " left outer join (select sub.codigo_categ,cca.costo_basico from 
(select codigo_categ,max(desde) as alta from costo_categoria cc
group by codigo_categ)sub
left outer join costo_categoria cca on (sub.codigo_categ=cca.codigo_categ and cca.desde=sub.alta))sub2 on (sub2.codigo_categ=c.codigo_categ)"
                    . " ORDER BY descripcion";
            return toba::db('nodos')->consultar($sql);
	}
        function get_categorias_perm()
	{
            $sql = "SELECT codigo_categ, descripcion "
                    . " FROM categoria where codigo_categ in ('01','02','03','04','05','06','07')"
                    . " ORDER BY descripcion";
            return toba::db('nodos')->consultar($sql);
	}
        function get_se_subrogan()
        {
            $sql = "SELECT codigo_categ, descripcion "
                    . " FROM categoria "
                    . " WHERE codigo_categ in ('01','02','03','04','05','06')"
                    . " ORDER BY descripcion";
            return toba::db('nodos')->consultar($sql);
            
        }
      

}

?>