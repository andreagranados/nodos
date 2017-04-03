------------------------------------------------------------
--[3959]--  DT - subroga 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'nodos', --proyecto
	'3959', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'24', --punto_montaje
	'dt_subroga', --subclase
	'datos/dt_subroga.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'DT - subroga', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'nodos', --fuente_datos_proyecto
	'nodos', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2017-03-30 16:41:46', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'24', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'subroga', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'0', --modificar_claves
	'nodos', --fuente_datos_proyecto
	'nodos', --fuente_datos
	'1', --permite_actualizacion_automatica
	NULL, --esquema
	'public'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1745', --col_id
	'id_cargo', --columna
	'E', --tipo
	'1', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1746', --col_id
	'categ', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'4', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1747', --col_id
	'desde', --columna
	'F', --tipo
	'1', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1748', --col_id
	'hasta', --columna
	'F', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1749', --col_id
	'motivo', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'4', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1750', --col_id
	'resol', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'10', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3959', --objeto
	'1751', --col_id
	'surge_de', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'subroga'  --tabla
);
--- FIN Grupo de desarrollo 0
