<?php
class ci_creditosysaldos extends nodos_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            $cuadro->set_datos($this->dep('datos')->tabla('puesto')->get_credysaldos()); 
            
	}

}

?>