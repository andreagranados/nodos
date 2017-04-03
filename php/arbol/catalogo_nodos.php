<?php
require_once('nodo.php');
class catalogo_nodos extends toba_catalogo_items_base 
{
    protected $usa_niveles = false;
    
    function cargar_nodos($datos_base){
       
        if(!empty($datos_base)){
            foreach($datos_base as $pos=>$fila){
                $obj = new nodo( $fila['descripcion'], null, $fila['id_nodo'], $fila['depende_de']);
                $obj->set_nombre_largo($fila['descripcion']);
                $obj->tipo($fila['tipo']);
                
		$this->items[$fila['id_nodo']] = $obj;
            }
            
            $this->ordenar();//Habilita el signo de colapsar/descolapsar el item
            $hijos = array();//Almacena los nodos iniciales
            //$this->items almacena las relaciones padre/hijos
            foreach ($this->items as $item) {
                    if (is_null($item->get_id_padre()))//Muestra solo los nodos que no tienen padre, los nodos iniciales
                        $hijos[] = $item;
                    
            }
            return $hijos;
        }
    }
    
	
}
?>