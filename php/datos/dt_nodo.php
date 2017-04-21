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
    function get_escalonados(){
        $sql="select sub.id_nodo, case when sub.id_nodo=sub.ori then sub.descripcion else sub.descripcion||'-'||no.descripcion end as descripcion from 
            (select id_nodo,descripcion,origen_de(id_nodo)as ori
            from nodo n)sub
            left outer join nodo no on(no.id_nodo=sub.ori)
            order by sub.descripcion
            ";
         return toba::db('nodos')->consultar($sql);
    }    
   //solo retorna los que son presupuestarios
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