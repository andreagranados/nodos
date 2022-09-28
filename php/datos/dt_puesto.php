<?php
require_once 'dt_cargo.php';

class dt_puesto extends toba_datos_tabla
{
        function get_listado_puestos($filtro=array()){
            $where=" WHERE 1=1 ";
            
            if (isset($filtro['id_nodo'])) {
                $where.= " and n.id_nodo=".$filtro['id_nodo']['valor'];
            }
            if (isset($filtro['categ'])) {
                $where.=" and categ='".$filtro['categ']['valor']."'";
            }
           
//            $sql="select p.id_puesto,p.categ,p.pertenece_a,n.id_nodo,n.descripcion as nodo,co.costo_basico
//                    from puesto p
//                    left outer join nodo n on (p.pertenece_a=n.id_nodo)
//                    left outer join (select codigo_categ,max(desde) as desde 
//                                    from costo_categoria
//                                    group by codigo_categ)sub on (sub.codigo_categ=p.categ)
//                    left outer join costo_categoria co on (co.codigo_categ=sub.codigo_categ)
//                    $where
//                    order by nodo,id_puesto";
            $sql="                                 
                    select p.id_puesto,p.categ,p.pertenece_a,n.id_nodo,n.descripcion as nodo,cc.costo_basico,pe.apellido||','||pe.nombre||' '||pe.legajo||'('||case when no.descripcion is not null then no.descripcion else '' end||')' as ocupado_por
                    from puesto p
                    left outer join nodo n on (p.pertenece_a=n.id_nodo)
                    left outer join (select sub.*,costo_basico from 
                                        (select codigo_categ,max(desde) as desde 
                                        from costo_categoria
                                        group by codigo_categ)sub
                                      left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde )
                                      ) cc on (cc.codigo_categ=p.categ)
                    
                    left outer join (select ca.id_puesto,max(fec_alta)as desde
                    			 from cargo ca 
                    			 where ca.id_puesto is not null
                    			 group by ca.id_puesto )c on (c.id_puesto=p.id_puesto)
                    left outer join cargo cr on (cr.id_puesto=p.id_puesto and cr.fec_alta=c.desde)			 
                    left outer join nodo no on (cr.pertenece_a=no.id_nodo)	
                    left outer join persona pe on (pe.id_persona=cr.id_persona)			
                    $where
                    order by nodo,id_puesto   ";
            return toba::db('nodos')->consultar($sql);
        }
        function get_descripciones()
	{
		$sql = "SELECT id_puesto, categ FROM puesto ORDER BY categ";
		return toba::db('nodos')->consultar($sql);
	}
        //para cargar de que puesto depende la subrogancia
        function get_todos_puestos()
	{
		$sql = //"SELECT p.id_puesto, 'P'||p.id_puesto||'cat'||categ||'-'||case when n.desc_abrev is not null then n.desc_abrev else n.descripcion end ||'-'||case when sub.ultimo is not null then sub.ultimo else '' end as descripcion "
                        "SELECT p.id_puesto, case when n.desc_abrev is not null then n.desc_abrev else n.descripcion end ||'-'||'P'||p.id_puesto||'cat'||categ||'-'||case when sub.ultimo is not null then sub.ultimo else '' end as descripcion "
                        . " FROM puesto p "
                        . " left outer join nodo n on (n.id_nodo=p.pertenece_a)"
                        . " left outer join (select d.id_puesto,pe.apellido||','||pe.nombre as ultimo from (select p.id_puesto,p.tipo,p.categ,max(c.fec_alta) as alta
                        from puesto p 
                        left outer join cargo c on (c.id_puesto=p.id_puesto)
                        where c.id_cargo is not null
                        group by p.id_puesto,tipo,categ)d    
                        left outer join cargo c on (c.id_puesto=d.id_puesto and c.fec_alta=d.alta)                    
                        left outer join persona pe on (pe.id_persona=c.id_persona)                    )sub on (p.id_puesto=sub.id_puesto)"
                        . " ORDER BY n.desc_abrev,categ,p.id_puesto";
		return toba::db('nodos')->consultar($sql);
	}
        //retorna los puestos del nodo que ingresa como argumento
        function get_puestos($id_nodo=null){
            $mes=  date("m"); 
            $anio=  date("Y"); 
            $pdia=$anio."-".$mes."-"."01";
            if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="08" or $mes=="10" or $mes=="12"){
                $udia=$anio."-".$mes."-"."31";
            }else{if($mes=="04" or $mes="06" or $mes=="09" or $mes=="11"     ){
                    $udia=$anio."-".$mes."-"."30";
                    }
                  else {
                    $udia=$anio."-".$mes."-"."28";
                    }
            }
            $sql="select  origen_de(".$id_nodo.")";//recupera el primer nodo presupuestario en el arbol 
            $res=toba::db('nodos')->consultar($sql);
            //print_r($res);exit;//( [0] => Array ( [origen_de] => 31 ) )
            $where ="";
                            
            if(isset($id_nodo)){
                    $where=" WHERE p.pertenece_a=".$res[0]['origen_de'];
                }
             //tomo la maxima fecha de alta de los cargos que ocupan el puesto para ver el ultimo que lo ocupo
//            $sql="select p.id_puesto,case when tipo=1 then 'P_' else 'T_' end ||p.id_puesto||case when c.id_cargo is null then 'libre' else 'ocupado' end||'_cat'||categ  as descripcion "
//                    . "from puesto p "
//                    . " left outer join cargo c on (c.fec_alta<='".$udia."' and (c.fec_baja is null or c.fec_baja>='".$pdia."') and c.id_puesto=p.id_puesto)".$where
//                    ." order by descripcion";
            $sql="select sub.id_puesto,
                case when alta is null then 'P_'||sub.id_puesto||'_cat'||sub.categ||'_libre' else case when tipo=1 then 'P' else 'T' end ||sub.id_puesto||'_cat'||categ||'_'||pe.apellido||','||pe.nombre end as descripcion 
                    from 
                    (select p.id_puesto,p.tipo,p.categ,max(c.fec_alta) as alta
                        from puesto p 
                        left outer join cargo c on (c.id_puesto=p.id_puesto)
                      $where
                        group by p.id_puesto,p.tipo,p.categ)sub
                    left outer join cargo ca on (ca.id_puesto=sub.id_puesto and sub.alta=ca.fec_alta)
                    left outer join persona pe on (pe.id_persona=ca.id_persona)       
                    order by sub.id_puesto";
           
            return toba::db('nodos')->consultar($sql);
            
        }
        function get_credysaldos(){
            $mes=  date("m"); 
            $anio=  date("Y"); 
            $pdia=$anio."-".$mes."-"."01";
            if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="08" or $mes=="10" or $mes=="12"){
                $udia=$anio."-".$mes."-"."31";
            }else{if($mes=="04" or $mes="06" or $mes=="09" or $mes=="11"     ){
                    $udia=$anio."-".$mes."-"."30";
                    }
                  else {
                    $udia=$anio."-".$mes."-"."28";
                    }
            }
            $sql2=dt_cargo::armar_consulta();
            $sql2="select sub4.*,descripcion from (".
                    "select origen_de(id_nodo)as nodo,sum(gastotot) as gasto,sum(credito-gastotot) as saldo "
                    . " from ("
                            . "select *,case when gasto>0 then gasto+difer else 0 end as gastotot "
                            . " from ("
                            . " select *,case when puesto='A' or puesto='P' or puesto='V' or puesto='D' then costo_basico_p else 0 end as credito ,"
                            //. " case when ((puesto='A' and pase is null) or puesto ='') then costo_basico else 0 end as gasto"
                            .  " case when (puesto='A' or (puesto ='' or puesto is null)) and pase is null and tipo_nov is null and (chkstopliq=0 or chkstopliq is null) and estado<>'P'  then costo_basico else 0 end as gasto"
                            . " from (".$sql2.") sub"
                            .") sub2"
                    . ") sub3 "
                    . " group by nodo )sub4"
                    . " left outer join nodo n on (n.id_nodo=sub4.nodo)";
                    
                    
           // print_r($sql2);exit;
//            $sql="select * from (
//                    select n.descripcion as nodod, p.pertenece_a,sum(cos.costo_basico) as credito
//                    from puesto p
//                    left outer join (select sub.*,cc.costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))cos 
//                            on (p.categ=cos.codigo_categ)
//                    left outer join nodo n on (p.pertenece_a=n.id_nodo)                            
//                    group by n.descripcion,p.pertenece_a)sub1
//                    left outer join (".$sql2.")sub3 on (sub3.nodo=sub1.pertenece_a)
//                    order by nodod";
             $sql="select case when nodod is null then sub3.descripcion else nodod end as nodod,credito,gasto,saldo from (
                    select n.descripcion as nodod, p.pertenece_a,sum(cos.costo_basico) as credito
                    from puesto p
                    left outer join (select sub.*,cc.costo_basico from 
				(select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde )
                                 )cos on (p.categ=cos.codigo_categ)
                    left outer join nodo n on (p.pertenece_a=n.id_nodo)                            
                    group by n.descripcion,p.pertenece_a)sub1
                    full outer join (".$sql2.")sub3 on (sub3.nodo=sub1.pertenece_a)
                    order by nodod";
            return toba::db('nodos')->consultar($sql);
        }
        //quienes ocupan el puesto
        function get_ocupantes($id_puesto){
            $sql="select p.apellido,p.nombre,p.legajo,c.codc_categ,c.fec_alta,c.fec_baja,n.descripcion as nodo "
                    . " from cargo c"
                    . " left outer join persona p on (c.id_persona=p.id_persona) "
                    . " left outer join nodo n on (n.id_nodo=c.pertenece_a) "
                    . " where c.id_puesto=".$id_puesto
                    ." order by fec_alta ";
          
            return toba::db('nodos')->consultar($sql);
        }
        function hay_superposicion(){//hay mas de un cargo vigente que ocupa el mismo puesto
            $mes=  date("m"); 
            $anio=  date("Y"); 
            $pdia=$anio."-".$mes."-"."01";
            if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="08" or $mes=="10" or $mes=="12"){
                $udia=$anio."-".$mes."-"."31";
            }else{if($mes=="04" or $mes="06" or $mes=="09" or $mes=="11"     ){
                    $udia=$anio."-".$mes."-"."30";
                    }
                  else {
                    $udia=$anio."-".$mes."-"."28";
                    }
            }
            $sql="select * from 
                (select p.id_puesto,count(c.id_cargo) as cant from puesto p,
                     cargo c 
                     where c.id_puesto=p.id_puesto
                     and c.fec_alta<='".$udia."' and (c.fec_baja is null or c.fec_baja>='".$pdia."')"
                    . " group by p.id_puesto)sub"
                    . " where cant>1";
            $resul=toba::db('nodos')->consultar($sql);
            $mensaje='';
            foreach ($resul as $key => $value) {
                $mensaje.=$value['id_puesto'].', ';    
            }

            return $mensaje;
        }
        function hay_superposicion_con($cargo,$puesto,$desde,$hasta){
            $mes=  date("m"); 
            $anio=  date("Y"); 
            $where='';
           
            if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="08" or $mes=="10" or $mes=="12"){
                $udia=$anio."-".$mes."-"."31";
            }else{if($mes=="04" or $mes="06" or $mes=="09" or $mes=="11"     ){
                    $udia=$anio."-".$mes."-"."30";
                    }
                  else {
                    $udia=$anio."-".$mes."-"."28";
                    }
            }
            if($hasta ==null){
                $fin=$udia;
            }else{
                $fin=$hasta;
            }
            if($cargo!=0){
                $where=" and id_cargo <>".$cargo;
            }
            $sql="select * from cargo "
                    . " where id_puesto=".$puesto
                    ." and fec_alta<='".$fin."' and (fec_baja is null or fec_baja>='".$desde."')"
                    . $where
                    ;
           
            $resul=toba::db('nodos')->consultar($sql);
            
            if(count($resul)>0){
                return 1;
            }else{
                return 0;
            }
        }
        

}

?>