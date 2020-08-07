<?php
class ci_comparacion_mapuche extends toba_ci
{
       protected $s__datos_filtro;
       function conf__filtros_cargo(toba_ei_filtro $filtro)
	{
            if (isset($this->s__datos_filtro)) {
		$filtro->set_datos($this->s__datos_filtro);
            }
	}

	function evt__filtros_cargo__filtrar($datos)
	{
	    $this->s__datos_filtro = $datos;
        }

	function evt__filtros_cargo__cancelar()
	{
		unset($this->s__datos_filtro);
	}
    //---- Cuadro -----------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro)
    {
        if (isset($this->s__datos_filtro)) {
              $cuadro->set_datos($this->dep('datos')->tabla('cargo')->get_comparacion($this->s__datos_filtro));
        }else{
              $cuadro->set_datos($this->dep('datos')->tabla('cargo')->get_comparacion());
        }   
    }
}
?>