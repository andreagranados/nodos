<?php
class ci_nodocente extends nodos_ci
{
        protected $s__datos_filtro;

	//-----------------------------------------------------------------------------------
	//---- filtros ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtros(toba_ei_formulario $filtro)
	{
            if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtros__filtrar($datos)
	{
            $this->s__datos_filtro = $datos;
	}

	function evt__filtros__cancelar()
	{
            unset($this->s__datos_filtro);
	}

	

	//-----------------------------------------------------------------------------------
	//---- form_persona -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_persona(toba_ei_formulario $form)
	{
          if (isset($this->s__datos_filtro)) {
            $pers['id_persona']=$this->s__datos_filtro['id_persona'];
            $this->dep('datos')->tabla('persona')->cargar($pers);  
            if($this->dep('datos')->tabla('persona')->esta_cargada()){
                $datos = $this->dep('datos')->tabla('persona')->get(); 
                //r($datos);
                $datos['cuil']=$datos['nro_cuil1'].str_pad($datos['nro_cuil'], 8, '0', STR_PAD_LEFT).$datos['nro_cuil2'];
                return $datos;
              }
          }else{
               $this->dep('form_persona')->colapsar();
          }
	}
       
	function evt__form_persona__baja()
	{
            $this->dep('datos')->tabla('persona')->eliminar_todo();
            $this->dep('datos')->tabla('persona')->resetear();
            unset($this->s__datos_filtro);
            toba::notificacion()->agregar('La persona se ha eliminado correctamente', 'info');
	}

	function evt__form_persona__modificacion($datos)
	{
            if(($this->dep('datos')->tabla('persona')->esta_cargada())){//es una modificacion
                $pers=$this->dep('datos')->tabla('persona')->get();  
                $band=$this->dep('datos')->tabla('persona')->repite_cuil_modif($datos['cuil'],$pers['nro_cuil1'],$pers['nro_cuil'],$pers['nro_cuil2']);
                $band2='';
                if(isset($datos['legajo'])){
                    $band2=$this->dep('datos')->tabla('persona')->repite_legajo_modif($datos['legajo'],$pers['legajo']);
                }
               
            }else{//es un alta nueva
                $band=$this->dep('datos')->tabla('persona')->repite_cuil($datos['cuil']);
                $band2='';
            }
       
            if($band==''){
                if($band2==''){
                        if(isset($datos['cuil'])){
                            $datos['nro_cuil1']=substr($datos['cuil'], 0, 2);
                            $datos['nro_cuil']=substr($datos['cuil'], 2, 8);
                            $datos['nro_cuil2']=substr($datos['cuil'], 10, 1);
                        }
                        $datos['apellido']=mb_strtoupper($datos['apellido'],'LATIN1');//convierte a mayusculas
                        $datos['nombre']=mb_strtoupper($datos['nombre'],'LATIN1');//convierte a mayusculas
                        $this->dep('datos')->tabla('persona')->set($datos);
                        $this->dep('datos')->tabla('persona')->sincronizar();
                        $auxi=$this->dep('datos')->tabla('persona')->get();
                        $nod['id_persona']=$auxi['id_persona'];
                        $this->dep('datos')->tabla('persona')->cargar($nod);
                        toba::notificacion()->agregar(utf8_decode('Los datos se guardaron correctamente'), 'info');
                }else{
                        throw new toba_error('Ya existe una persona con ese legajo: '.$band2);
                }
            }else{
               throw new toba_error('Ya existe una persona con ese cuil: '.$band);
            }
           
	}

	function evt__form_persona__cancelar()
	{
             $this->dep('datos')->tabla('persona')->resetear();
             unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- form_botones -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_botones(nodos_ei_formulario $form)
	{
//            if (!isset($this->s__datos_filtro)) {
//                $form->eliminar_evento('cargos');
//            }
            if(!($this->dep('datos')->tabla('persona')->esta_cargada())){
                $form->eliminar_evento('cargos');
            }
	}

	function evt__form_botones__cargos($datos)
	{
            if($this->dep('datos')->tabla('persona')->esta_cargada()){
                 $this->set_pantalla('pant_cargos');  
              }
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_cargos ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cargos(toba_ei_cuadro $cuadro)
	{
            if (isset($this->s__datos_filtro)) {
                $cuadro->set_datos($this->dep('datos')->tabla('cargo')->get_cargos($this->s__datos_filtro));
            }
	}

	function evt__cuadro_cargos__seleccion($seleccion)
	{
            $this->dep('datos')->tabla('cargo')->cargar($seleccion);
            $this->set_pantalla('pant_cargo');
	}
        
        function evt__agregar_persona(){
            $this->dep('datos')->tabla('persona')->resetear();    
            $this->s__datos_filtro['id_persona']=0;
        }
        function evt__agregar(){
            $this->dep('datos')->tabla('cargo')->resetear();
            $this->set_pantalla('pant_cargo');
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
	//---- form_encabezado1 -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_encabezado1(toba_ei_formulario $form)
	{
             if ($this->dep('datos')->tabla('persona')->esta_cargada()) {
                $agente=$this->dep('datos')->tabla('persona')->get();
                $texto='Legajo: '.$agente['legajo']." Nombre: ".$agente['apellido'].", ".$agente['nombre'];
                $form->set_titulo($texto);
            }
	}

	//-----------------------------------------------------------------------------------
	//---- form_encabezado2 -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_encabezado2(toba_ei_formulario $form)
	{
            if ($this->controlador()->dep('datos')->tabla('persona')->esta_cargada()) {
                if ($this->controlador()->dep('datos')->tabla('cargo')->esta_cargada()) {
                $cargo=$this->controlador()->dep('datos')->tabla('cargo')->get();
                $fecha=date_format(date_create($cargo['fec_alta']),'d-m-Y');
                $texto='Cargo: '.$cargo['id_cargo']." Categoria: ".$cargo['codc_categ']." Caracter ".$cargo['codc_carac']." desde: ".$fecha;
                $form->set_titulo($texto);
                }
            }
	}

}
?>