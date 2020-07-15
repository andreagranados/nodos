<?php
class dt_persona extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_persona, apellido||', '||nombre as nombre FROM persona ORDER BY apellido,nombre";
		return toba::db('nodos')->consultar($sql);
	}
        function get_listado($filtro=array()){
            $where = "";
            if (isset($filtro['id_persona'])) {
			$where.= " WHERE id_persona=".$filtro['id_persona'];
		}
            $sql="select * from persona"
                    . $where;
            return toba::db('nodos')->consultar($sql);
                
        }
        function repite_cuil($cuil){
            $c1=substr($cuil, 0, 2);
            $c=substr($cuil, 2, 8);
            $c2=substr($cuil, 10, 1);
            $sql="select apellido||', '||nombre as nomb from persona"
                    . " where nro_cuil1=".$c1
                    . " and nro_cuil=".$c
                    . " and nro_cuil2=".$c2;
            $res=toba::db('nodos')->consultar($sql);            
            if(count($res)>0){
                return $res[0]['nomb'];
            }else{
                return '';
            }
        }
        function repite_cuil_modif($cuil_nuevo,$cuil1,$cuil,$cuil2){
            $cuil_persona=$cuil1.str_pad($cuil, 8, '0', STR_PAD_LEFT).$cuil2;
            $sql=" select * from (select apellido||', '||nombre as nomb,cast (nro_cuil1||lpad(nro_cuil::text, 8, '0') ||nro_cuil2 as numeric) as cuil  "
                    . " from persona"
                    . " )sub"
                    . " where cuil=$cuil_nuevo"
                    . " and cuil<> ".$cuil_persona;
            
            $res=toba::db('nodos')->consultar($sql);            
            if(count($res)>0){
                return $res[0]['nomb'];
            }else{
                return '';
            }
        }
        function repite_legajo($legaj){    
            $sql="select apellido||', '||nombre as nomb from persona"
                    . " where legajo=".$legaj;
            $res=toba::db('nodos')->consultar($sql);            
            if(count($res)>0){
                return $res[0]['nomb'];
            }else{
                return '';
            }
        }
        function repite_legajo_modif($leg_nuevo,$leg){
            $sql="select apellido||', '||nombre as nomb from persona"
                    . " where legajo<>".$leg
                    . " and legajo=".$leg_nuevo;
            $res=toba::db('nodos')->consultar($sql);            
            if(count($res)>0){
                return $res[0]['nomb'];
            }else{
                return '';
            }
        }

}

?>