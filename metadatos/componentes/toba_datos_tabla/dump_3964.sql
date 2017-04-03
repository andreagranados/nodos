------------------------------------------------------------
--[3964]--  DT - pase 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'nodos', --proyecto
	'3964', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'24', --punto_montaje
	'dt_pase', --subclase
	'datos/dt_pase.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'DT - pase', --nombre
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
	'2017-03-30 19:46:17', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'24', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'pase', --tabla
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
	'3964', --objeto
	'1753', --col_id
	'id_pase', --columna
	'E', --tipo
	'1', --pk
	'pase_id_pase_seq', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1754', --col_id
	'id_cargo', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1755', --col_id
	'tipo', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'1', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1756', --col_id
	'origen', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1757', --col_id
	'destino', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1758', --col_id
	'desde', --columna
	'F', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1759', --col_id
	'hasta', --columna
	'F', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1760', --col_id
	'resol', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'10', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'nodos', --objeto_proyecto
	'3964', --objeto
	'1761', --col_id
	'expediente', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'10', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'pase'  --tabla
);
--- FIN Grupo de desarrollo 0
