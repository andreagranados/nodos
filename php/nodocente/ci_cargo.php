<?php
class ci_cargo extends nodos_ci
{
    protected $s__mostrar;
    protected $s__mostrar_p;
    protected $s__mostrar_s;
    protected $s__pantalla;
	//-----------------------------------------------------------------------------------
	//---- form_cargo -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_cargo(toba_ei_formulario $form)
	{
             if($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()){
                $datos = $this->controlador()->dep('datos')->tabla('cargo')->get();              
                return $datos;
              }
	}

	

	function evt__form_cargo__baja()
	{
            $this->dep('datos')->tabla('cargo')->eliminar_todo();
            $this->dep('datos')->tabla('cargo')->resetear();
            toba::notificacion()->agregar('El cargo se ha eliminado correctamente', 'info');
	}

	function evt__form_cargo__modificacion($datos)
	{
            $this->controlador()->dep('datos')->tabla('cargo')->set($datos);
            $this->controlador()->dep('datos')->tabla('cargo')->sincronizar();
	}

	function evt__form_cargo__cancelar()
	{
	}
        
        function conf__form_encabezado(toba_ei_formulario $form)
	{
             if ($this->controlador()->dep('datos')->tabla('persona')->esta_cargada()) {
                $agente=$this->controlador()->dep('datos')->tabla('persona')->get();
                $texto='Legajo: '.$agente['legajo']." Nombre: ".$agente['apellido'].", ".$agente['nombre'];
                $form->set_titulo($texto);
            }
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_nov -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_nov(toba_ei_cuadro $cuadro)
	{
             if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
                $cuadro->set_datos($this->dep('datos')->tabla('novedad')->get_novedades($car['id_cargo']));
             }
	}
        function evt__cuadro_nov__seleccion($seleccion)
	{
             $this->dep('datos')->tabla('novedad')->cargar($seleccion);
             $this->s__mostrar=1;
	}

	//-----------------------------------------------------------------------------------
	//---- form_nov ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_nov(toba_ei_formulario $form)
	{
            if($this->s__mostrar==1){
                 if($this->dep('datos')->tabla('novedad')->esta_cargada()){
                     $datos=$this->dep('datos')->tabla('novedad')->get();
                     $form->set_datos($datos);
                 }  
            }else{
                $this->dep('form_nov')->colapsar();
            }
	}

	function evt__form_nov__modificacion($datos)
	{
            $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
            $datos['id_cargo']=$car['id_cargo'];
            $this->dep('datos')->tabla('novedad')->set($datos);
            $this->dep('datos')->tabla('novedad')->sincronizar();
	}

	function evt__form_nov__baja()
	{
            $this->dep('datos')->tabla('novedad')->eliminar_todo();
            $this->dep('datos')->tabla('novedad')->resetear();
            toba::notificacion()->agregar('La novedad se ha eliminado correctamente', 'info');
            $this->s__mostrar=0;
	}

	function evt__form_nov__cancelar()
	{
            $this->s__mostrar=0;
            $datos=$this->dep('datos')->tabla('novedad')->resetear();
	}
        //----------
        function evt__agregar(){
            
            switch ($this->s__pantalla){
                case 'pant_novedades':$this->dep('datos')->tabla('novedad')->resetear();$this->s__mostrar=1;break;
                case 'pant_desempenio':break;
                case 'pant_pases':$this->dep('datos')->tabla('pase')->resetear();$this->s__mostrar_p=1;break;
                case 'pant_subrogancia':$this->dep('datos')->tabla('subroga')->resetear();$this->s__mostrar_s=1;break;
            }
        }
        //pantallas
       
        function conf__pant_desempenio(toba_ei_pantalla $pantalla)
	{
            $this->s__pantalla='pant_desempenio';
	}
        function conf__pant_novedades(toba_ei_pantalla $pantalla)
	{
            $this->s__pantalla='pant_novedades';
	}
        function conf__pant_subrogancia(toba_ei_pantalla $pantalla)
	{
            $this->s__pantalla='pant_subrogancia';
	}
        function conf__pant_pases(toba_ei_pantalla $pantalla)
	{
            $this->s__pantalla='pant_pases';
	}	

	//-----------------------------------------------------------------------------------
	//---- cuadro_pase ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_pase(toba_ei_cuadro $cuadro)
	{
            if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
                $cuadro->set_datos($this->dep('datos')->tabla('pase')->get_pases($car['id_cargo']));
             }
	}
        function evt__cuadro_pase__seleccion($seleccion)
	{
             $this->dep('datos')->tabla('pase')->cargar($seleccion);
             $this->s__mostrar_p=1;
	}
        //-----------------------------------------------------------------------------------
	//---- form_pase ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__form_pase(toba_ei_formulario $form)
	{
            if($this->s__mostrar_p==1){
                 if($this->dep('datos')->tabla('pase')->esta_cargada()){
                     $datos=$this->dep('datos')->tabla('pase')->get();
                     $form->set_datos($datos);
                 }  
            }else{
                $this->dep('form_pase')->colapsar();
            }
	}
        function evt__form_pase__cancelar()
	{
            $this->s__mostrar_p=0;
            $datos=$this->dep('datos')->tabla('pase')->resetear();
	}
        function evt__form_pase__modificacion($datos)
	{
            $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
            $datos['id_cargo']=$car['id_cargo'];
            $this->dep('datos')->tabla('pase')->set($datos);
            $this->dep('datos')->tabla('pase')->sincronizar();
	}
        function evt__form_pase__baja()
	{
            $this->dep('datos')->tabla('pase')->eliminar_todo();
            $this->dep('datos')->tabla('pase')->resetear();
            toba::notificacion()->agregar('El pase ha eliminado correctamente', 'info');
            $this->s__mostrar_p=0;
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro_desem -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_desem(toba_ei_cuadro $cuadro)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_sub -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	

	function conf__cuadro_sub(toba_ei_cuadro $cuadro)
	{
            if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
                $cuadro->set_datos($this->dep('datos')->tabla('subroga')->get_subrogancias($car['id_cargo']));
             }
	}
        function evt__cuadro_sub__seleccion($seleccion)
	{
            $this->dep('datos')->tabla('subroga')->cargar($seleccion);
            $this->s__mostrar_s=1;
	}
        //-----------------------------------------------------------------------------------
	//---- form_subroga ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__form_sub(toba_ei_formulario $form)
	{
            if($this->s__mostrar_s==1){
                 if($this->dep('datos')->tabla('subroga')->esta_cargada()){
                     $datos=$this->dep('datos')->tabla('subroga')->get();
                     $form->set_datos($datos);
                 }  
            }else{
                $this->dep('form_sub')->colapsar();
            }
	}
        function evt__form_sub__cancelar()
	{
            $this->s__mostrar_s=0;
            $datos=$this->dep('datos')->tabla('subroga')->resetear();
	}
        function evt__form_sub__modificacion($datos)
	{
            $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
            $datos['id_cargo']=$car['id_cargo'];
            $this->dep('datos')->tabla('subroga')->set($datos);
            $this->dep('datos')->tabla('subroga')->sincronizar();
	}
        function evt__form_sub__baja()
	{
            $this->dep('datos')->tabla('subroga')->eliminar_todo();
            $this->dep('datos')->tabla('subroga')->resetear();
            toba::notificacion()->agregar('La subrogancia ha sido eliminada correctamente', 'info');
            $this->s__mostrar_s=0;
	}

}
?>