<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class nodos_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'nodos_ci' => 'extension_toba/componentes/nodos_ci.php',
		'nodos_cn' => 'extension_toba/componentes/nodos_cn.php',
		'nodos_datos_relacion' => 'extension_toba/componentes/nodos_datos_relacion.php',
		'nodos_datos_tabla' => 'extension_toba/componentes/nodos_datos_tabla.php',
		'nodos_ei_arbol' => 'extension_toba/componentes/nodos_ei_arbol.php',
		'nodos_ei_archivos' => 'extension_toba/componentes/nodos_ei_archivos.php',
		'nodos_ei_calendario' => 'extension_toba/componentes/nodos_ei_calendario.php',
		'nodos_ei_codigo' => 'extension_toba/componentes/nodos_ei_codigo.php',
		'nodos_ei_cuadro' => 'extension_toba/componentes/nodos_ei_cuadro.php',
		'nodos_ei_esquema' => 'extension_toba/componentes/nodos_ei_esquema.php',
		'nodos_ei_filtro' => 'extension_toba/componentes/nodos_ei_filtro.php',
		'nodos_ei_firma' => 'extension_toba/componentes/nodos_ei_firma.php',
		'nodos_ei_formulario' => 'extension_toba/componentes/nodos_ei_formulario.php',
		'nodos_ei_formulario_ml' => 'extension_toba/componentes/nodos_ei_formulario_ml.php',
		'nodos_ei_grafico' => 'extension_toba/componentes/nodos_ei_grafico.php',
		'nodos_ei_mapa' => 'extension_toba/componentes/nodos_ei_mapa.php',
		'nodos_servicio_web' => 'extension_toba/componentes/nodos_servicio_web.php',
		'nodos_comando' => 'extension_toba/nodos_comando.php',
		'nodos_modelo' => 'extension_toba/nodos_modelo.php',
	);
}
?>