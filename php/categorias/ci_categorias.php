<?php
class ci_categorias extends nodos_ci
{
        protected $s__mostrar_p;
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
           $cuadro->set_datos( $this->dep('datos')->tabla('categoria')->get_descripciones()); 
	}

	function evt__cuadro__seleccion($seleccion)
	{
             $this->dep('datos')->tabla('categoria')->cargar($seleccion);
             $this->set_pantalla('pant_edicion');
	}
        function evt__cuadro__det($seleccion)
        {
            $this->dep('datos')->tabla('categoria')->cargar($seleccion);
            $this->set_pantalla('pant_detalle');
            
        }

	//-----------------------------------------------------------------------------------
	//---- form_categ -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_categ(toba_ei_formulario $form)
	{
            if($this->dep('datos')->tabla('categoria')->esta_cargada()){
                $datos = $this->dep('datos')->tabla('categoria')->get();              
                return $datos;
            
            }
	}

	function evt__form_categ__alta($datos)
	{
            $this->dep('datos')->tabla('categoria')->set($datos);
            $this->dep('datos')->tabla('categoria')->sincronizar();
            toba::notificacion()->agregar('Se ha guardado correctamente', 'info');
            $this->set_pantalla('pant_inicial');
	}

	function evt__form_categ__baja($datos)
	{
            $this->dep('datos')->tabla('categoria')->eliminar_todo();
            $this->dep('datos')->tabla('categoria')->resetear();
            toba::notificacion()->agregar('La categoria se ha eliminado correctamente', 'info');
	}

	function evt__form_categ__modificacion($datos)
	{
            $this->dep('datos')->tabla('categoria')->set($datos);
            $this->dep('datos')->tabla('categoria')->sincronizar();
            toba::notificacion()->agregar('Se ha guardado correctamente', 'info');
            $this->set_pantalla('pant_inicial');
	}

	function evt__form_categ__cancelar($datos)
	{
           $this->dep('datos')->tabla('categoria')->resetear();
           $this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_cc --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cc(toba_ei_cuadro $cuadro)
	{
            if($this->dep('datos')->tabla('categoria')->esta_cargada()){
                $cat=$this->dep('datos')->tabla('categoria')->get();
                $cuadro->set_datos($this->dep('datos')->tabla('costo_categoria')->get_costos($cat['codigo_categ'])); 
            }
	}

	function evt__cuadro_cc__seleccion($seleccion)
	{
            $this->dep('datos')->tabla('costo_categoria')->cargar($seleccion);
            $this->s__mostrar_p=1;
	}
//------eventos
        function evt__agregar(){
            $this->dep('datos')->tabla('categoria')->resetear();
            $this->set_pantalla('pant_edicion');              
        }
        function evt__agregarc(){
            $this->dep('datos')->tabla('costo_categoria')->resetear();
            $this->s__mostrar_p=1;
        }
        function evt__volver(){
            $this->set_pantalla('pant_inicial');              
        }
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__agregar = function()
		{
		}
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__volver = function()
		{
		}
		";
	}


	//-----------------------------------------------------------------------------------
	//---- form_cc ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_cc(toba_ei_formulario $form)
	{
             if($this->s__mostrar_p==1){
                  $this->dep('form_cc')->descolapsar();
             }else{
                 $this->dep('form_cc')->colapsar();
             }
             if ($this->dep('datos')->tabla('costo_categoria')->esta_cargada()) {
                $datos=$this->dep('datos')->tabla('costo_categoria')->get();
                
		}
             if ($this->dep('datos')->tabla('categoria')->esta_cargada()) {
                $cat=$this->dep('datos')->tabla('categoria')->get();
                $datos['codigo_categ']=$cat['codigo_categ'];
             }
           
             $form->set_datos($datos);
                
	}

	function evt__form_cc__alta($datos)
	{
            $categ=$this->dep('datos')->tabla('categoria')->get();
            $datos['codigo_categ']=$categ['codigo_categ'];
            $this->dep('datos')->tabla('costo_categoria')->set($datos);
            $this->dep('datos')->tabla('costo_categoria')->sincronizar();
            toba::notificacion()->agregar('Se ha agregado un nuevo costo correctamente', 'info');
            $this->s__mostrar_p=0;
	}

	function evt__form_cc__baja($datos)
	{
            $this->dep('datos')->tabla('costo_categoria')->eliminar_todo();
            $this->dep('datos')->tabla('costo_categoria')->resetear();
            toba::notificacion()->agregar('Se ha eliminado correctamente', 'info');
	}

	function evt__form_cc__modificacion($datos)
	{
            //la categoria no se modifica
            $categ=$this->dep('datos')->tabla('categoria')->get();
            $datos['codigo_categ']=$categ['codigo_categ'];
            $this->dep('datos')->tabla('costo_categoria')->set($datos);
            $this->dep('datos')->tabla('costo_categoria')->sincronizar();
	}

	function evt__form_cc__cancelar($datos)
	{
               $this->s__mostrar_p=0;
	}

	//-----------------------------------------------------------------------------------
	//---- form_encabezado --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_encabezado(toba_ei_formulario $form)
	{
             if ($this->dep('datos')->tabla('categoria')->esta_cargada()) {
                $categ=$this->dep('datos')->tabla('categoria')->get();
                $texto='Categoria: '.$categ['codigo_categ']." - ".$categ['descripcion'];
                $form->set_titulo($texto);
            }
	}

}
?>