<?php
class ci_puestos extends nodos_ci
{
         protected $s__datos_filtro;
        //-----------------------------------------------------------------------------------
	//---- filtros ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtros(toba_ei_filtro $filtro)
	{
            if (isset($this->s__datos_filtro)) {
                $filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtros__filtrar($datos)
	{
            $this->s__datos_filtro = $datos;
            $this->s__where = $this->dep('filtros')->get_sql_where();
	}

	function evt__filtros__cancelar()
	{
            unset($this->s__datos_filtro);
            unset($this->s__where);
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            if (isset($this->s__datos_filtro)) {
                $cuadro->set_datos($this->dep('datos')->tabla('puesto')->get_listado_puestos($this->s__datos_filtro)) ;        
           }else{
                $cuadro->set_datos($this->dep('datos')->tabla('puesto')->get_listado_puestos()) ;        
           }
	}

	
	function evt__cuadro__seleccion($seleccion)
	{
            $this->dep('datos')->tabla('puesto')->cargar($seleccion);
            $this->set_pantalla('pant_detalle');
	}

}
?>