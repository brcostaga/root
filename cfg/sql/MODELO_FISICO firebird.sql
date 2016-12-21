DROP PROCEDURE resumoMensal;
DROP TRIGGER tb_movimentos_ai;
DROP TRIGGER tb_categorias_ai;
DROP TRIGGER tb_recursos_ai;
DROP TRIGGER tb_contas_ai;
DROP TABLE tb_movimentos;
DROP TABLE tb_competencias;
DROP TABLE tb_contas;
DROP TABLE tb_categorias;
DROP TABLE tb_recursos;
DROP TABLE tb_descritiva;
DROP SEQUENCE sq_categorias;
DROP SEQUENCE sq_recursos;
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
	,saldo_inicial					DOUBLE PRECISION
	,saldo_final					DOUBLE PRECISION
);

CREATE TABLE tb_categorias (
	cd_categoria                   SMALLINT PRIMARY KEY
	,nm_categorias                 VARCHAR(30) CHARACTER SET WIN1252
	,cd_categoria_pai              SMALLINT
);

CREATE TABLE tb_recursos (
	cd_recurso                     SMALLINT PRIMARY KEY
	,nm_recurso                    VARCHAR(30) CHARACTER SET WIN1252
);

CREATE TABLE tb_movimentos (
	cd_movimento                   INTEGER PRIMARY KEY
	,cd_recurso                    SMALLINT	
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
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_recurso)     	REFERENCES tb_recursos (cd_recurso);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_competencia) 	REFERENCES tb_competencias (cd_competencia);
ALTER TABLE tb_movimentos ADD FOREIGN KEY(cd_categoria) 	REFERENCES tb_categorias (cd_categoria);
ALTER TABLE tb_descritiva ADD CONSTRAINT pk_tb_descritiva PRIMARY KEY (nm_tabela, nm_campo, cd);

-- INDICES
CREATE INDEX TB_MOVIMENTOS_IDX1 ON tb_movimentos COMPUTED BY (EXTRACT(DAY FROM dt_vencimento));

-- SEQUENCES
CREATE SEQUENCE sq_categorias;
CREATE SEQUENCE sq_recursos;
CREATE SEQUENCE sq_movimentos;
CREATE SEQUENCE sq_contas;

SET TERM ^ ;
-- VIEWS
	

-- PROCEDURES
CREATE OR ALTER PROCEDURE resumomensal (
      cd_competencia CHAR(6))
RETURNS (
      cd_movimento  INTEGER,
      vencimento    SMALLINT,
      dt_vencimento DATE,
      cd_conta      SMALLINT,
      conta         VARCHAR(30) CHARACTER SET win1252,
      tipo_conta    SMALLINT,
      valor         DOUBLE PRECISION,
      categoria     VARCHAR(30) CHARACTER SET win1252,
      saldo         DOUBLE PRECISION,
      cd_categoria  SMALLINT)
AS
DECLARE VARIABLE saldo_inicial DOUBLE PRECISION;
BEGIN
      SELECT saldo_inicial FROM tb_competencias a WHERE a.cd_competencia = :cd_competencia INTO :saldo_inicial;
      FOR
      SELECT
            CASE b.cd_tipo
                  WHEN 1 THEN cd_movimento
                  ELSE 0
            END                                      AS CD_MOVIMENTO
            ,EXTRACT(DAY FROM a.dt_vencimento)       AS VENCIMENTO
            ,A.dt_vencimento                         AS DT_VENCIMENTO
            ,b.cd_conta                              AS CD_CONTA
            ,b.nm_conta                              AS CONTA
            ,b.cd_tipo                               AS TIPO_CONTA
            ,SUM(a.vl_movimento)                     AS VALOR
            ,CASE b.cd_tipo
                  WHEN 2 THEN ''
                  WHEN 3 THEN NULL
                  WHEN 4 THEN NULL
                  ELSE e.nm_categorias
            END                                      AS CATEGORIA
            ,CASE b.cd_tipo
                  WHEN 2 THEN NULL
                  WHEN 3 THEN NULL
                  WHEN 4 THEN NULL
                  ELSE e.cd_categoria
            END                                      AS CD_CATEGORIA
      FROM tb_movimentos a
      INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
      INNER JOIN tb_categorias e ON e.cd_categoria = a.cd_categoria
      WHERE a.cd_competencia = :cd_competencia
      GROUP BY cd_movimento,vencimento, dt_vencimento,cd_conta,conta,tipo_conta,categoria,cd_categoria
      ORDER BY vencimento
            INTO :cd_movimento,:vencimento,:dt_vencimento, :cd_conta, :conta ,:tipo_conta, :valor, :categoria, :cd_categoria
      DO
      BEGIN
            saldo = COALESCE(saldo,:saldo_inicial) + valor;
            SUSPEND;
      END
END
^
-- TRIGGERS


	/*AUTO INCREMENT*/
CREATE OR ALTER TRIGGER tb_movimentos_ai FOR tb_movimentos
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.cd_movimento IS NULL) THEN NEW.cd_movimento = NEXT VALUE FOR sq_movimentos;
END
^

CREATE OR ALTER TRIGGER tb_categorias_ai FOR tb_categorias
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.cd_categoria IS NULL) THEN NEW.cd_categoria = NEXT VALUE FOR sq_categorias;
END
^

CREATE OR ALTER TRIGGER tb_recursos_ai FOR tb_recursos
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.cd_recurso IS NULL) THEN NEW.cd_recurso = NEXT VALUE FOR sq_recursos;
END
^

CREATE OR ALTER TRIGGER tb_contas_ai FOR tb_contas
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.cd_conta IS NULL) THEN NEW.cd_conta = NEXT VALUE FOR sq_contas;
END
^

SET TERM ; ^

-- INSERTS
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',1,'Fixa');
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',2,'Cartão de Crédito');
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',3,'Receitas Diversas');
INSERT INTO tb_descritiva VALUES('TB_CONTAS','CD_TIPO',4,'Despesas Diversas');
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
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','ST_COMPETENCIA',1,'Ativa');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','ST_COMPETENCIA',2,'Prevista');
INSERT INTO tb_descritiva VALUES('TB_COMPETENCIAS','ST_COMPETENCIA',3,'Encerrada');

INSERT INTO tb_competencias VALUES('201610',2016,10,1,NULL,NULL);
INSERT INTO tb_competencias VALUES('201611',2016,11,1,498.81,NULL);

INSERT INTO tb_categorias VALUES(NULL,'Receitas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Despesas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Diversos',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Mercado',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Farmácia',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Carro',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Encargos',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Receitas Diversas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Despesas Diversas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Habitação',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Carmem',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Tânia',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Carol',NULL);

INSERT INTO tb_contas VALUES(NULL,'Salário',1);
INSERT INTO tb_contas VALUES(NULL,'Vale',1);
INSERT INTO tb_contas VALUES(NULL,'Luz',1);
INSERT INTO tb_contas VALUES(NULL,'Net',1);
INSERT INTO tb_contas VALUES(NULL,'IPTU',1);
INSERT INTO tb_contas VALUES(NULL,'Itaú 6887',2);
INSERT INTO tb_contas VALUES(NULL,'Tarifas Itaú',1);
INSERT INTO tb_contas VALUES(NULL,'Receitas Diversas',3);
INSERT INTO tb_contas VALUES(NULL,'Despesas Diversas',4);
INSERT INTO tb_contas VALUES(NULL,'Tarifas Caixa',1);
INSERT INTO tb_contas VALUES(NULL,'Itaú 2752',2);
INSERT INTO tb_contas VALUES(NULL,'Prestação Caixa',1);
INSERT INTO tb_contas VALUES(NULL,'Noêmia',1);
INSERT INTO tb_contas VALUES(NULL,'Extra Itaú Card',2);
INSERT INTO tb_contas VALUES(NULL,'Besni',2);
INSERT INTO tb_contas VALUES(NULL,'Estacionamento',1);
INSERT INTO tb_contas VALUES(NULL,'Condomínio',1);
INSERT INTO tb_contas VALUES(NULL,'Tânia',1);
INSERT INTO tb_contas VALUES(NULL,'Carmem',1);

INSERT INTO tb_recursos VALUES(NULL,'ITAU CC');

INSERT INTO tb_movimentos VALUES(NULL,NULL,1,1,1281.89,'05.11.2016','05.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,1,2,1502.49,'26.11.2016','26.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,2,3,-92.71,'28.11.2016','28.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,2,4,-292.47,'25.11.2016','25.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,2,5,-157.75,'11.11.2016','11.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,6,-344.44,'07.06.2016','26.11.2016','201611','Sofá Mônica',6,9);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,6,-89.99,'17.07.2016','26.11.2016','201611','Zenfone Go',4,10);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,6,-83.66,'10.10.2016','26.11.2016','201611','Pagseguro varinha',2,2);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,6,-26.00,'11.10.2016','26.11.2016','201611','Xickos (Marcela)',2,5);
INSERT INTO tb_movimentos VALUES(NULL,NULL,6,6,-30.00,'14.10.2016','26.11.2016','201611','Extra Posto',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,6,-49.99,'17.10.2016','26.11.2016','201611','Pernambucanas',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,4,6,-22.01,'19.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,4,6,-21.79,'19.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,6,-31.50,'21.10.2016','26.11.2016','201611','Mahogany',1,2);
INSERT INTO tb_movimentos VALUES(NULL,NULL,4,6,-2.78,'24.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,4,6,-13.89,'24.10.2016','26.11.2016','201611','Fikbella',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,7,7,-56.60,'02.11.2016','02.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,8,50.00,'12.11.2016','01.11.2016','201611','Peg Pão',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,8,12.00,'14.11.2016','01.11.2016','201611','Toninho',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,8,52.00,'15.11.2016','01.11.2016','201611','Toninho',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,9,-2.00,'15.11.2016','01.11.2016','201611','Pregos',NULL,NULL);
INSERT INTO tb_movimentos 
(
	/*01*/cd_movimento                   
	/*02*/,cd_recurso  	                    
	/*03*/,cd_categoria                  
	/*04*/,cd_conta                      
	/*05*/,vl_movimento                  
	/*06*/,dt_movimento                  
	/*07*/,dt_vencimento				   
	/*08*/,cd_competencia				   
	/*09*/,ds_historico                  
	/*10*/,cd_parcela					   
	/*11*/,qt_parcelas				   
)
VALUES(NULL,NULL,7,10,-20.80,'10.11.2016','10.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,7,11,-12.50,'23.07.2016','10.11.2016','201611','Anuidade',4,8);
INSERT INTO tb_movimentos VALUES(NULL,NULL,4,11,-48.63,'10.10.2016','10.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,10,12,-934.11,'16.11.2016','16.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,9,-150.00,'19.11.2016','01.11.2016','201611','Gilberto',1,2);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,9,-250.00,'19.11.2016','01.11.2016','201611','Luiz Fabiano',1,2);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,13,344.44,'26.11.2016','26.11.2016','201611','Noêmia',6,9);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,14,-24.49,'09.03.2016','26.11.2016','201611','TV',9,10);
INSERT INTO tb_movimentos VALUES(NULL,NULL,7,14,-7.25,'26.11.2016','26.11.2016','201611','Anuidade',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,6,14,-148.28,'17.10.2016','26.11.2016','201611','Posto Extra',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,6,14,-100.00,'03.11.2016','26.11.2016','201611','Posto Extra',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,12,15,-54.98,'09.06.2016','26.11.2016','201611','Tânia',6,6);
INSERT INTO tb_movimentos VALUES(NULL,NULL,11,15,-67.49,'19.08.2016','26.11.2016','201611','Carmem',3,6);
INSERT INTO tb_movimentos VALUES(NULL,NULL,13,15,-11.66,'20.10.2016','26.11.2016','201611','Carol',1,6);
INSERT INTO tb_movimentos VALUES(NULL,NULL,7,15,-5.80,'26.11.2016','26.11.2016','201611','Anuidade',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,2,16,-180.00,'26.11.2016','26.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,2,17,-308.52,'30.11.2016','30.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,18,50.00,'10.11.2016','10.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,19,67.49,'10.11.2016','10.11.2016','201611',NULL,NULL,NULL);

COMMIT WORK;