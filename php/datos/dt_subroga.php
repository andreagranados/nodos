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
                ." group by s.id_cargo,s.categ,desde,hasta, motivo,resol,surge_de)
                sub
                left outer join cargo ca on (sub.surge_de=ca.id_puesto and ca.fec_alta=sub.fec_alta )
                left outer join persona pe on (pe.id_persona=ca.id_persona)";
            
        return toba::db('nodos')->consultar($sql);
    }
}
?>