<?php

class consultas_mapuche
{
  
 //recupero los cargos nodocentes correspondientes al mes
 function get_cargos($udia,$pdia){

        $sql="select distinct b.codc_uacad,cons.nro_legaj,
            e.desc_appat,e.desc_nombr,e.tipo_estad, b.codc_carac,b.codc_categ,b.codc_agrup,b.chkstopliq,sub.codc_categ as categsub
    from  ( select b.nro_legaj, max(b.nro_cargo) as nro_cargo
              from mapuche.dh03 b  inner join  mapuche.dh11 c on b.codc_categ=c.codc_categ
              where 
               c.tipo_escal='N'
              and b.fec_alta <='".$udia."'  and (b.fec_baja>='".$pdia."'  or b.fec_baja is null)
              and (b.codc_categ='01' or b.codc_categ='02' or b.codc_categ='03' or b.codc_categ='04' or b.codc_categ='05' or b.codc_categ='06' or b.codc_categ='07' )

              --no tiene licencia no remunerada en julio 
              and not exists (select * from  mapuche.dh05 l,mapuche.dl02 m 
                              where ((b.nro_cargo=l.nro_cargo or b.nro_legaj=l.nro_legaj ) and l.fec_desde <= '".$udia."' and (l.fec_hasta >= '".$pdia."'  or l.fec_hasta is null))
                                and  l.nrovarlicencia = m.nrovarlicencia and m.es_remunerada=false )

              group by b.nro_legaj
          )cons 
          inner join mapuche.dh03 b on (b.nro_cargo=cons.nro_cargo)
          inner join mapuche.dh01 e on (cons.nro_legaj=e.nro_legaj)
          left outer join mapuche.dh18 sub on (sub.nro_cargo=b.nro_cargo and sub.fec_desde <='".$udia."' and (sub.fec_hasta>='".$pdia."' or sub.fec_hasta is null))
          order by desc_appat,desc_nombr;";
 	
 		
 	$datos_mapuche = toba::db('mapuche')->consultar($sql);
 	
 	return $datos_mapuche;
 	}
 	
}

?>