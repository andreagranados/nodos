<?php
require_once 'dt_cargo.php';

class dt_puesto extends toba_datos_tabla
{
        function get_descripciones()
	{
		$sql = "SELECT id_puesto, categ FROM puesto ORDER BY categ";
		return toba::db('nodos')->consultar($sql);
	}
        
        //retorna los puestos del nodo que ingresa como argumento
        function get_puestos($id_nodo=null){
            $mes=  date("m"); 
            $anio=  date("Y"); 
            $pdia=$anio."-".$mes."-"."01";
            if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="09" or $mes=="11"){
                $udia=$anio."-".$mes."-"."31";
            }else{if($mes=="04" or $mes="06" or $mes=="08" or $mes=="10"     ){
                    $udia=$anio."-".$mes."-"."30";
                    }
                  else {
                    $udia=$anio."-".$mes."-"."28";
                    }
            }
            $where ="";
                            
            if(isset($id_nodo)){
                    $where=" WHERE p.pertenece_a=".$id_nodo;
                }
            $sql="select p.id_puesto,case when tipo=1 then 'P_' else 'T_' end ||p.id_puesto||case when c.id_cargo is null then 'libre' else 'ocupado' end||'_cat'||categ  as descripcion "
                    . "from puesto p "
                    . " left outer join cargo c on (c.fec_alta<='".$udia."' and (c.fec_baja is null or c.fec_baja>='".$pdia."') and c.id_puesto=p.id_puesto)".$where
                    //." and not exists (select * from cargo c where c.fec_alta<='".$udia."' and (c.fec_baja is null or c.fec_baja>='".$pdia."') and c.id_puesto=p.id_puesto)"
                    ." order by descripcion";
           
            return toba::db('nodos')->consultar($sql);
            
        }
        function get_credysaldos(){
            $mes=  date("m"); 
            $anio=  date("Y"); 
            $pdia=$anio."-".$mes."-"."01";
            if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="09" or $mes=="11"){
                $udia=$anio."-".$mes."-"."31";
            }else{if($mes=="04" or $mes="06" or $mes=="08" or $mes=="10"     ){
                    $udia=$anio."-".$mes."-"."30";
                    }
                  else {
                    $udia=$anio."-".$mes."-"."28";
                    }
            }
            $sql="
                select n.descripcion as nodo, p.pertenece_a,sum(cos.costo_basico) as credito
                    from puesto p
                    left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (p.categ=cos.codigo_categ)
                    left outer join nodo n on (p.pertenece_a=n.id_nodo)                            
                    group by n.descripcion,p.pertenece_a
                    ";
            //$sql=dt_cargo::armar_consulta();
            //$sql="select * from (".$sql.")";
            //print_r($sql);exit();
            return toba::db('nodos')->consultar($sql);
        }
        

}

?>