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
            (select  pe.apellido,pe.nombre,pe.legajo,c.codc_carac,c.codc_categ,s.categ,s.desde,s.hasta,s.motivo,s.resol,c.pertenece_a,surge_de,max(ca.fec_alta)as alta
            from subroga s
            left outer join cargo c on (c.id_cargo=s.id_cargo)                
            left outer join persona pe on (pe.id_persona=c.id_persona)                
            left outer join cargo ca on (ca.id_puesto=s.surge_de)                
            group by pe.apellido,pe.nombre,pe.legajo,c.codc_carac,c.codc_categ,s.categ,s.desde,s.hasta,s.motivo,s.resol,c.pertenece_a,surge_de
            )sub
            left outer join cargo c on (sub.alta=c.fec_alta and c.id_puesto=sub.surge_de)
            left outer join persona pe on (pe.id_persona=c.id_persona)
            left outer join nodo n on (n.id_nodo=sub.pertenece_a)
            )sub2
            left outer join nodo no on (no.id_nodo=nod)
            $where
            order by apellido,nombre";
         
        return toba::db('nodos')->consultar($sql);
    }
}
?>