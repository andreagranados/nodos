<?php
class ci_cargo extends nodos_ci
{
    protected $s__mostrar;
    protected $s__mostrar_p;
    protected $s__mostrar_s;
    protected $s__pantalla;
    protected $s__mostrar_d;
	
        function get_origen(){
            if($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()){
                $datos = $this->controlador()->dep('datos')->tabla('cargo')->get();
                return $this->controlador()->dep('datos')->tabla('nodo')->get_origen($datos['id_cargo']); 
            }
        }
        function get_puestos(){
            $salida=array();
            if($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()){
                $datos = $this->controlador()->dep('datos')->tabla('cargo')->get();
                $id_nodo=$this->controlador()->dep('datos')->tabla('cargo')->get_nodo($datos['id_cargo']);    
                if($id_nodo<>0){
                    $salida=$this->controlador()->dep('datos')->tabla('puesto')->get_puestos($id_nodo);
                }
                
                return $salida;
             }
        }
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
            $datos['generado_x_pase']=0;
            $this->controlador()->dep('datos')->tabla('cargo')->set($datos);
            $this->controlador()->dep('datos')->tabla('cargo')->sincronizar();
	}

	function evt__form_cargo__cancelar()
	{
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
                case 'pant_desempenio':$this->dep('datos')->tabla('desempenio')->resetear();$this->s__mostrar_d=1;break;
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
                     //$form->set_datos($datos);
                 }  
                if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                    $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
                    $datos['id_cargo']=$car['id_cargo'];
                 } 
                 $form->set_datos($datos);
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
            //busco los datos del cargo previamente seleccionado
            $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
            $datos['id_cargo']=$car['id_cargo'];
            
            
            //print_r($pase_nuevo);exit;
            if($this->dep('datos')->tabla('pase')->esta_cargada()){//es modificacion
                $pas=$this->dep('datos')->tabla('pase')->get();
                if($pas['tipo']<>$datos['tipo']){
                   toba::notificacion()->agregar('no puede cambiar el tipo del pase', 'info'); 
                }else{
                    $this->dep('datos')->tabla('pase')->set($datos);
                    $this->dep('datos')->tabla('pase')->sincronizar();
                }
            }else{//es alta de un pase nuevo
                $this->dep('datos')->tabla('pase')->set($datos);
                $this->dep('datos')->tabla('pase')->sincronizar();
                $pase_nuevo=$this->dep('datos')->tabla('pase')->get();
                if($datos['tipo']=='T'){//si el pase es temporal
                //ingreso un cargo en la unidad destino
                //la ingresa con fecha de alta = desde
                $nuevo_cargo['id_persona']=$car['id_persona'];
                $nuevo_cargo['codc_carac']=$car['codc_carac'];
                $nuevo_cargo['codc_categ']=$car['codc_categ'];
                $nuevo_cargo['codc_agrup']=$car['codc_agrup'];
                $nuevo_cargo['chkstopliq']=$car['chkstopliq'];
                $nuevo_cargo['fec_alta']=$datos['desde'];
                $nuevo_cargo['pertenece_a']=$datos['destino'];
                $nuevo_cargo['generado_x_pase']=$pase_nuevo['id_pase'];        
                $res=$this->controlador()->dep('datos')->tabla('cargo')->agregar_cargo($nuevo_cargo);
                if($res=1){
                    toba::notificacion()->agregar('Se ha creado un nuevo cargo en el destino del pase', 'info');
                }
            
                }else{//pase definitivo entonces tengo que modificar la fecha del cargo en la unidad destino con la fecha de alta del definitivo
                    $this->controlador()->dep('datos')->tabla('cargo')->modificar_alta($pase_nuevo['id_cargo'],$datos['desde']);
                    toba::notificacion()->agregar('Se ha modificado la fecha del cargo generado a partir del pase temporal', 'info');
                } 
            }
           
           
                 
           
            
            
   
	}
        function evt__form_pase__baja()
	{
            //aqui tengo que borrar tambien el cargo??
            $this->dep('datos')->tabla('pase')->eliminar_todo();
            $this->dep('datos')->tabla('pase')->resetear();
            toba::notificacion()->agregar('El pase ha eliminado correctamente', 'info');
            $this->s__mostrar_p=0;
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
                     //$form->set_datos($datos);
                 }  
                 if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                    $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
                    $datos['id_cargo']=$car['id_cargo'];
                 } 
                 $form->set_datos($datos);
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
        //-----------------------------------------------------------------------------------
	//---- cuadro_desem -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_desem(toba_ei_cuadro $cuadro)
	{
	 if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
                $cuadro->set_datos($this->dep('datos')->tabla('desempenio')->get_depdesemp($car['id_cargo']));
             }
	}
        function evt__cuadro_desem__seleccion($seleccion)
	{
            $this->dep('datos')->tabla('desempenio')->cargar($seleccion);
            $this->s__mostrar_d=1;
	}
	//-----------------------------------------------------------------------------------
	//---- form_desemp ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_desemp(toba_ei_formulario $form)
	{
            if($this->s__mostrar_d==1){
                
                 if($this->dep('datos')->tabla('desempenio')->esta_cargada()){
                     
                     $datos=$this->dep('datos')->tabla('desempenio')->get();
                     $form->set_datos($datos);
                 }  
            }else{
                $this->dep('form_desemp')->colapsar();
            }
	}

	function evt__form_desemp__baja($datos)
	{
            $this->dep('datos')->tabla('desempenio')->eliminar_todo();
            $this->dep('datos')->tabla('desempenio')->resetear();
            toba::notificacion()->agregar('La dependencia de desempenio asociada al cargo ha sido eliminada correctamente', 'info');
            $this->s__mostrar_d=0;
	}

	function evt__form_desemp__modificacion($datos)
	{
            $car=$this->controlador()->dep('datos')->tabla('cargo')->get();
            $datos['id_cargo']=$car['id_cargo'];
            $this->dep('datos')->tabla('desempenio')->set($datos);
            $this->dep('datos')->tabla('desempenio')->sincronizar();
	}

	function evt__form_desemp__cancelar($datos)
	{
            $this->s__mostrar_d=0;
            //$this->dep('datos')->tabla('desempenio')->resetear();
	}

	
}
?>