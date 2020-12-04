<?php
class ci_consulta extends toba_ci
{
    //---- Cuadro -----------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro)
    {
       $cuadro->set_datos($this->dep('datos')->tabla('cargo')->get_consulta());
           
    }
}
?>