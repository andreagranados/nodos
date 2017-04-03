<?php
class dt_cargo extends toba_datos_tabla
{
    function get_listado($id_nodo=null)
    {
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
        if(!is_null($id_nodo)){
            $sql ="CREATE LOCAL TEMP TABLE auxiliar(
               id_nodo	integer );";    
                toba::db('nodos')->consultar($sql);
                $sql="select depende_de(".$id_nodo.");";
                toba::db('nodos')->consultar($sql);
                $where=" AND no.id_nodo=".$id_nodo." or no.id_nodo in (select id_nodo from auxiliar)";
            }else{
                $where='';
            }
        $sql="select case when n.id_novedad is not null then 'L' else 'A' end as puesto,p.tipo,no.id_nodo,case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end as dep,pe.legajo,pe.apellido,pe.nombre,p.id_puesto,p.categ as catpuesto,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ, case when s.categ is not null then coss.costo_basico else null end as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
                from puesto p
                left outer join cargo c on (p.id_puesto=c.id_puesto)
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)
                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.desde <='".$udia."' and (pa.hasta>='".$pdia."' or pa.hasta is null))
                left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (c.codc_categ=cos.codigo_categ)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)coss 
                            on (s.categ=coss.codigo_categ)                            
                where c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)
                ".$where
                
                . " UNION "//cargos que no estan asociados a puestos
                ."select '' as puesto,null,no.id_nodo,case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end as dep,pe.legajo,pe.apellido,pe.nombre,null,null,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ,null as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
                from cargo c
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)
                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.desde <='".$udia."' and (pa.hasta>='".$pdia."' or pa.hasta is null))
                    left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (c.codc_categ=cos.codigo_categ)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)coss 
                            on (s.categ=coss.codigo_categ)                             
                where c.id_puesto is null 
                and c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)"
                .$where
                ." order by apellido,nombre";
	
	return toba::db('nodos')->consultar($sql);
    }
    function get_cargos($filtro=array())
    {
        $where = "";
        if (isset($filtro['id_persona'])) {
	   $where.= " WHERE id_persona=".$filtro['id_persona'];
		}
        $sql="select c.id_cargo,c.codc_carac,c.codc_categ ,c.codc_agrup,c.fec_alta,c.fec_baja,case when c.chkstopliq=0 then 'NO' else 'SI' end as chkstopliq ,n.descripcion as pertenece_a,case when p.tipo=1 then 'P_' else 'T_' end ||'_'|| p.categ as puesto"
                . " from cargo c"
                . " left outer join puesto p on (c.id_puesto=p.id_puesto)"
                . " left outer join nodo n on (c.pertenece_a=n.id_nodo)".$where
                ." order by fec_alta";
        
        return toba::db('nodos')->consultar($sql);
    }

}
?>