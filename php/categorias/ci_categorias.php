<?php
class ci_categorias extends nodos_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(nodos_ei_cuadro $cuadro)
	{
           $cuadro->set_datos( $this->dep('datos')->tabla('categoria')->get_descripciones()); 
	}

	function evt__cuadro__seleccion($seleccion)
	{
	}

}
?>