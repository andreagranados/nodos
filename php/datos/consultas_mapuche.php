<?php

class consultas_mapuche
{
 function get_consulta(){
     $sql="select distinct 
                 cons.nro_cargo,b.codc_uacad, b.codc_categ,b.fec_alta
                ,cons.nro_legaj,
                  e.desc_appat||', '||e.desc_nombr as nombre,e.nro_cuil1||'-'||e.nro_cuil||'-'||e.nro_cuil2 as cuil,
                  sub.codc_categ as categsub,sub.fec_desde,
                  sum(case when codn_conce IN (89) then nov1_conce  else 0 end) as catjub,
                  sum(case when codn_conce IN (-51, -52, -53, -56) then impp_conce  else 0 end) as imp_bruto,
                  sum(case when codn_conce = -55 then impp_conce else 0 end) as imp_aporte,
                  sum(case when codn_conce IN (-51, -52, -53, -56, -55) then impp_conce  else 0 end) as imp_total
                   from  (
                        select distinct c.per_liano,c.per_limes, a.nro_liqui,a.nro_legaj,b.nro_cargo
                        from mapuche.dh21h a 
                        inner join mapuche.dh03 b on (a.nro_cargo=b.nro_cargo)
                        inner join mapuche.dh22 c on (a.nro_liqui=c.nro_liqui)
                        where 
                        codigoescalafon='NODO'
                        and 
                                                  c.per_limes in (11) and
                                                  c.per_liano=2020 and 
                                                  c.sino_aguin=true and
                                              a.codn_fuent=11
                )cons 
                inner join mapuche.dh21h h on (h.nro_liqui=cons.nro_liqui and h.nro_cargo=cons.nro_cargo)
                inner join mapuche.dh22 c on (cons.nro_liqui=c.nro_liqui)
                inner join mapuche.dh03 b on (b.nro_cargo=cons.nro_cargo)
                inner join mapuche.dh01 e on (cons.nro_legaj=e.nro_legaj)
                left outer join mapuche.dh18 sub on sub.nro_cargo=b.nro_cargo and (c.fec_ultap<sub.fec_hasta or sub.fec_hasta is null) and c.fec_ultap>sub.fec_desde  
                where h.codn_fuent=11
                group by 
                 cons.nro_cargo,b.codc_uacad, b.codc_categ,b.fec_alta
                ,cons.nro_legaj,e.desc_appat,e.desc_nombr,e.nro_cuil1,e.nro_cuil,e.nro_cuil2,categsub,sub.fec_desde
                  UNION
                  SELECT * FROM 
(select distinct sub.nro_cargo,sub.codc_uacad,sub.codc_categ,sub.fec_alta,sub.nro_legaj,sub.nombre,case when l.nro_licencia is not null then 'L' else '' end as lic,f.codc_categ as subroga
,f.fec_desde, 8,8,8,8
from 
(select b.desc_appat||','||b.desc_nombr as nombre,b.nro_legaj,a.nro_cargo,a.codc_categ,a.fec_alta,a.codc_uacad ,a.chkstopliq
from mapuche.dh03 a, mapuche.dh01 b, mapuche.dh11 c
where a.fec_alta <= '2020-12-31' and (a.fec_baja >= '2020-12-01' or a.fec_baja is null)
and a.nro_legaj=b.nro_legaj
and c.codc_categ=a.codc_categ) sub
left outer join mapuche.dh18 f on (sub.nro_cargo=f.nro_cargo and (f.fec_hasta>'2020-12-04' or f.fec_hasta is null))
left outer join mapuche.dh05 l on ((sub.nro_cargo=l.nro_cargo or sub.nro_legaj=l.nro_legaj ) and l.fec_desde <= '2020-12-31' and (l.fec_hasta >= '2020-12-01' or l.fec_hasta is null))
left outer join mapuche.dl02 m on ( l.nrovarlicencia = m.nrovarlicencia and m.es_remunerada=false )
order by desc_appat,nro_legaj)
SUB
WHERE tipo_escal='N'
and e.tipo_estad<>'P'
order by desc_appat,desc_nombr";
     return toba::db('mapuche')->consultar($sql);
 } 
 //recupero los cargos nodocentes correspondientes al mes
 function get_cargos($udia,$pdia){

        $sql="select distinct b.codc_uacad,cons.nro_legaj,
            e.desc_appat,e.desc_nombr,e.tipo_estad, b.fec_alta,b.fec_baja,b.codc_carac,b.codc_categ,b.codc_agrup,b.chkstopliq,sub.codc_categ as categsub
            ,case when lic.codn_tipo_lic is null then '' else codn_tipo_lic end as lsgh
    from  ( select b.nro_legaj, max(b.nro_cargo) as nro_cargo
              from mapuche.dh03 b  
              inner join  mapuche.dh11 c on b.codc_categ=c.codc_categ
              where 
               c.tipo_escal='N'
              and b.fec_alta <='".$udia."'  and (b.fec_baja>='".$pdia."'  or b.fec_baja is null)
              and (b.codc_categ='01' or b.codc_categ='02' or b.codc_categ='03' or b.codc_categ='04' or b.codc_categ='05' or b.codc_categ='06' or b.codc_categ='07' or b.codc_categ='CONT')
              group by b.nro_legaj
          )cons 
          inner join mapuche.dh03 b on (b.nro_cargo=cons.nro_cargo)
          inner join mapuche.dh01 e on (cons.nro_legaj=e.nro_legaj)
          left outer join mapuche.dh18 sub on (sub.nro_cargo=b.nro_cargo and sub.fec_desde <='".$udia."' and (sub.fec_hasta>='".$pdia."' or sub.fec_hasta is null))
          left outer join (select * from  mapuche.dh05 l,mapuche.dl02 m 
                              where ( l.fec_desde <= '".$udia."' and (l.fec_hasta >= '".$pdia."'  or l.fec_hasta is null))
                                and  l.nrovarlicencia = m.nrovarlicencia and m.es_remunerada=false )lic on (lic.nro_cargo=cons.nro_cargo or lic.nro_legaj=cons.nro_legaj  )
          order by desc_appat,desc_nombr;";
 	
 		
 	$datos_mapuche = toba::db('mapuche')->consultar($sql);
 	
 	return $datos_mapuche;
 	}
 	
}

?>