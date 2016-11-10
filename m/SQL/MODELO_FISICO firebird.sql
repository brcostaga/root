DROP TABLE tb_movimentos;
DROP TABLE tb_ds_cp_mes;
DROP TABLE tb_competencias;
DROP TABLE tb_contas;
DROP TABLE tb_categorias;
DROP TABLE tb_grupos;
DROP TABLE tb_ds_tipo_contas;
DROP SEQUENCE sq_categorias;
DROP SEQUENCE sq_grupos;
DROP SEQUENCE sq_movimentos;
DROP SEQUENCE sq_contas;

CREATE TABLE tb_competencias(
	cd_competencia CHAR(6) PRIMARY KEY
	,cp_ano	SMALLINT
	,cp_mes SMALLINT
);

CREATE TABLE tb_ds_cp_mes(
	cp_mes SMALLINT PRIMARY KEY
	,ds_cp_mes VARCHAR(30)
);

CREATE TABLE tb_categorias (
	cd_categoria                   SMALLINT PRIMARY KEY
	,nm_categorias                 VARCHAR(30)
	,cd_categoria_pai              SMALLINT
);

CREATE TABLE tb_grupos (
	cd_grupo                       SMALLINT PRIMARY KEY
	,nm_grupo                      VARCHAR(30)
);

CREATE TABLE tb_movimentos (
	cd_movimento                   INTEGER PRIMARY KEY
	,cd_grupo                      SMALLINT
	,cd_conta                      SMALLINT
	,vl_movimento                  DOUBLE PRECISION
	,dt_movimento                  DATE
	,dt_vencimento				   DATE
	,cd_competencia				   CHAR(6)	
	,ds_historico                  VARCHAR(50)
);

CREATE TABLE tb_contas (
	cd_conta                       SMALLINT PRIMARY KEY
	,cd_categoria                  SMALLINT
	,nm_conta                      VARCHAR(30)
	,cd_tipo       				   SMALLINT
);

CREATE TABLE tb_ds_tipo_contas(
	cd_tipo						   SMALLINT PRIMARY KEY
	,nm_tipo					   VARCHAR(30)
);
-- RESTRICOES
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_conta)     	REFERENCES tb_contas (cd_conta);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_grupo)     	REFERENCES tb_grupos (cd_grupo);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_competencia) 	REFERENCES tb_competencias (cd_competencia);
ALTER TABLE tb_contas     ADD FOREIGN KEY(cd_categoria) 	REFERENCES tb_categorias (cd_categoria);
ALTER TABLE tb_contas     ADD FOREIGN KEY(cd_tipo)			REFERENCES tb_ds_tipo_contas(cd_tipo);

-- SEQUENCES
CREATE SEQUENCE sq_categorias;
CREATE SEQUENCE sq_grupos;
CREATE SEQUENCE sq_movimentos;
CREATE SEQUENCE sq_contas;

-- INSERTS
INSERT INTO tb_competencias VALUES('201610',2016,10);
INSERT INTO tb_competencias VALUES('201611',2016,11);

INSERT INTO tb_ds_cp_mes VALUES(1,'Janeiro');
INSERT INTO tb_ds_cp_mes VALUES(2,'Fevereiro');
INSERT INTO tb_ds_cp_mes VALUES(3,'Marco');
INSERT INTO tb_ds_cp_mes VALUES(4,'Abril');
INSERT INTO tb_ds_cp_mes VALUES(5,'Maio');
INSERT INTO tb_ds_cp_mes VALUES(6,'Junho');
INSERT INTO tb_ds_cp_mes VALUES(7,'Julho');
INSERT INTO tb_ds_cp_mes VALUES(8,'Agosto');
INSERT INTO tb_ds_cp_mes VALUES(9,'Setembro');
INSERT INTO tb_ds_cp_mes VALUES(10,'Outubro');
INSERT INTO tb_ds_cp_mes VALUES(11,'Novembro');
INSERT INTO tb_ds_cp_mes VALUES(12,'Dezembro');


INSERT INTO tb_ds_tipo_contas VALUES(1,'Receita');
INSERT INTO tb_ds_tipo_contas VALUES(2,'Despesa');
INSERT INTO tb_ds_tipo_contas VALUES(3,'Calculo');

INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Receitas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NEXT VALUE FOR sq_categorias,'Despesas Fixas',NULL);

INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,1 ,'Salario',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,1,'Vale',1);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,2,'Luz',2);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,2,'Net',2);
INSERT INTO tb_contas VALUES(NEXT VALUE FOR sq_contas,2,'IPTU',2);

INSERT INTO tb_grupos VALUES(NEXT VALUE FOR sq_grupos,'ITAU CC');
INSERT INTO tb_grupos VALUES(NEXT VALUE FOR sq_grupos,'ITAU 7362');

INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,1,1,1000,'26.10.2016','05.10.2016','201610',NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,1,2,2000,'26.10.2016','24.10.2016','201610',NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,1,3,80,'26.10.2016','28.10.2016','201610',NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,1,4,180,'26.10.2016','25.10.2016','201610',NULL);
INSERT INTO tb_movimentos VALUES(NEXT VALUE FOR sq_movimentos,1,5,144,'26.10.2016','11.10.2016','201610',NULL);

COMMIT WORK;