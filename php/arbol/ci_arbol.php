<?php
class ci_arbol extends nodos_ci
{
    protected $s__mostrar;
	//-----------------------------------------------------------------------------------
	//---- arbol ------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__arbol(toba_ei_arbol $arbol)
	{
//            require_once('contrib/catalogo_items_menu/toba_catalogo_items_menu.php');
//		$catalogo = new toba_catalogo_items_menu();
//		$raiz = '1';		
//		$catalogo->cargar(array(), $raiz);
//		$nodos = $catalogo->get_hijos($raiz);
//		 
// 
//		
//		//-- Se configura el arbol
//		$arbol->set_mostrar_filtro_rapido(true);
//		$arbol->set_mostrar_ayuda(false);		
//		$arbol->set_nivel_apertura(0);
//		$arbol->set_datos($nodos);
                $nod = $this->dep('datos')->tabla('nodo')->get_descripciones();
               
                //-- Se obtienen los nodos que formar�n parte del arbol
		require_once('catalogo_nodos.php');
		$catalogo = new catalogo_nodos();
                
                $nodos = $catalogo->cargar_nodos($nod);
                //-- Se configura el arbol
		$arbol->set_mostrar_filtro_rapido(true);
		$arbol->set_nivel_apertura(0);
                $arbol->set_ancho_nombres('100px'); 
                
		$arbol->set_datos($nodos);
	}
        function evt__arbol__ver_propiedades($nodo)
        {
           $this->set_pantalla('pant_edicion'); 
           $this->s__mostrar=1;
           $nod['id_nodo'] = $nodo;
           $this->dep('datos')->tabla('nodo')->cargar($nod);
        }
      
        //-----------------------------------------------------------------------------------
	//---- form_nodo ------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_nodo(toba_ei_formulario $form)
	{
          if($this->s__mostrar==1){
            if($this->dep('datos')->tabla('nodo')->esta_cargada()){
                $nod = $this->dep('datos')->tabla('nodo')->get(); 
                return $nod;
              }
          }else{
               $this->dep('form_nodo')->colapsar();
          }
	}
	
	function evt__form_nodo__modificacion($datos)
	{
            $this->dep('datos')->tabla('nodo')->set($datos);
            $this->dep('datos')->tabla('nodo')->sincronizar();
            $auxi=$this->dep('datos')->tabla('nodo')->get();
            $nod['id_nodo']=$auxi['id_nodo'];
            $this->dep('datos')->tabla('nodo')->cargar($nod);
            toba::notificacion()->agregar(utf8_decode('Los datos se guardaron correctamente'), 'info');
	}

	function evt__form_nodo__cancelar()
	{
            $this->dep('datos')->tabla('nodo')->resetear();
            $this->s__mostrar=0;
            $this->set_pantalla('pant_inicial'); 
	}
        function evt__form_nodo__eliminar()
        {
            $this->dep('datos')->tabla('nodo')->eliminar_todo();
            $this->dep('datos')->tabla('nodo')->resetear();
            toba::notificacion()->agregar('El nodo se ha eliminado correctamente', 'info');
            $this->set_pantalla('pant_inicial');
        }

	//-----------------------------------------------------------------------------------
	//---- cuadro_int -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_int(toba_ei_cuadro $cuadro)
	{
             if($this->dep('datos')->tabla('nodo')->esta_cargada()){
                 $nod=$this->dep('datos')->tabla('nodo')->get();
                 $cuadro->set_datos($this->dep('datos')->tabla('cargo')->get_listado($nod['id_nodo']));
             }
            
            
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
           $this->dep('datos')->tabla('nodo')->resetear();
           $this->set_pantalla('pant_edicion'); 
           $this->s__mostrar=1;
	}
        function evt__volver()
	{
           $this->dep('datos')->tabla('nodo')->resetear();
           $this->set_pantalla('pant_inicial'); 
           $this->s__mostrar=0;
	}
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__volver = function()
		{
		}
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__agregar = function()
		{
		}
		";
	}


}
?>