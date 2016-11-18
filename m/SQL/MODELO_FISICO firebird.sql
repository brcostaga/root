DROP TABLE tb_movimentos;
DROP TABLE tb_competencias;
DROP TABLE tb_contas;
DROP TABLE tb_categorias;
DROP TABLE tb_grupos;
DROP TABLE tb_descritiva;
DROP SEQUENCE sq_categorias;
DROP SEQUENCE sq_grupos;
DROP SEQUENCE sq_movimentos;
DROP SEQUENCE sq_contas;

CREATE TABLE tb_descritiva(
	nm_tabela 						CHAR(31) NOT NULL
	,nm_campo 						CHAR(31) NOT NULL
	,cd 							SMALLINT NOT NULL
	,ds 							VARCHAR(100) CHARACTER SET WIN1252
);

CREATE TABLE tb_competencias(
	cd_competencia CHAR(6) 			PRIMARY KEY
	,cp_ano							SMALLINT
	,cp_mes 						SMALLINT
	,st_competencia 				SMALLINT
);

CREATE TABLE tb_categorias (
	cd_categoria                   SMALLINT PRIMARY KEY
	,nm_categorias                 VARCHAR(30) CHARACTER SET WIN1252
	,cd_categoria_pai              SMALLINT
);

CREATE TABLE tb_grupos (
	cd_grupo                       SMALLINT PRIMARY KEY
	,nm_grupo                      VARCHAR(30) CHARACTER SET WIN1252
);

CREATE TABLE tb_movimentos (
	cd_movimento                   INTEGER PRIMARY KEY
	,cd_grupo                      SMALLINT
	,cd_categoria                  SMALLINT
	,cd_conta                      SMALLINT
	,vl_movimento                  DOUBLE PRECISION
	,dt_movimento                  DATE
	,dt_vencimento				   DATE
	,cd_competencia				   CHAR(6)	
	,ds_historico                  VARCHAR(50) CHARACTER SET WIN1252
	,cd_parcela					   SMALLINT
	,qt_parcelas				   SMALLINT
);

CREATE TABLE tb_contas (
	cd_conta                       SMALLINT PRIMARY KEY	
	,nm_conta                      VARCHAR(30) CHARACTER SET WIN1252
	,cd_tipo       				   SMALLINT
);


-- RESTRICOES
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_conta)     	REFERENCES tb_contas (cd_conta);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_grupo)     	REFERENCES tb_grupos (cd_grupo);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_competencia) 	REFERENCES tb_competencias (cd_competencia);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_categoria) 	REFERENCES tb_categorias (cd_categoria);
ALTER TABLE tb_descritiva ADD CONSTRAINT pk_tb_descritiva PRIMARY KEY (nm_tabela, nm_campo, cd);

-- INDICES
CREATE INDEX TB_MOVIMENTOS_IDX1 ON tb_movimentos COMPUTED BY (EXTRACT(DAY FROM dt_vencimento));

-- SEQUENCES
CREATE SEQUENCE sq_categorias;
CREATE SEQUENCE sq_grupos;
CREATE SEQUENCE sq_movimentos;
CREATE SEQUENCE sq_contas;

-- INSERTS
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',1,'Fixa');
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',2,'Cartão de Crédito');
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',3,'Cálculo');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',1,'Janeiro');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',2,'Fevereiro');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',3,'Março');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',4,'Abril');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',5,'Maio');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',6,'Junho');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',7,'Julho');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',8,'Agosto');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',9,'Setembro');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',10,'Outubro');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',11,'Novembro');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','CP_MES',12,'Dezembro');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','ST_COMPETENCIA',1,'Aberta');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','ST_COMPETENCIA',2,'Encerrada');

INSERT INTO tb_competencias VALUES('201610',2016,10,1);
INSERT INTO tb_competencias VALUES('201611',2016,11,1);

INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Receitas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Despesas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Diversos',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Mercado',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Farmácia',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Carro',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Encargos',NULL);

INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,'Salário',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,'Vale',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,'Luz',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,'Net',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,'IPTU',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,'ITAU 6887',2);

INSERT INTO tb_grupos VALUES(NEXT VALUE FOR sq_grupos,'ITAU CC');
INSERT INTO tb_grupos VALUES(NEXT VALUE FOR sq_grupos,'ITAU 6887');

INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,NULL,1,1,1000.00,'05.11.2016','05.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,NULL,1,2,2000.00,'24.11.2016','24.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,NULL,2,3,-80.00,'28.11.2016','28.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,NULL,2,4,-180.00,'25.11.2016','25.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,NULL,2,5,-144.00,'11.11.2016','11.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,3,6,-344.44,'07.06.2016','26.11.2016','201611','Sofá Mônica',6,9);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,3,6,-89.99,'17.07.2016','26.11.2016','201611','Zenfone Go',4,10);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,3,6,-83.66,'10.10.2016','26.11.2016','201611','Pagseguro varinha',2,2);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,3,6,-26.00,'11.10.2016','26.11.2016','201611','Xickos (Marcela)',2,5);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,6,6,-30.00,'14.10.2016','26.11.2016','201611','Extra Posto',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,3,6,-49.99,'17.10.2016','26.11.2016','201611','Pernambucanas',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,4,6,-22.01,'19.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,4,6,-21.79,'19.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,3,6,-31.50,'21.10.2016','26.11.2016','201611','Mahogany',1,2);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,4,6,-2.78,'24.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,2,4,6,-13.89,'24.10.2016','26.11.2016','201611','Fikbella',NULL,NULL);

COMMIT WORK;