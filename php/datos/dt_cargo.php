<?php
class dt_cargo extends toba_datos_tabla
{
     function get_subrogancias(){
         $sql="";
     }
    //retorna el id del nodo al que pertenece y 0 sino pertenece a ningun nada
    function get_nodo($id_cargo){
       $sql="select pertenece_a from cargo where id_cargo=".$id_cargo;
       $salida = toba::db('nodos')->consultar($sql);
       if(count($salida)>0){
           return $salida[0]['pertenece_a'];
       }else{
           return 0;
       }
    }
    function get_listado($id_nodo=null)
    {
//       $actual=date("Y-m-d");
//       $mes=  date("m"); 
//       $anio=  date("Y"); 
//       $pdia=$anio."-".$mes."-"."01";
//       if($mes=="01" or $mes=="03" or $mes=="05" or $mes=="07" or $mes=="08" or $mes=="10" or $mes=="12"){
//           $udia=$anio."-".$mes."-"."31";
//       }else{if($mes=="04" or $mes="06" or $mes=="09" or $mes=="11"     ){
//           $udia=$anio."-".$mes."-"."30";
//            }
//            else {
//                $udia=$anio."-".$mes."-"."28";
//            }
//           
//       }
//       
//        if(!is_null($id_nodo)){
//            $sql ="CREATE LOCAL TEMP TABLE auxiliar(
//               id_nodo	integer );";    
//                toba::db('nodos')->consultar($sql);
//                $sql="select depende_de(".$id_nodo.");";
//                toba::db('nodos')->consultar($sql);
//                $where1=" WHERE (p.pertenece_a=".$id_nodo." or p.pertenece_a in (select id_nodo from auxiliar)"
//                        . " or c.pertenece_a=".$id_nodo. " or c.pertenece_a in (select id_nodo from auxiliar))";
//                
//                $where2=" and (c.pertenece_a=".$id_nodo." or c.pertenece_a in (select id_nodo from auxiliar))";
//            }else{
//                $where1='';
//                $where2='';
//            }
//            //algunos puestos pueden no estar ocupados en el mes actual, por eso no tenia c.pertenece_a recupero la dependencia del puesto en algunos casos
//        $sql="select distinct * ,costosub-costo_basico as dif from (
//             select case when c.id_cargo is null then 'V' else case when n.id_novedad is not null then 'P' else 'A' end end as puesto,c.id_cargo,p.tipo,no.id_nodo,case when no.desc_abrev is null and case when nop.desc_abrev is null then nop.descripcion else nop.desc_abrev end is null then nop.descripcion else case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end end as dep,pe.legajo,pe.apellido,pe.nombre,p.id_puesto,p.categ as catpuesto,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ, case when s.categ is not null then coss.costo_basico else null end as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
//                from puesto p
//                left outer join cargo c on (p.id_puesto=c.id_puesto and  c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null))
//                left outer join nodo no on (no.id_nodo=c.pertenece_a)
//                left outer join nodo nop on (nop.id_nodo=p.pertenece_a)
//                left outer join persona pe on (pe.id_persona=c.id_persona)
//                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
//                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
//                left outer join pase pa on (pa.id_cargo=c.id_cargo and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde )
//                left outer join nodo nod on (nod.id_nodo=pa.destino)
//                left outer join (	select sub.*,costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))cos 
//                            on (p.categ=cos.codigo_categ)
//                 left outer join (	select sub.*,costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))coss 
//                            on (s.categ=coss.codigo_categ)                              
//                                          
//                ".$where1
//                
//                . " UNION "//cargos que no estan asociados a puestos
//                ."select '' as puesto,c.id_cargo,null as tipo,no.id_nodo,case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end as dep,pe.legajo,pe.apellido,pe.nombre,null,codc_categ,c.id_cargo,codc_categ ,fec_alta,fec_baja,n.tipo_nov,s.categ,coss.costo_basico as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
//                from cargo c
//                left outer join nodo no on (no.id_nodo=c.pertenece_a)
//                left outer join persona pe on (pe.id_persona=c.id_persona)
//                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
//                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
//                left outer join pase pa on (pa.id_cargo=c.id_cargo and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde)
//                left outer join nodo nod on (nod.id_nodo=pa.destino)
//                left outer join (	select sub.*,costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))cos 
//                            on (c.codc_categ=cos.codigo_categ)
//                left outer join (	select sub.*,costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))coss 
//                            on (s.categ=coss.codigo_categ)             
//                "." WHERE ".                       
//                "  c.id_puesto is null 
//                and c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)".$where2
//                
//               
//                . ")sub"
//                 ." order by apellido,nombre";
//	
        $sql=dt_cargo::armar_consulta($id_nodo);
        $sql=
               "select *,case when gasto>0 then gasto+difer else 0 end as gastotot, trim(apellido)||', '|| trim(nombre) as agente from ("
               . "select *,case when puesto='A' or puesto='P' or puesto='V' or puesto='D' then costo_basico_p else 0 end as credito ,"
               //. " case when ((puesto='A' and pase is null) or ((puesto ='' or puesto is null) and pase is null and tipo_nov is null)) and (chkstopliq=0 or chkstopliq is null) and estado<>'P'  then costo_basico else 0 end as gasto"
                ." case when (puesto='A' or (puesto ='' or puesto is null)) and pase is null and tipo_nov is null and (chkstopliq=0 or chkstopliq is null) and estado<>'P'  then costo_basico else 0 end as gasto"
               . " from (".$sql.") sub"
               .") sub2"
                . " where (puesto='A' or puesto='P' or puesto is null or puesto='') and pase is null"
               ;
	return toba::db('nodos')->consultar($sql);
    }
    function get_cargos($filtro=array())
    {
       $actual=date("Y-m-d");
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
        $where = "";
        if (isset($filtro['id_persona'])) {
	   $where.= " WHERE id_persona=".$filtro['id_persona'];
         }
      
        $sql="select sub.*,sub3.categ as subroga,nod.descripcion as pase from (
                select c.id_persona,c.id_cargo,c.codc_carac,c.codc_categ ,c.codc_agrup,c.fec_alta,c.fec_baja,c.resol,case when c.chkstopliq=0 then 'NO' else 'SI' end as chkstopliq ,n.descripcion as pertenece_a,case when p.tipo=1 then 'P_' else 'T_' end ||p.id_puesto||'_categ'|| p.categ as puesto,max(pa.desde) as pase_desde
                 from cargo c
                 left outer join puesto p on (c.id_puesto=p.id_puesto)
                 left outer join nodo n on (c.pertenece_a=n.id_nodo)
                 left outer join pase pa on (pa.id_cargo=c.id_cargo)
                 group by c.id_persona,c.id_cargo,codc_carac,codc_categ,codc_agrup,fec_alta,fec_baja,c.resol,c.chkstopliq,n.descripcion ,c.pertenece_a, puesto
                 )sub
                left outer join pase p on (sub.id_cargo=p.id_cargo and p.desde=sub.pase_desde)                                       
                left outer join nodo nod on (nod.id_nodo=p.destino) ".                     
                "left outer join (select s.id_cargo,max(desde) as desde from subroga s
                                    where 
                                    s.desde <='".$udia."' and (s.hasta>='".$actual."' or s.hasta is null)
                                    group by s.id_cargo    )sub2 on (sub2.id_cargo=sub.id_cargo)
                 left outer join (select s.id_cargo,s.desde,s.categ  from subroga s
                                    where
                                    s.desde <='".$udia."' and (s.hasta>='".$actual."' or s.hasta is null) )sub3 on (sub2.id_cargo=sub3.id_cargo and sub2.desde=sub3.desde)                 "
                //por si tiene dos subrogancias y las dos abiertas, tomo la de mayor fecha desde
                ."    $where
                order by fec_alta desc";
        return toba::db('nodos')->consultar($sql);
    }
   function armar_consulta($id_nodo=null){
       $actual=date("Y-m-d");
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
        if(!is_null($id_nodo)){
            $sql ="CREATE LOCAL TEMP TABLE auxiliar(
               id_nodo	integer );";    
                toba::db('nodos')->consultar($sql);
                $sql="select depende_de(".$id_nodo.");";
                toba::db('nodos')->consultar($sql);
                
                $where1=" WHERE (p.pertenece_a=".$id_nodo." or p.pertenece_a in (select id_nodo from auxiliar)"
                        . " or c.pertenece_a=".$id_nodo. " or c.pertenece_a in (select id_nodo from auxiliar))";
                $where2=" and (c.pertenece_a=".$id_nodo." or c.pertenece_a in (select id_nodo from auxiliar))";
                $where3=" WHERE (c.pertenece_a=".$id_nodo." or c.pertenece_a in (select id_nodo from auxiliar))";
                
            }else{
                $where1='';
                $where2='';
                $where3='';
            }
            //algunos puestos pueden no estar ocupados en el mes actual, por eso recupero la dependencia del puesto en algunos casos
        $sql="select distinct *, case when costosub is not null then costosub-costo_basico else 0 end as difer from (".
//             " select case when c.id_cargo is null then 'V' else case when n.id_novedad is not null then 'P' else 'A' end end as puesto,c.id_cargo,p.tipo,no.id_nodo,case when no.desc_abrev is null and no.descripcion is null then nop.descripcion else case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end end as dep ,pe.legajo,pe.apellido,pe.nombre,p.id_puesto,p.categ as catpuesto,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ, case when s.categ is not null then coss.costo_basico else null end as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.desc_abrev end as pase
//                from puesto p
//                left outer join cargo c on (p.id_puesto=c.id_puesto and  c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null))
//                left outer join nodo no on (no.id_nodo=c.pertenece_a)
//                left outer join nodo nop on (nop.id_nodo=p.pertenece_a)
//                left outer join persona pe on (pe.id_persona=c.id_persona)
//                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
//                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
//                left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.tipo='T' and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde)
//                left outer join nodo nod on (nod.id_nodo=pa.destino)
//                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
//                                 (select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 where c.codigo_categ=sub.codigo_categ)cos 
//                            on (p.categ=cos.codigo_categ)
//                 left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
//                                 (select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 where c.codigo_categ=sub.codigo_categ)coss 
//                            on (s.categ=coss.codigo_categ)".                              
                  "select case when c.id_cargo is null or not(c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)) then 'V' else case when c.id_cargo is not null and (n.id_novedad is not null or c.chkstopliq=1 or pe.estado='P') then 'P' else 'A' end end as puesto, c.chkstopliq ,pe.estado, c.id_cargo,p.tipo,no.id_nodo,case when no.desc_abrev is null and no.descripcion is null then nop.desc_abrev else case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end end as dep ,pe.legajo,pe.apellido,pe.nombre,p.id_puesto,p.categ as catpuesto,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ, case when s.categ is not null then coss.costo_basico else null end as costosub,cos.costo_basico,cp.costo_basico as costo_basico_p,case when nod.desc_abrev is null then nod.descripcion else nod.desc_abrev end as pase
                    from
                    (select pu.id_puesto,pu.pertenece_a,pu.tipo,pu.categ,max(fec_alta) as alta from puesto pu 
                    left outer join cargo ca on (pu.id_puesto=ca.id_puesto)                         
                    group by pu.id_puesto,pu.pertenece_a,pu.tipo,pu.categ)p
                    left outer join cargo c on (c.fec_alta=p.alta and c.id_puesto=p.id_puesto)
                    left outer join persona pe on (pe.id_persona=c.id_persona)
                    left outer join nodo no on (no.id_nodo=c.pertenece_a)
                    left outer join nodo nop on (nop.id_nodo=p.pertenece_a)"
                    //"left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                    //por si tiene dos subrogancias y las dos abiertas (sin baja), tomo la de mayor fecha desde
                    ." left outer join (select s.id_cargo,max(desde) as desde from subroga s
                                    where 
                                    s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null)
                                    group by s.id_cargo    )sub2 on (sub2.id_cargo=c.id_cargo)
                        left outer join (select s.id_cargo,s.desde,s.categ  from subroga s
                                    where
                                    s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null) )s on (sub2.id_cargo=s.id_cargo and sub2.desde=s.desde)                 "
                    . " left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                    left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.tipo='T' and ('".$actual."' <=pa.hasta or pa.hasta is null) and '".$actual."'>=pa.desde)
                    left outer join nodo nod on (nod.id_nodo=pa.destino)
                    left outer join (	select sub.*,costo_basico from 
				(select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))cos 
                            on (c.codc_categ=cos.codigo_categ)
                 left outer join (	select sub.*,costo_basico from 
				(select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))coss 
                            on (s.categ=coss.codigo_categ)
                    left outer join (	select sub.*,costo_basico from 
				(select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))cp 
                            on (p.categ=cp.codigo_categ)        ".                        
                $where1
                
                . " UNION "//cargos que no estan asociados a puestos
                ."select '' as puesto,c.chkstopliq,pe.estado,c.id_cargo,null as tipo,no.id_nodo,case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end as dep,pe.legajo,pe.apellido,pe.nombre,null,null catpuesto,c.id_cargo,codc_categ ,fec_alta,fec_baja,n.tipo_nov,s.categ,coss.costo_basico as costosub,cos.costo_basico,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
                from cargo c
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)"
                //."left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                //por si tiene dos subrogancias y las dos abiertas (sin baja), tomo la de mayor fecha desde
                  ." left outer join (select s.id_cargo,max(desde) as desde from subroga s
                                    where 
                                    s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null)
                                    group by s.id_cargo    )sub2 on (sub2.id_cargo=c.id_cargo)
                        left outer join (select s.id_cargo,s.desde,s.categ  from subroga s
                                    where
                                    s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null) )s on (sub2.id_cargo=s.id_cargo and sub2.desde=s.desde)                 "
                ." left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.tipo='T' and ('".$actual."' <=pa.hasta or pa.hasta is null) and '".$actual."'>=pa.desde)
                left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select sub.*,cc.costo_basico from 
				(select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))cos 
                            on (c.codc_categ=cos.codigo_categ)
                left outer join (	select sub.*,costo_basico from 
				(select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 left outer join costo_categoria cc on (cc.codigo_categ=sub.codigo_categ and cc.desde=sub.desde ))coss 
                            on (s.categ=coss.codigo_categ)
                "." WHERE ".                       
                "  c.id_puesto is null 
                and c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)".$where2
//                ." UNION "
//                ." select 'D' as puesto,c.chkstopliq,pe.estado,c.id_cargo,null,c.pertenece_a,null,pe.legajo, pe.apellido,pe.nombre,null,null,null,null,null,null,null,null,null,null,co2.costo_basico -co.costo_basico,null
//                   from 
//                    (select c.id_cargo,c.chkstopliq ,c.id_persona,pertenece_a,c.codc_categ,s.categ 
//                    from cargo c, subroga s 
//                    where (c.id_cargo=s.id_cargo)
//                    and c.codc_categ>s.categ
//                    and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null)
//                    and motivo='CSER')c
//                    left outer join (select sub.*,costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                                 left outer join costo_categoria cc on (sub.codigo_categ=cc.codigo_categ))co on (c.codc_categ=co.codigo_categ)
//                    left outer join (select sub.*,costo_basico from 
//				(select codigo_categ,max(desde) as desde from costo_categoria
//                                 group by codigo_categ)sub
//                    left outer join costo_categoria cc on (sub.codigo_categ=cc.codigo_categ))co2 on (c.categ=co2.codigo_categ) 
//                    left outer join persona pe on (pe.id_persona=c.id_persona)
//                    left outer join nodo n on (n.id_nodo=c.pertenece_a)
//                    $where3"
                . ")sub"
               
                 ." order by apellido,nombre,puesto";
	
	return $sql;
       
       
   }
   function get_listado2($cond=null){
      $id_nodo=null;
        if(count($cond)>0){
            if(isset($cond['id_nodo'])){
                $id_nodo=$cond['id_nodo']['valor'];
             }
            $where=" WHERE 1=1 ";
            if (isset($cond['puesto'])) {
                if($cond['puesto']['valor']=='Nulo'){
                    $condicion=" =''";
                }else{
                    $condicion=" = '".$cond['puesto']['valor']."'";
                }
                $where.=" and puesto".$condicion;
            }
            
            if(isset($cond['codc_categ'])){
                
                switch (trim($cond['codc_categ']['valor'])) {
                    case '01': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case '02': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case '03': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case '04': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case '05': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case '06': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case '07': $where.=" and codc_categ='".$cond['codc_categ']['valor']."'";    break;
                    case 'LS':   $where.=" and codc_categ like '".$cond['codc_categ']['valor']."%'";  break;
                    case 'LO':  $where.=" and codc_categ like '".$cond['codc_categ']['valor']."%'";  break;
                    case 'SC':  $where.=" and codc_categ in ('01','02','03','04','05','06','07')";  break;
                    default:
                        break;
                }
                //$where.=" and codc_categ='".$cond['codc_categ']['valor']."'";
            }
            if(isset($cond['categ'])){
                $where.=" and categ='".$cond['categ']['valor']."'";
            }
            if(isset($cond['catpuesto'])){
                $where.=" and catpuesto='".$cond['catpuesto']['valor']."'";
            }
        }else{
            $where='';
           
            }
       
       $sql=dt_cargo::armar_consulta($id_nodo);
       $sql="select sub3.*,credito-gastotot as saldo,trim(apellido)||', '|| trim(nombre) as agente from ("
               . "select *,case when gasto>0 then gasto+difer else 0 end as gastotot from ("
               . "select *,case when puesto='A' or puesto='P' or puesto='V' or puesto='D' then costo_basico_p else 0 end as credito ,"
               //. " case when ((puesto='A' and pase is null) or ((puesto ='' or puesto is null) and pase is null and tipo_nov is null)) and (chkstopliq=0 or chkstopliq is null)  then costo_basico else 0 end as gasto"
               ." case when (puesto='A' or (puesto ='' or puesto is null)) and pase is null and tipo_nov is null and (chkstopliq=0 or chkstopliq is null) and estado<>'P'  then costo_basico else 0 end as gasto"
               . " from (".$sql.") sub"
               .") sub2"
               . ") sub3"
               . $where;
     
      //si el puesto es A y no tien pase temporal vigente entonces gasta
       return toba::db('nodos')->consultar($sql);
   }
   function agregar_cargo($datos=array()){
       $sql="select * from cargo where id_persona=".$datos['id_persona']." and fec_alta='".$datos['fec_alta']."'";
       $res=toba::db('nodos')->consultar($sql);
       if(count($res)==0){
           $sql="INSERT INTO cargo( nro_cargo, id_persona, fec_alta, fec_baja, pertenece_a, 
            codc_carac, codc_categ, codc_agrup, forma_modif, chkstopliq, 
            id_puesto, generado_x_pase)
    VALUES ( null,". $datos['id_persona'].",'". $datos['fec_alta']."',null,". $datos['pertenece_a'].",'". 
            $datos['codc_carac']."','". $datos['codc_categ']."','". $datos['codc_agrup']."',"."null,0,null,". $datos['generado_x_pase'].")";
            toba::db('nodos')->consultar($sql);
            return 1;//devuelve 1 si realizo la insercion y 0 en caso contrario
       }else{
           return 0;
       }
       
   }
   //modifica la fecha desde del cargo generado por el pase transitorio
   function modificar_alta($id_cargo,$destino,$desde){
       //busco el pase transitorio del cargo al destino
       $sql="select * from pase where id_cargo=".$id_cargo." and destino=".$destino." and tipo='T'";
       $res=toba::db('nodos')->consultar($sql);
       
       if(count($res)>0){
          $sql="update cargo set fec_alta='".$desde."' where generado_x_pase=".$res[0]['id_pase']; 
          toba::db('nodos')->consultar($sql);
          return 1;
       }else{
           return 0;
       }
   }
    function modificar_baja($id_cargo,$desde){
         $sql="update cargo set fec_baja='".$desde."' where id_cargo=".$id_cargo;
         toba::db('nodos')->consultar($sql);
     }
   function finaliza_cargo($id_cargo,$desde){
       $sql="update cargo set fec_baja='".$desde."' where id_cargo=".$id_cargo;
       toba::db('nodos')->consultar($sql);
   }
   function eliminar($id_pase){//elimina el cargo o los cargos generados por el pase
       $sql="delete from cargo where generado_x_pase=".$id_pase;
       toba::db('nodos')->consultar($sql);
   }
   function abrir($id_cargo){//elimina el cargo o los cargos generados por el pase
       $sql="update cargo set fec_baja=null where id_cargo=".$id_cargo;
       toba::db('nodos')->consultar($sql);
   }
}

?>