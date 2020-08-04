<?php
class ci_comparacion_mapuche extends toba_ci
{
    //---- Cuadro -----------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro)
    {
        //if (isset($this->s__datos_filtro)) {
              $cuadro->set_datos($this->dep('datos')->tabla('cargo')->get_comparacion());
        //}   
    }
}
?>