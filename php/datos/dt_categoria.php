<?php
class dt_categoria extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT codigo_categ, descripcion, tipo_cat FROM categoria ORDER BY descripcion";
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