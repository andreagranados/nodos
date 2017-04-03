<?php
class nodo extends toba_nodo_basico
{
        protected $imagen;
	protected $imagen_origen;
	protected $icono = "item.gif";	
	protected $propiedades = true;
        
        protected $tipo;
		
	function tipo($tipo_dep){
            $this->tipo = $tipo_dep;
            
        }
        
        function set_nombre_largo($nombre){
            $this->nombre_largo = $nombre;
        }
	
	function set_camino($camino)
	{
		
	}
	
        function get_iconos()
	{
            //$im = 'img/'.$this->tipo.'.jpeg';
            $im = 'img/editable.gif';
            $iconos = array();
            $iconos[] = array('imagen' => $im, 'ayuda' => $this->nombre_corto);
            return $iconos;
	}
}
?>