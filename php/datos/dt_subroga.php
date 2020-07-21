<?php
class dt_subroga extends toba_datos_tabla
{
    function get_subrogancias($id_car=null){
        if(!is_null($id_car)){
            $where=" WHERE s.id_cargo=".$id_car;
        }else{
            $where='';
            }
            //obtengo la mayor fecha de alta de los cargos que han ocupado el puesto del que surge la subrogancia
        $sql="select sub.*,sub.id_cargo,ca.id_cargo||'-categ'||ca.codc_categ as cargo,pe.apellido||','||pe.nombre as agente from
            (select s.id_cargo,s.categ,s.desde,s.hasta,s.motivo,s.resol,s.surge_de,max(c.fec_alta) as fec_alta
                from subroga s
                    
                    left outer join cargo c on (c.id_puesto=s.surge_de)
                    ".$where
                ." group by s.id_cargo,s.categ,desde,hasta, motivo,s.resol,surge_de)
                sub
                left outer join cargo ca on (sub.surge_de=ca.id_puesto and ca.fec_alta=sub.fec_alta )
                left outer join persona pe on (pe.id_persona=ca.id_persona)";
        return toba::db('nodos')->consultar($sql);
    }
    function get_subrogancias_($filtro=array()){
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
        $where = " WHERE 1=1 ";
        
        if (isset($filtro['id_nodo'])) {
           $sql ="CREATE LOCAL TEMP TABLE auxiliar(
               id_nodo	integer );";    
           toba::db('nodos')->consultar($sql);
           $sql="select depende_de(".$filtro['id_nodo']['valor'].");";
           toba::db('nodos')->consultar($sql);
           $where.=" and (id_nodo=".$filtro['id_nodo']['valor']." or id_nodo in (select id_nodo from auxiliar)) ";
           
		}
        if (isset($filtro['categ'])) {
            $where.=" and categ='".$filtro['categ']['valor']."'";
            
        }        
        if (isset($filtro['codc_categ'])) {
            $where.=" and sub.codc_categ='".$filtro['codc_categ']['valor']."'";
        }
        
        if (isset($filtro['motivo'])) {
            $where.=" and sub.motivo='".$filtro['motivo']['valor']."'";
        }

        $sql=" select sub2.*,no.descripcion as nodo from (
            select sub.*,pe.apellido as ap,pe.nombre as nom,pe.legajo as leg,origen_de(n.id_nodo)as nod  from                
            
            (select pe.apellido,pe.nombre,pe.legajo,subc.codc_carac,subc.codc_categ,s.categ,s.desde,s.hasta,s.motivo,s.resol,subc.pertenece_a,surge_de,max(ca.fec_alta)as alta
               from (select c.id_cargo,c.id_persona,c.codc_carac,c.codc_categ,c.pertenece_a,max(s.desde) as desde
            		from cargo c
            		left outer join subroga s on (c.id_cargo=s.id_cargo)  
            		where c.fec_alta <='".$udia."' and (c.fec_baja>='".$pdia."' or c.fec_baja is null) 
            		group by c.id_cargo,c.id_persona,codc_carac,c.codc_categ,c.pertenece_a
            	    ) subc
            left outer join subroga s on (subc.id_cargo=s.id_cargo and s.desde=subc.desde)                
            left outer join persona pe on (pe.id_persona=subc.id_persona)                
            left outer join cargo ca on (ca.id_puesto=s.surge_de)     
            group by pe.apellido,pe.nombre,pe.legajo,subc.codc_carac,subc.codc_categ,s.categ,s.desde,s.hasta,s.motivo,s.resol,subc.pertenece_a,surge_de
            )sub

            left outer join cargo c on (sub.alta=c.fec_alta and c.id_puesto=sub.surge_de)
            left outer join persona pe on (pe.id_persona=c.id_persona)
            left outer join nodo n on (n.id_nodo=sub.pertenece_a)
            )sub2
            left outer join nodo no on (no.id_nodo=nod)
            $where
            order by nodo,apellido,nombre ";
        return toba::db('nodos')->consultar($sql);
    }
    function modif_desde($desde_nuevo,$id_cargo,$desde){
        $sql="select * from subroga"
                . " where id_cargo=".$id_cargo
                . " and desde='".$desde_nuevo."'";
        $res= toba::db('nodos')->consultar($sql);
        if(count($res)>0){
           toba::notificacion()->agregar('Repite la fecha desde', 'info');
        }else{
             $sql="update subroga set desde='".$desde_nuevo."' where id_cargo=".$id_cargo." and desde='".$desde."'"; 
             toba::db('nodos')->consultar($sql);
        }
    }
}
?>