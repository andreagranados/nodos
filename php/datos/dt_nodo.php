<?php
class dt_nodo extends toba_datos_tabla
{
    function get_descripciones()
	{
	$sql = "SELECT * FROM nodo";
	return toba::db('nodos')->consultar($sql);
	}
    function get_dependientes()
	{
	 $sql = "SELECT * FROM nodo ";
	 return toba::db('nodos')->consultar($sql);
	}  
    function get_presupuestarios(){
        $sql="select * from nodo where presupuestario=1";
        return toba::db('nodos')->consultar($sql);
    }    

}

?>