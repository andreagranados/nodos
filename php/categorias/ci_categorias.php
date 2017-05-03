<?php
class ci_categorias extends nodos_ci
{
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
	}

	function evt__form_categ__baja($datos)
	{
	}

	function evt__form_categ__modificacion($datos)
	{
	}

	function evt__form_categ__cancelar($datos)
	{
            $this->dep('datos')->tabla('categoria')->resetear();
            $this->set_pantalla('pant_edicion');
	}

}
?>