--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.15
-- Dumped by pg_dump version 9.2.2
-- Started on 2017-04-03 11:38:41

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 206 (class 3079 OID 11639)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2059 (class 0 OID 0)
-- Dependencies: 206
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 218 (class 1255 OID 318546)
-- Name: depende_de(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION depende_de(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
	reg		record;
  	salida		text;
  	idnod		integer;
	idnod2		integer;
  	x		integer;
  	idraiz		integer;
  	a		integer;

BEGIN
idnod=$1;

	FOR reg IN 
	        select * from nodo where depende_de=idnod
 	     LOOP
 	     --if reg.depende_de=idnod then
 	         --salida:=salida||','||CAST (reg.id_nodo as text);
 	         --return ','||CAST (reg.id_nodo as text);
 	         insert into auxiliar(id_nodo)values(reg.id_nodo);
 	         select into a depende_de(reg.id_nodo);
 	     --end if;
 		
 	END LOOP;



return 1;
END; 
$_$;


ALTER FUNCTION public.depende_de(integer) OWNER TO postgres;

--
-- TOC entry 219 (class 1255 OID 318545)
-- Name: es_hoja(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION es_hoja(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
  reg		record;
  salida	text;
  idnod		integer;
  x		integer;
  hoja		boolean;
  

BEGIN
idnod:=$1;
hoja:=true;

	FOR reg IN 
	        select * from nodo
 	     LOOP
 	     if reg.depende_de=idnod then
 	         return false;
 	     end if;
 		
 	END LOOP;

return hoja;
END; 
$_$;


ALTER FUNCTION public.es_hoja(integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 197 (class 1259 OID 318413)
-- Name: cargo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cargo (
    id_cargo integer NOT NULL,
    nro_cargo integer,
    id_persona integer,
    fec_alta date,
    fec_baja date,
    pertenece_a integer,
    codc_carac character(4),
    codc_categ character(4),
    codc_agrup character(4),
    forma_modif integer,
    chkstopliq integer DEFAULT 0 NOT NULL,
    id_puesto integer
);


ALTER TABLE public.cargo OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 318411)
-- Name: cargo_id_cargo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cargo_id_cargo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cargo_id_cargo_seq OWNER TO postgres;

--
-- TOC entry 2060 (class 0 OID 0)
-- Dependencies: 196
-- Name: cargo_id_cargo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cargo_id_cargo_seq OWNED BY cargo.id_cargo;


--
-- TOC entry 192 (class 1259 OID 318336)
-- Name: categoria; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categoria (
    codigo_categ character(4) NOT NULL,
    descripcion character(20),
    tipo_cat character(4)
);


ALTER TABLE public.categoria OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 318341)
-- Name: costo_categoria; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE costo_categoria (
    codigo_categ character(4) NOT NULL,
    desde date NOT NULL,
    costo_basico numeric,
    costo_diario numeric
);


ALTER TABLE public.costo_categoria OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 318445)
-- Name: desempenio; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE desempenio (
    id_cargo integer NOT NULL,
    id_nodo integer NOT NULL,
    descripcion text
);


ALTER TABLE public.desempenio OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 317442)
-- Name: nodo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nodo (
    id_nodo integer NOT NULL,
    descripcion text NOT NULL,
    depende_de integer,
    tipo integer,
    presupuestario integer,
    desc_abrev character(4)
);


ALTER TABLE public.nodo OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 317440)
-- Name: nodo_id_nodo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nodo_id_nodo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.nodo_id_nodo_seq OWNER TO postgres;

--
-- TOC entry 2061 (class 0 OID 0)
-- Dependencies: 181
-- Name: nodo_id_nodo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE nodo_id_nodo_seq OWNED BY nodo.id_nodo;


--
-- TOC entry 203 (class 1259 OID 318777)
-- Name: novedad; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE novedad (
    id_novedad integer NOT NULL,
    id_cargo integer,
    tipo_nov character(4),
    desde date,
    hasta date,
    norma character(10)
);


ALTER TABLE public.novedad OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 318775)
-- Name: novedad_id_novedad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE novedad_id_novedad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.novedad_id_novedad_seq OWNER TO postgres;

--
-- TOC entry 2062 (class 0 OID 0)
-- Dependencies: 202
-- Name: novedad_id_novedad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE novedad_id_novedad_seq OWNED BY novedad.id_novedad;


--
-- TOC entry 205 (class 1259 OID 319932)
-- Name: pase; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pase (
    id_pase integer NOT NULL,
    id_cargo integer,
    tipo character(1),
    origen integer,
    destino integer,
    desde date,
    hasta date,
    resol character(10),
    expediente character(10)
);


ALTER TABLE public.pase OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 319930)
-- Name: pase_id_pase_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pase_id_pase_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pase_id_pase_seq OWNER TO postgres;

--
-- TOC entry 2063 (class 0 OID 0)
-- Dependencies: 204
-- Name: pase_id_pase_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pase_id_pase_seq OWNED BY pase.id_pase;


--
-- TOC entry 186 (class 1259 OID 317822)
-- Name: persona; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE persona (
    id_persona integer NOT NULL,
    legajo integer,
    apellido character(30),
    nombre character(30),
    nro_doc integer,
    tipo_sexo character(1),
    fec_nacim date,
    nro_cuil1 integer,
    nro_cuil integer,
    nro_cuil2 integer,
    estado character(1),
    fecha_ingreso date,
    tipo_ing integer,
    tipo_doc integer
);


ALTER TABLE public.persona OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 317820)
-- Name: persona_id_persona_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE persona_id_persona_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persona_id_persona_seq OWNER TO postgres;

--
-- TOC entry 2064 (class 0 OID 0)
-- Dependencies: 185
-- Name: persona_id_persona_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE persona_id_persona_seq OWNED BY persona.id_persona;


--
-- TOC entry 195 (class 1259 OID 318366)
-- Name: puesto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE puesto (
    id_puesto integer NOT NULL,
    categ character(4),
    tipo integer,
    pertenece_a integer
);


ALTER TABLE public.puesto OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 318364)
-- Name: puesto_id_puesto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE puesto_id_puesto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.puesto_id_puesto_seq OWNER TO postgres;

--
-- TOC entry 2065 (class 0 OID 0)
-- Dependencies: 194
-- Name: puesto_id_puesto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE puesto_id_puesto_seq OWNED BY puesto.id_puesto;


--
-- TOC entry 200 (class 1259 OID 318488)
-- Name: subroga; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subroga (
    id_cargo integer NOT NULL,
    categ character(4),
    desde date NOT NULL,
    hasta date,
    motivo character(4) DEFAULT NULL::bpchar,
    resol character(10),
    surge_de integer
);


ALTER TABLE public.subroga OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 318307)
-- Name: tipo_categoria; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_categoria (
    sigla character(4) NOT NULL,
    descripcion text
);


ALTER TABLE public.tipo_categoria OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 318291)
-- Name: tipo_doc; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_doc (
    id_tipo integer NOT NULL,
    desc_abrev character(4) NOT NULL,
    desc_item character(30)
);


ALTER TABLE public.tipo_doc OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 318289)
-- Name: tipo_doc_id_tipo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_doc_id_tipo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_doc_id_tipo_seq OWNER TO postgres;

--
-- TOC entry 2066 (class 0 OID 0)
-- Dependencies: 189
-- Name: tipo_doc_id_tipo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_doc_id_tipo_seq OWNED BY tipo_doc.id_tipo;


--
-- TOC entry 184 (class 1259 OID 317793)
-- Name: tipo_ingreso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_ingreso (
    id_tipo integer NOT NULL,
    descripcion character(60)
);


ALTER TABLE public.tipo_ingreso OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 317791)
-- Name: tipo_ingreso_id_tipo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_ingreso_id_tipo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_ingreso_id_tipo_seq OWNER TO postgres;

--
-- TOC entry 2067 (class 0 OID 0)
-- Dependencies: 183
-- Name: tipo_ingreso_id_tipo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_ingreso_id_tipo_seq OWNED BY tipo_ingreso.id_tipo;


--
-- TOC entry 188 (class 1259 OID 317840)
-- Name: tipo_modificacion; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_modificacion (
    id_tipo integer NOT NULL,
    descripcion character(40)
);


ALTER TABLE public.tipo_modificacion OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 317838)
-- Name: tipo_modificacion_id_tipo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_modificacion_id_tipo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_modificacion_id_tipo_seq OWNER TO postgres;

--
-- TOC entry 2068 (class 0 OID 0)
-- Dependencies: 187
-- Name: tipo_modificacion_id_tipo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_modificacion_id_tipo_seq OWNED BY tipo_modificacion.id_tipo;


--
-- TOC entry 180 (class 1259 OID 317431)
-- Name: tipo_nodo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_nodo (
    id_tipo integer NOT NULL,
    descripcion text
);


ALTER TABLE public.tipo_nodo OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 317429)
-- Name: tipo_nodo_id_tipo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_nodo_id_tipo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_nodo_id_tipo_seq OWNER TO postgres;

--
-- TOC entry 2069 (class 0 OID 0)
-- Dependencies: 179
-- Name: tipo_nodo_id_tipo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_nodo_id_tipo_seq OWNED BY tipo_nodo.id_tipo;


--
-- TOC entry 201 (class 1259 OID 318770)
-- Name: tipo_novedad; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_novedad (
    id_tipo character(4) NOT NULL,
    descripcion character(30)
);


ALTER TABLE public.tipo_novedad OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 318483)
-- Name: tipo_subrogancia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_subrogancia (
    sigla character(4) NOT NULL,
    descripcion character(40)
);


ALTER TABLE public.tipo_subrogancia OWNER TO postgres;

--
-- TOC entry 1962 (class 2604 OID 318416)
-- Name: id_cargo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cargo ALTER COLUMN id_cargo SET DEFAULT nextval('cargo_id_cargo_seq'::regclass);


--
-- TOC entry 1956 (class 2604 OID 317445)
-- Name: id_nodo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nodo ALTER COLUMN id_nodo SET DEFAULT nextval('nodo_id_nodo_seq'::regclass);


--
-- TOC entry 1965 (class 2604 OID 318780)
-- Name: id_novedad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY novedad ALTER COLUMN id_novedad SET DEFAULT nextval('novedad_id_novedad_seq'::regclass);


--
-- TOC entry 1966 (class 2604 OID 319935)
-- Name: id_pase; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pase ALTER COLUMN id_pase SET DEFAULT nextval('pase_id_pase_seq'::regclass);


--
-- TOC entry 1958 (class 2604 OID 317825)
-- Name: id_persona; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY persona ALTER COLUMN id_persona SET DEFAULT nextval('persona_id_persona_seq'::regclass);


--
-- TOC entry 1961 (class 2604 OID 318369)
-- Name: id_puesto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY puesto ALTER COLUMN id_puesto SET DEFAULT nextval('puesto_id_puesto_seq'::regclass);


--
-- TOC entry 1960 (class 2604 OID 318294)
-- Name: id_tipo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_doc ALTER COLUMN id_tipo SET DEFAULT nextval('tipo_doc_id_tipo_seq'::regclass);


--
-- TOC entry 1957 (class 2604 OID 317796)
-- Name: id_tipo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_ingreso ALTER COLUMN id_tipo SET DEFAULT nextval('tipo_ingreso_id_tipo_seq'::regclass);


--
-- TOC entry 1959 (class 2604 OID 317843)
-- Name: id_tipo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_modificacion ALTER COLUMN id_tipo SET DEFAULT nextval('tipo_modificacion_id_tipo_seq'::regclass);


--
-- TOC entry 1955 (class 2604 OID 317434)
-- Name: id_tipo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_nodo ALTER COLUMN id_tipo SET DEFAULT nextval('tipo_nodo_id_tipo_seq'::regclass);


--
-- TOC entry 2043 (class 0 OID 318413)
-- Dependencies: 197
-- Data for Name: cargo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cargo VALUES (1, NULL, 1, '1998-01-01', NULL, 22, 'PERM', '01  ', 'ADMI', NULL, 0, 3);
INSERT INTO cargo VALUES (2, NULL, 2, '2007-10-01', NULL, 22, 'PERM', '01  ', 'ADMI', NULL, 0, 6);
INSERT INTO cargo VALUES (3, NULL, 3, '2007-10-01', NULL, 22, 'PERM', '02  ', 'ADMI', NULL, 0, 7);
INSERT INTO cargo VALUES (4, NULL, 4, '2014-09-01', NULL, 22, 'PERM', '05  ', 'ADMI', NULL, 0, 1);
INSERT INTO cargo VALUES (6, NULL, 6, '2013-10-01', NULL, 27, 'PERM', '07  ', 'ADMI', NULL, 0, 4);
INSERT INTO cargo VALUES (7, NULL, 7, '2007-10-01', NULL, 23, 'PERM', '02  ', 'ADMI', NULL, 0, 8);
INSERT INTO cargo VALUES (8, NULL, 8, '2013-10-01', NULL, 24, 'PERM', '07  ', 'ADMI', NULL, 0, 5);
INSERT INTO cargo VALUES (5, NULL, 5, '2007-10-01', NULL, 25, 'PERM', '05  ', 'ADMI', NULL, 0, 2);
INSERT INTO cargo VALUES (10, NULL, 9, '2014-03-01', '2014-08-31', 31, 'PERM', '07  ', 'ADMI', NULL, 0, 10);
INSERT INTO cargo VALUES (9, 9, 9, '2014-09-01', NULL, 30, 'PERM', '05  ', 'TECN', NULL, 0, 9);
INSERT INTO cargo VALUES (11, NULL, 9, '2014-01-01', '2014-02-28', 22, 'TRAN', '07  ', 'ADMI', NULL, 0, NULL);
INSERT INTO cargo VALUES (12, NULL, 10, '2017-03-01', '2017-08-31', 22, 'TRAN', 'CONT', 'ADMI', NULL, 0, NULL);
INSERT INTO cargo VALUES (13, NULL, 11, '2017-03-01', '2017-08-31', 22, 'TRAN', 'CONT', 'ADMI', NULL, 0, NULL);


--
-- TOC entry 2070 (class 0 OID 0)
-- Dependencies: 196
-- Name: cargo_id_cargo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cargo_id_cargo_seq', 9, true);


--
-- TOC entry 2038 (class 0 OID 318336)
-- Dependencies: 192
-- Data for Name: categoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO categoria VALUES ('02  ', 'Categoria 2         ', 'MAPU');
INSERT INTO categoria VALUES ('03  ', 'Categoria 3         ', 'MAPU');
INSERT INTO categoria VALUES ('04  ', 'Categoria 4         ', 'MAPU');
INSERT INTO categoria VALUES ('05  ', 'Categoria 5         ', 'MAPU');
INSERT INTO categoria VALUES ('06  ', 'Categoria 6         ', 'MAPU');
INSERT INTO categoria VALUES ('07  ', 'Categoria 7         ', 'MAPU');
INSERT INTO categoria VALUES ('01  ', 'Categoria 1         ', 'MAPU');
INSERT INTO categoria VALUES ('CONT', 'Cont Locac Serv     ', 'MAPU');


--
-- TOC entry 2039 (class 0 OID 318341)
-- Dependencies: 193
-- Data for Name: costo_categoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO costo_categoria VALUES ('01  ', '2017-02-01', 53004.42, NULL);
INSERT INTO costo_categoria VALUES ('02  ', '2017-02-01', 44170.00, NULL);
INSERT INTO costo_categoria VALUES ('03  ', '2017-02-01', 36747.90, NULL);
INSERT INTO costo_categoria VALUES ('04  ', '2017-02-01', 30565.50, NULL);
INSERT INTO costo_categoria VALUES ('05  ', '2017-02-01', 25432.12, NULL);
INSERT INTO costo_categoria VALUES ('06  ', '2017-02-01', 21201.04, NULL);
INSERT INTO costo_categoria VALUES ('07  ', '2017-02-01', 17668.70, NULL);
INSERT INTO costo_categoria VALUES ('CONT', '2017-02-01', 17668.70, NULL);


--
-- TOC entry 2044 (class 0 OID 318445)
-- Dependencies: 198
-- Data for Name: desempenio; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2028 (class 0 OID 317442)
-- Dependencies: 182
-- Data for Name: nodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO nodo VALUES (3, 'FAIN', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (4, 'FAIF', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (5, 'FAAS', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (6, 'FAHU', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (7, 'ASMA', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (8, 'CRUB', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (9, 'FACA', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (10, 'FACE', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (11, 'AUZA', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (12, 'FALE', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (13, 'FADE', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (14, 'IBMP', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (15, 'CUZA', NULL, 6, 1, NULL);
INSERT INTO nodo VALUES (16, 'FATU', NULL, 1, 1, NULL);
INSERT INTO nodo VALUES (17, 'IMPACO', NULL, 2, 1, NULL);
INSERT INTO nodo VALUES (21, 'FINANZAS', 18, 2, 0, NULL);
INSERT INTO nodo VALUES (2, 'FAEA', NULL, 6, 1, 'FAEA');
INSERT INTO nodo VALUES (22, 'SECRETARIA DE CIENCIA Y TECNICA', 1, 1, 1, 'SCyT');
INSERT INTO nodo VALUES (20, 'SECRETARIA DE BIENESTAR UNIVERSITARIO', 1, 1, 1, 'SEBU');
INSERT INTO nodo VALUES (19, 'SECRETARIA DE EXTENSION', 1, 1, 1, 'SEXT');
INSERT INTO nodo VALUES (18, 'SECRETARIA DE HACIENDA', 1, 1, 1, 'SEHA');
INSERT INTO nodo VALUES (23, 'PROGRAMACION Y ADMINISTRACION DE PROYECTOS', 22, NULL, 0, NULL);
INSERT INTO nodo VALUES (24, 'PROGRAMACION Y COORDINACION INTERINSTITUCIONAL', 22, NULL, 0, NULL);
INSERT INTO nodo VALUES (25, 'APOYO ADMINISTRATIVO', 22, NULL, 0, NULL);
INSERT INTO nodo VALUES (27, 'xx', 23, NULL, 0, NULL);
INSERT INTO nodo VALUES (1, 'ADMINISTRACION CENTRAL', NULL, 3, 0, 'ADMC');
INSERT INTO nodo VALUES (30, 'UNIDAD DE AUDITORIA INTERNA', NULL, 2, 1, 'UAI ');
INSERT INTO nodo VALUES (31, 'SECRETARIA GENERAL', NULL, 1, 1, 'SEGE');


--
-- TOC entry 2071 (class 0 OID 0)
-- Dependencies: 181
-- Name: nodo_id_nodo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('nodo_id_nodo_seq', 31, true);


--
-- TOC entry 2049 (class 0 OID 318777)
-- Dependencies: 203
-- Data for Name: novedad; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO novedad VALUES (1, 7, 'LSGH', '2016-07-07', '2018-07-07', 'xxx1      ');
INSERT INTO novedad VALUES (2, NULL, NULL, '2017-03-01', '2018-03-01', NULL);


--
-- TOC entry 2072 (class 0 OID 0)
-- Dependencies: 202
-- Name: novedad_id_novedad_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('novedad_id_novedad_seq', 2, true);


--
-- TOC entry 2051 (class 0 OID 319932)
-- Dependencies: 205
-- Data for Name: pase; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO pase VALUES (1, 9, 'T', 30, 22, '2017-03-01', '2018-03-01', '0419/2015 ', NULL);


--
-- TOC entry 2073 (class 0 OID 0)
-- Dependencies: 204
-- Name: pase_id_pase_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pase_id_pase_seq', 1, false);


--
-- TOC entry 2032 (class 0 OID 317822)
-- Dependencies: 186
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO persona VALUES (1, 20054, 'ABAL                          ', 'MARTA                         ', 28399996, 'F', '1999-01-01', 27, 28399996, 9, 'A', '1999-01-01', 1, 1);
INSERT INTO persona VALUES (2, 20728, 'ACCATINO                      ', 'ROSANNA                       ', 28399996, 'F', '1999-01-01', 27, 28399996, 9, 'A', '1999-01-01', 1, 1);
INSERT INTO persona VALUES (3, 20063, 'DIAZ                          ', 'MARIA ELENA                   ', 10951125, 'F', '1952-12-25', 27, 10951125, 6, 'A', '1972-08-01', 1, 1);
INSERT INTO persona VALUES (4, 22525, 'FORLINI                       ', 'MARIA LOURDES                 ', 31166284, 'F', '1984-09-26', 27, 31166284, 3, 'A', '2005-12-01', 1, 1);
INSERT INTO persona VALUES (5, 22477, 'MOLTISANTI                    ', 'LORENA VALERIA                ', 25609013, 'F', '1976-11-09', 27, 25609013, 4, 'A', '2005-06-01', 1, 1);
INSERT INTO persona VALUES (6, 22720, 'VALDEZ IRILLI                 ', 'AYELEN ALEJANDRA              ', 32119962, 'F', '1986-03-18', 27, 32119962, 9, 'A', '2011-07-01', 1, 1);
INSERT INTO persona VALUES (8, 22722, 'DI PASCUALE                   ', 'ROMINA                        ', 31125327, 'F', '1984-09-20', 27, 31125327, 7, 'A', '2011-07-01', 1, 1);
INSERT INTO persona VALUES (9, 22689, 'URIARTE                       ', 'MARIANA                       ', 23069817, 'F', '1972-11-29', 27, 23069817, 7, 'A', NULL, 1, 1);
INSERT INTO persona VALUES (10, 22756, 'BUISE                         ', 'ANALIA GRACIELA               ', 18562674, 'F', '1967-12-08', 27, 18562674, 7, 'A', NULL, NULL, NULL);
INSERT INTO persona VALUES (7, 20126, 'MUTCHINICK                    ', 'EDUARDO SERGIO                ', 8213101, 'M', '1948-05-06', 23, 8213101, 9, 'A', '1972-07-01', 1, 1);
INSERT INTO persona VALUES (11, 22647, 'TORRES                        ', 'SILVINA                       ', 29547765, 'F', '1982-11-07', 27, 29547765, 8, 'A', NULL, NULL, NULL);


--
-- TOC entry 2074 (class 0 OID 0)
-- Dependencies: 185
-- Name: persona_id_persona_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('persona_id_persona_seq', 9, true);


--
-- TOC entry 2041 (class 0 OID 318366)
-- Dependencies: 195
-- Data for Name: puesto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO puesto VALUES (1, '05  ', 1, 22);
INSERT INTO puesto VALUES (2, '05  ', 1, 22);
INSERT INTO puesto VALUES (3, '01  ', 1, 22);
INSERT INTO puesto VALUES (4, '07  ', 1, 22);
INSERT INTO puesto VALUES (5, '07  ', 1, 22);
INSERT INTO puesto VALUES (6, '01  ', 1, 22);
INSERT INTO puesto VALUES (7, '02  ', 1, 22);
INSERT INTO puesto VALUES (8, '02  ', 1, 22);
INSERT INTO puesto VALUES (9, '05  ', 1, 22);
INSERT INTO puesto VALUES (10, '07  ', 1, 31);


--
-- TOC entry 2075 (class 0 OID 0)
-- Dependencies: 194
-- Name: puesto_id_puesto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('puesto_id_puesto_seq', 8, true);


--
-- TOC entry 2046 (class 0 OID 318488)
-- Dependencies: 200
-- Data for Name: subroga; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO subroga VALUES (4, '04  ', '2016-02-01', NULL, NULL, NULL, NULL);
INSERT INTO subroga VALUES (5, '04  ', '2016-08-29', NULL, 'ATF ', '123       ', NULL);


--
-- TOC entry 2037 (class 0 OID 318307)
-- Dependencies: 191
-- Data for Name: tipo_categoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_categoria VALUES ('MAPU', 'MAPUCHE');
INSERT INTO tipo_categoria VALUES ('SERV', 'LOCACION DE SERVICIO');
INSERT INTO tipo_categoria VALUES ('OBRA', 'LOCACION DE OBRA');


--
-- TOC entry 2036 (class 0 OID 318291)
-- Dependencies: 190
-- Data for Name: tipo_doc; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_doc VALUES (1, 'CEFE', 'Cédula Federal                ');
INSERT INTO tipo_doc VALUES (2, 'CI  ', 'Cédula de Identidad           ');
INSERT INTO tipo_doc VALUES (3, 'DNI ', 'Docum. Nacional de Identidad  ');
INSERT INTO tipo_doc VALUES (4, 'LC  ', 'Libreta Cívica                ');


--
-- TOC entry 2076 (class 0 OID 0)
-- Dependencies: 189
-- Name: tipo_doc_id_tipo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_doc_id_tipo_seq', 4, true);


--
-- TOC entry 2030 (class 0 OID 317793)
-- Dependencies: 184
-- Data for Name: tipo_ingreso; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_ingreso VALUES (1, 'Concurso Abierto                                            ');
INSERT INTO tipo_ingreso VALUES (2, 'Concurso cerrado                                            ');
INSERT INTO tipo_ingreso VALUES (3, 'Designación Planta Política (AUTORIDADES)                   ');
INSERT INTO tipo_ingreso VALUES (4, 'Contratación por Locación de Obra                           ');
INSERT INTO tipo_ingreso VALUES (5, 'Contratación por Locación de Servicio                       ');
INSERT INTO tipo_ingreso VALUES (6, 'Concurso docente interino                                   ');
INSERT INTO tipo_ingreso VALUES (7, 'Concurso docente regular                                    ');
INSERT INTO tipo_ingreso VALUES (8, 'Pasantia                                                    ');
INSERT INTO tipo_ingreso VALUES (9, 'Pase interuniversitario                                     ');
INSERT INTO tipo_ingreso VALUES (10, 'Otro                                                        ');


--
-- TOC entry 2077 (class 0 OID 0)
-- Dependencies: 183
-- Name: tipo_ingreso_id_tipo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_ingreso_id_tipo_seq', 10, true);


--
-- TOC entry 2034 (class 0 OID 317840)
-- Dependencies: 188
-- Data for Name: tipo_modificacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_modificacion VALUES (1, 'Concurso                                ');
INSERT INTO tipo_modificacion VALUES (2, 'Paritarias por corrimiento de categoría ');


--
-- TOC entry 2078 (class 0 OID 0)
-- Dependencies: 187
-- Name: tipo_modificacion_id_tipo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_modificacion_id_tipo_seq', 2, true);


--
-- TOC entry 2026 (class 0 OID 317431)
-- Dependencies: 180
-- Data for Name: tipo_nodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_nodo VALUES (1, 'SECRETARIA');
INSERT INTO tipo_nodo VALUES (2, 'DIRECCION');
INSERT INTO tipo_nodo VALUES (3, 'DEPARTAMENTO');
INSERT INTO tipo_nodo VALUES (4, 'DIVISION');
INSERT INTO tipo_nodo VALUES (5, 'SECCION');
INSERT INTO tipo_nodo VALUES (6, 'UNIDAD ACADEMICA');
INSERT INTO tipo_nodo VALUES (7, 'SUBSECRETARIA');


--
-- TOC entry 2079 (class 0 OID 0)
-- Dependencies: 179
-- Name: tipo_nodo_id_tipo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_nodo_id_tipo_seq', 6, true);


--
-- TOC entry 2047 (class 0 OID 318770)
-- Dependencies: 201
-- Data for Name: tipo_novedad; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_novedad VALUES ('LSGH', 'Licencia sin goce de haberes  ');
INSERT INTO tipo_novedad VALUES ('BAJA', 'Baja                          ');
INSERT INTO tipo_novedad VALUES ('RENU', 'Renuncia                      ');


--
-- TOC entry 2045 (class 0 OID 318483)
-- Dependencies: 199
-- Data for Name: tipo_subrogancia; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_subrogancia VALUES ('SMR ', 'SUPLEMENTO POR MAYOR RESPONSABILIDAD    ');
INSERT INTO tipo_subrogancia VALUES ('ATF ', 'ASIGNACION DE TAREAS TRANSITORIAS       ');


--
-- TOC entry 1976 (class 2606 OID 317845)
-- Name: modificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_modificacion
    ADD CONSTRAINT modificacion_pkey PRIMARY KEY (id_tipo);


--
-- TOC entry 1974 (class 2606 OID 317827)
-- Name: persona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_pkey PRIMARY KEY (id_persona);


--
-- TOC entry 1988 (class 2606 OID 318419)
-- Name: pk_cargo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT pk_cargo PRIMARY KEY (id_cargo);


--
-- TOC entry 1982 (class 2606 OID 318340)
-- Name: pk_categoria; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categoria
    ADD CONSTRAINT pk_categoria PRIMARY KEY (codigo_categ);


--
-- TOC entry 1984 (class 2606 OID 318348)
-- Name: pk_costo_categoria; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY costo_categoria
    ADD CONSTRAINT pk_costo_categoria PRIMARY KEY (codigo_categ, desde);


--
-- TOC entry 1990 (class 2606 OID 318452)
-- Name: pk_desempenio; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY desempenio
    ADD CONSTRAINT pk_desempenio PRIMARY KEY (id_cargo, id_nodo);


--
-- TOC entry 1970 (class 2606 OID 317450)
-- Name: pk_nodo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nodo
    ADD CONSTRAINT pk_nodo PRIMARY KEY (id_nodo);


--
-- TOC entry 1998 (class 2606 OID 318782)
-- Name: pk_novedad; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY novedad
    ADD CONSTRAINT pk_novedad PRIMARY KEY (id_novedad);


--
-- TOC entry 2000 (class 2606 OID 319937)
-- Name: pk_pase; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pase
    ADD CONSTRAINT pk_pase PRIMARY KEY (id_pase);


--
-- TOC entry 1986 (class 2606 OID 318371)
-- Name: pk_puesto; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY puesto
    ADD CONSTRAINT pk_puesto PRIMARY KEY (id_puesto);


--
-- TOC entry 1994 (class 2606 OID 318492)
-- Name: pk_subroga; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subroga
    ADD CONSTRAINT pk_subroga PRIMARY KEY (id_cargo, desde);


--
-- TOC entry 1980 (class 2606 OID 318314)
-- Name: pk_tipo_categoria; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_categoria
    ADD CONSTRAINT pk_tipo_categoria PRIMARY KEY (sigla);


--
-- TOC entry 1978 (class 2606 OID 318296)
-- Name: pk_tipo_doc; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_doc
    ADD CONSTRAINT pk_tipo_doc PRIMARY KEY (id_tipo);


--
-- TOC entry 1972 (class 2606 OID 318255)
-- Name: pk_tipo_ingreso; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_ingreso
    ADD CONSTRAINT pk_tipo_ingreso PRIMARY KEY (id_tipo);


--
-- TOC entry 1968 (class 2606 OID 317439)
-- Name: pk_tipo_nodo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_nodo
    ADD CONSTRAINT pk_tipo_nodo PRIMARY KEY (id_tipo);


--
-- TOC entry 1996 (class 2606 OID 318774)
-- Name: pk_tipo_novedad; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_novedad
    ADD CONSTRAINT pk_tipo_novedad PRIMARY KEY (id_tipo);


--
-- TOC entry 1992 (class 2606 OID 318487)
-- Name: pk_tipo_subrogancia; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_subrogancia
    ADD CONSTRAINT pk_tipo_subrogancia PRIMARY KEY (sigla);


--
-- TOC entry 2013 (class 2606 OID 318440)
-- Name: fk_cargo_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT fk_cargo_categoria FOREIGN KEY (codc_categ) REFERENCES categoria(codigo_categ);


--
-- TOC entry 2009 (class 2606 OID 318420)
-- Name: fk_cargo_nodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT fk_cargo_nodo FOREIGN KEY (pertenece_a) REFERENCES nodo(id_nodo);


--
-- TOC entry 2010 (class 2606 OID 318425)
-- Name: fk_cargo_persona; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT fk_cargo_persona FOREIGN KEY (id_persona) REFERENCES persona(id_persona);


--
-- TOC entry 2012 (class 2606 OID 318435)
-- Name: fk_cargo_puesto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT fk_cargo_puesto FOREIGN KEY (id_puesto) REFERENCES puesto(id_puesto);


--
-- TOC entry 2011 (class 2606 OID 318430)
-- Name: fk_cargo_tipo_modif; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT fk_cargo_tipo_modif FOREIGN KEY (forma_modif) REFERENCES tipo_modificacion(id_tipo);


--
-- TOC entry 2005 (class 2606 OID 320325)
-- Name: fk_categoria_tipo_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY categoria
    ADD CONSTRAINT fk_categoria_tipo_categoria FOREIGN KEY (tipo_cat) REFERENCES tipo_categoria(sigla);


--
-- TOC entry 2006 (class 2606 OID 320335)
-- Name: fk_costo_categoria_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY costo_categoria
    ADD CONSTRAINT fk_costo_categoria_categoria FOREIGN KEY (codigo_categ) REFERENCES categoria(codigo_categ);


--
-- TOC entry 2014 (class 2606 OID 318453)
-- Name: fk_desempenio_cargo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY desempenio
    ADD CONSTRAINT fk_desempenio_cargo FOREIGN KEY (id_cargo) REFERENCES cargo(id_cargo);


--
-- TOC entry 2015 (class 2606 OID 318458)
-- Name: fk_desempenio_nodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY desempenio
    ADD CONSTRAINT fk_desempenio_nodo FOREIGN KEY (id_nodo) REFERENCES nodo(id_nodo);


--
-- TOC entry 2001 (class 2606 OID 318020)
-- Name: fk_nodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nodo
    ADD CONSTRAINT fk_nodo FOREIGN KEY (depende_de) REFERENCES nodo(id_nodo);


--
-- TOC entry 2020 (class 2606 OID 318783)
-- Name: fk_novedad_cargo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY novedad
    ADD CONSTRAINT fk_novedad_cargo FOREIGN KEY (id_cargo) REFERENCES cargo(id_cargo);


--
-- TOC entry 2021 (class 2606 OID 318788)
-- Name: fk_novedad_tipo_novedad; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY novedad
    ADD CONSTRAINT fk_novedad_tipo_novedad FOREIGN KEY (tipo_nov) REFERENCES tipo_novedad(id_tipo);


--
-- TOC entry 2022 (class 2606 OID 319938)
-- Name: fk_pase_cargo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pase
    ADD CONSTRAINT fk_pase_cargo FOREIGN KEY (id_cargo) REFERENCES cargo(id_cargo);


--
-- TOC entry 2023 (class 2606 OID 319943)
-- Name: fk_pase_nodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pase
    ADD CONSTRAINT fk_pase_nodo FOREIGN KEY (origen) REFERENCES nodo(id_nodo);


--
-- TOC entry 2024 (class 2606 OID 319948)
-- Name: fk_pase_nodo2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pase
    ADD CONSTRAINT fk_pase_nodo2 FOREIGN KEY (destino) REFERENCES nodo(id_nodo);


--
-- TOC entry 2004 (class 2606 OID 318302)
-- Name: fk_persona_tipo_doc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT fk_persona_tipo_doc FOREIGN KEY (tipo_doc) REFERENCES tipo_doc(id_tipo);


--
-- TOC entry 2003 (class 2606 OID 318297)
-- Name: fk_persona_tipo_ingreso; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT fk_persona_tipo_ingreso FOREIGN KEY (tipo_ing) REFERENCES tipo_ingreso(id_tipo);


--
-- TOC entry 2007 (class 2606 OID 318372)
-- Name: fk_puesto_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY puesto
    ADD CONSTRAINT fk_puesto_categoria FOREIGN KEY (categ) REFERENCES categoria(codigo_categ);


--
-- TOC entry 2008 (class 2606 OID 318377)
-- Name: fk_puesto_nodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY puesto
    ADD CONSTRAINT fk_puesto_nodo FOREIGN KEY (pertenece_a) REFERENCES nodo(id_nodo);


--
-- TOC entry 2016 (class 2606 OID 318514)
-- Name: fk_subroga_cargo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subroga
    ADD CONSTRAINT fk_subroga_cargo FOREIGN KEY (id_cargo) REFERENCES cargo(id_cargo);


--
-- TOC entry 2017 (class 2606 OID 318519)
-- Name: fk_subroga_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subroga
    ADD CONSTRAINT fk_subroga_categoria FOREIGN KEY (categ) REFERENCES categoria(codigo_categ);


--
-- TOC entry 2018 (class 2606 OID 318524)
-- Name: fk_subroga_puesto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subroga
    ADD CONSTRAINT fk_subroga_puesto FOREIGN KEY (surge_de) REFERENCES puesto(id_puesto);


--
-- TOC entry 2019 (class 2606 OID 318529)
-- Name: fk_subroga_tipo_subrogancia; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subroga
    ADD CONSTRAINT fk_subroga_tipo_subrogancia FOREIGN KEY (motivo) REFERENCES tipo_subrogancia(sigla);


--
-- TOC entry 2002 (class 2606 OID 318025)
-- Name: fk_tipo_nodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nodo
    ADD CONSTRAINT fk_tipo_nodo FOREIGN KEY (tipo) REFERENCES tipo_nodo(id_tipo);


--
-- TOC entry 2058 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2017-04-03 11:38:42

--
-- PostgreSQL database dump complete
--

