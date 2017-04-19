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
       $actual=date("Y-m-d");
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
                $where1=" WHERE (p.pertenece_a=".$id_nodo." or p.pertenece_a in (select id_nodo from auxiliar)"
                        . " or c.pertenece_a=".$id_nodo. " or c.pertenece_a in (select id_nodo from auxiliar))";
                
                $where2=" and (c.pertenece_a=".$id_nodo." or c.pertenece_a in (select id_nodo from auxiliar))";
            }else{
                $where1='';
                $where2='';
            }
            //algunos puestos pueden no estar ocupados en el mes actual, por eso no tenia c.pertenece_a recupero la dependencia del puesto en algunos casos
        $sql="select distinct * ,costosub-costo_basico as dif from (
             select case when c.id_cargo is null then 'V' else case when n.id_novedad is not null then 'P' else 'A' end end as puesto,c.id_cargo,p.tipo,no.id_nodo,case when no.desc_abrev is null and case when nop.desc_abrev is null then nop.descripcion else nop.desc_abrev end is null then nop.descripcion else case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end end as dep,pe.legajo,pe.apellido,pe.nombre,p.id_puesto,p.categ as catpuesto,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ, case when s.categ is not null then coss.costo_basico else null end as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
                from puesto p
                left outer join cargo c on (p.id_puesto=c.id_puesto and  c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null))
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join nodo nop on (nop.id_nodo=p.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)
                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde )
                left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (p.categ=cos.codigo_categ)
                 left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)coss 
                            on (s.categ=coss.codigo_categ)                              
                                          
                ".$where1
                
                . " UNION "//cargos que no estan asociados a puestos
                ."select '' as puesto,c.id_cargo,null as tipo,no.id_nodo,case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end as dep,pe.legajo,pe.apellido,pe.nombre,null,codc_categ,c.id_cargo,codc_categ ,fec_alta,fec_baja,n.tipo_nov,s.categ,null as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
                from cargo c
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)
                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde)
                left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (c.codc_categ=cos.codigo_categ)
                "." WHERE ".                       
                "  c.id_puesto is null 
                and c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)".$where2
                
               
                . ")sub"
                 ." order by apellido,nombre";
	
	return toba::db('nodos')->consultar($sql);
    }
    function get_cargos($filtro=array())
    {
       $actual=date("Y-m-d");
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
        $where = "";
        if (isset($filtro['id_persona'])) {
	   $where.= " WHERE id_persona=".$filtro['id_persona'];
         }
       
        
//        $sql="select c.id_cargo,c.codc_carac,c.codc_categ ,c.codc_agrup,c.fec_alta,c.fec_baja,case when c.chkstopliq=0 then 'NO' else 'SI' end as chkstopliq ,n.descripcion as pertenece_a,case when p.tipo=1 then 'P_' else 'T_' end ||p.id_puesto||'_categ'|| p.categ as puesto,nod.descripcion as pase"
//                . " from cargo c"
//                . " left outer join puesto p on (c.id_puesto=p.id_puesto)"
//                . " left outer join nodo n on (c.pertenece_a=n.id_nodo)"
//                . " left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.tipo='T' and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde)"
//                . " left outer join nodo nod on (nod.id_nodo=pa.destino)"
//                .$where
//                ." order by fec_alta desc";
        $sql="select sub.*,s.categ as subroga,nod.descripcion as pase from (
                select c.id_persona,c.id_cargo,c.codc_carac,c.codc_categ ,c.codc_agrup,c.fec_alta,c.fec_baja,case when c.chkstopliq=0 then 'NO' else 'SI' end as chkstopliq ,n.descripcion as pertenece_a,case when p.tipo=1 then 'P_' else 'T_' end ||p.id_puesto||'_categ'|| p.categ as puesto,max(pa.desde) as pase_desde
                 from cargo c
                 left outer join puesto p on (c.id_puesto=p.id_puesto)
                 left outer join nodo n on (c.pertenece_a=n.id_nodo)
                 left outer join pase pa on (pa.id_cargo=c.id_cargo)
                 group by c.id_persona,c.id_cargo,codc_carac,codc_categ,codc_agrup,fec_alta,fec_baja,c.chkstopliq,n.descripcion ,c.pertenece_a, puesto
                 )sub
                left outer join pase p on (sub.id_cargo=p.id_cargo and p.desde=sub.pase_desde)                                       
                left outer join nodo nod on (nod.id_nodo=p.destino)                      
                left outer join subroga s on (s.id_cargo=sub.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))                      
                    $where
                order by fec_alta desc";
        return toba::db('nodos')->consultar($sql);
    }
   function armar_consulta($id_nodo=null){
       $actual=date("Y-m-d");
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
                
                $where1=" WHERE (p.pertenece_a=".$id_nodo." or p.pertenece_a in (select id_nodo from auxiliar)"
                        . " or c.pertenece_a=".$id_nodo. " or c.pertenece_a in (select id_nodo from auxiliar))";
                $where2=" and (c.pertenece_a=".$id_nodo." or c.pertenece_a in (select id_nodo from auxiliar))";
            }else{
                $where1='';
                $where2='';
            }
            //algunos puestos pueden no estar ocupados en el mes actual, por eso recupero la dependencia del puesto en algunos casos
        $sql="select distinct * ,costosub-costo_basico as dif from (
             select case when c.id_cargo is null then 'V' else case when n.id_novedad is not null then 'P' else 'A' end end as puesto,c.id_cargo,p.tipo,no.id_nodo,case when no.desc_abrev is null and no.descripcion is null then nop.descripcion else case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end end as dep ,pe.legajo,pe.apellido,pe.nombre,p.id_puesto,p.categ as catpuesto,c.id_cargo,codc_categ,fec_alta,fec_baja,n.tipo_nov,s.categ, case when s.categ is not null then coss.costo_basico else null end as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.desc_abrev end as pase
                from puesto p
                left outer join cargo c on (p.id_puesto=c.id_puesto and  c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null))
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join nodo nop on (nop.id_nodo=p.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)
                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.tipo='T' and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde)
                left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (p.categ=cos.codigo_categ)
                 left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)coss 
                            on (s.categ=coss.codigo_categ)                              
                                          
                ".$where1
                
                . " UNION "//cargos que no estan asociados a puestos
                ."select '' as puesto,c.id_cargo,null as tipo,no.id_nodo,case when no.desc_abrev is not null then no.desc_abrev else no.descripcion end as dep,pe.legajo,pe.apellido,pe.nombre,null,codc_categ,c.id_cargo,codc_categ ,fec_alta,fec_baja,n.tipo_nov,s.categ,null as costosub,cos.costo_basico,case when nod.desc_abrev is null then nod.descripcion else nod.descripcion end as pase
                from cargo c
                left outer join nodo no on (no.id_nodo=c.pertenece_a)
                left outer join persona pe on (pe.id_persona=c.id_persona)
                left outer join subroga s on (s.id_cargo=c.id_cargo and s.desde <='".$udia."' and (s.hasta>='".$pdia."' or s.hasta is null))
                left outer join novedad n on (n.id_cargo=c.id_cargo and n.desde <='".$udia."' and (n.hasta>='".$pdia."' or n.hasta is null))
                left outer join pase pa on (pa.id_cargo=c.id_cargo and pa.tipo='T' and '".$actual."' <=pa.hasta and '".$actual."'>=pa.desde)
                left outer join nodo nod on (nod.id_nodo=pa.destino)
                left outer join (select c.codigo_categ,c.desde,costo_basico from costo_categoria c,
                                 (select codigo_categ,max(desde) as desde from costo_categoria
                                 group by codigo_categ)sub
                                 where c.codigo_categ=sub.codigo_categ)cos 
                            on (c.codc_categ=cos.codigo_categ)
                "." WHERE ".                       
                "  c.id_puesto is null 
                and c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null)".$where2
                
               
                . ")sub"
                 ." order by apellido,nombre";
	
	return $sql;
       
       
   }
   function get_listado2($id_nodo=null){
       $sql=dt_cargo::armar_consulta($id_nodo);
       $sql="select *,gasto+difer as gastotot from ("
               . "select *,case when costosub is not null then costosub-costo_basico else 0 end as difer,case when puesto='A' or puesto='P' or puesto='V' then costo_basico else 0 end as credito ,"
               . " case when ((puesto='A' and pase is null) or puesto ='') then costo_basico else 0 end as gasto"
               . " from (".$sql.") sub"
               .") sub2";
      //si el puesto es A y no tien pase temporal vigente entonces gasta
       //si el puesto es A y no tienen pase temporal vigente entonces gasta
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