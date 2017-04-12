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
	 $sql = "SELECT * FROM nodo order by descripcion";
	 return toba::db('nodos')->consultar($sql);
	}  
    function get_presupuestarios(){
        $sql="select * from nodo where presupuestario=1 order by descripcion";
        $salida=toba::db('nodos')->consultar($sql);
        return $salida;
    } 
    function get_origen($id_carg){
        //recupero el nodo al que pertenece el cargo
        $sql="select pertenece_a from cargo where id_cargo=".$id_carg;
        $nodo=toba::db('nodos')->consultar($sql);
        if(count($nodo)>0){//si el cargo pertenece a algun nodo
            $sql="select origen_de(".$nodo[0]['pertenece_a'].")";
            $id=toba::db('nodos')->consultar($sql);        
            $sql="select id_nodo,descripcion from nodo where id_nodo=".$id[0]['origen_de'];
            return toba::db('nodos')->consultar($sql);    
        }//si el cargo no pertenece a nada entonces no puede hacer pase
        
    }

}

?>