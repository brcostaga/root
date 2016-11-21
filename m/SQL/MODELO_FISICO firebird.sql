DROP TRIGGER linha_mov;
DROP PROCEDURE sp_linha_mov;
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
	,cd_linha					   SMALLINT
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

-- VIEWS
	--CREATE VIEW vw_movimentos AS SELECT  cd_linha, cd_movimento, cd_competencia FROM tb_movimentos ORDER BY cd_linha;

-- PROCEDURES
SET TERM ^ ;

CREATE OR ALTER PROCEDURE sp_linha_mov
(
      new_cd_linha SMALLINT
      ,new_cd_competencia CHAR(6)
      ,new_cd_movimento INTEGER
      ,old_cd_linha SMALLINT
      ,old_cd_competencia CHAR(6)
      ,old_cd_movimento INTEGER
      ,dml CHAR(1)
)
AS
DECLARE v_cd_movimento INTEGER;
DECLARE v_cd_linha SMALLINT;
BEGIN
-- UPDATE
      IF(dml = 'U' AND new_cd_linha IS NOT NULL) THEN
      BEGIN
            FOR
                  SELECT cd_movimento, cd_linha
                  FROM tb_movimentos
                  WHERE
                        cd_linha >= :new_cd_linha
                        AND cd_competencia = :new_cd_competencia
                        AND cd_movimento <> :new_cd_movimento
                  ORDER BY cd_linha
                  INTO :v_cd_movimento, :v_cd_linha
            DO
            BEGIN
                  UPDATE tb_movimentos SET cd_linha = cd_linha +1 WHERE cd_movimento = :v_cd_movimento;
            END
      END
-- INSERT
      IF(dml = 'I'  AND new_cd_linha IS NOT NULL) THEN
      BEGIN
            FOR
                  SELECT cd_movimento, cd_linha
                  FROM tb_movimentos
                  WHERE
                        cd_linha >= :new_cd_linha
                        AND cd_competencia = :new_cd_competencia
                  ORDER BY cd_linha
                  INTO :v_cd_movimento, :v_cd_linha
            DO
            BEGIN
                  UPDATE tb_movimentos SET cd_linha = cd_linha +1 WHERE cd_movimento = :v_cd_movimento;
            END
      END
-- DELETE
      IF(dml = 'D'  AND old_cd_linha IS NOT NULL) THEN
      BEGIN
            FOR
                  SELECT cd_movimento, cd_linha
                  FROM tb_movimentos
                  WHERE
                        cd_linha >= :old_cd_linha
                        AND cd_competencia = :old_cd_competencia
                  ORDER BY cd_linha
                  INTO :v_cd_movimento, :v_cd_linha
            DO
            BEGIN
                  UPDATE tb_movimentos SET cd_linha = cd_linha -1 WHERE cd_movimento = :v_cd_movimento;
            END
      END
END
^
-- TRIGGERS

CREATE OR ALTER TRIGGER linha_mov FOR tb_movimentos
ACTIVE
AFTER UPDATE
AS
DECLARE v_cd_movimento INTEGER;
DECLARE v_cd_linha SMALLINT;
BEGIN
      IF (rdb$get_context('USER_TRANSACTION', 'MY_LOCK') IS NULL)  THEN
      BEGIN
            rdb$set_context('USER_TRANSACTION', 'MY_LOCK', 1);
            IF(UPDATING) THEN EXECUTE PROCEDURE sp_linha_mov(NEW.cd_linha,NEW.cd_competencia,NEW.cd_movimento,NULL,NULL,NULL,'U');
      END
--      IF(INSERTING) THEN EXECUTE PROCEDURE sp_linha_mov(NEW.cd_linha,NEW.cd_competencia,NEW.cd_movimento,NULL,NULL,NULL,'I');
--      IF(DELETING) THEN EXECUTE PROCEDURE sp_linha_mov(NULL,NULL,NULL,OLD.cd_linha,OLD.cd_competencia,OLD.cd_movimento,'D');
END
^

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

INSERT INTO tb_competencias VALUES('201610',2016,10,1);
INSERT INTO tb_competencias VALUES('201611',2016,11,1);

INSERT INTO tb_categorias VALUES(NULL,'Receitas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Despesas Fixas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Diversos',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Mercado',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Farmácia',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Carro',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Encargos',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Receitas Diversas',NULL);
INSERT INTO tb_categorias VALUES(NULL,'Despesas Diversas',NULL);

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

INSERT INTO tb_recursos VALUES(NULL,'ITAU CC');

INSERT INTO tb_movimentos VALUES(NULL,NULL,4,1,1,1281.89,'05.11.2016','05.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,8,1,2,1502.49,'26.11.2016','26.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,10,2,3,-80.00,'28.11.2016','28.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,7,2,4,-180.00,'25.11.2016','25.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,6,2,5,-144.00,'11.11.2016','11.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,3,6,-344.44,'07.06.2016','26.11.2016','201611','Sofá Mônica',6,9);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,3,6,-89.99,'17.07.2016','26.11.2016','201611','Zenfone Go',4,10);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,3,6,-83.66,'10.10.2016','26.11.2016','201611','Pagseguro varinha',2,2);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,3,6,-26.00,'11.10.2016','26.11.2016','201611','Xickos (Marcela)',2,5);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,6,6,-30.00,'14.10.2016','26.11.2016','201611','Extra Posto',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,3,6,-49.99,'17.10.2016','26.11.2016','201611','Pernambucanas',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,4,6,-22.01,'19.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,4,6,-21.79,'19.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,3,6,-31.50,'21.10.2016','26.11.2016','201611','Mahogany',1,2);
INSERT INTO tb_movimentos VALUES(NULL,NULL,9,4,6,-2.78,'24.10.2016','26.11.2016','201611','Sonda',NULL,NULL);
INSERT INTO tb_movimentos 
(
	/*01*/cd_movimento                   
	/*02*/,cd_recurso  
	/*03*/,cd_linha                    
	/*04*/,cd_categoria                  
	/*05*/,cd_conta                      
	/*06*/,vl_movimento                  
	/*07*/,dt_movimento                  
	/*08*/,dt_vencimento				   
	/*09*/,cd_competencia				   
	/*10*/,ds_historico                  
	/*11*/,cd_parcela					   
	/*12*/,qt_parcelas				   
)
VALUES(NULL,NULL,9,4,6,-13.89,'24.10.2016','26.11.2016','201611','Fikbella',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,3,7,7,-56.60,'02.11.2016','02.11.2016','201611',NULL,NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,1,8,8,50.00,'12.11.2016','01.11.2016','201611','Peg Pão',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,1,8,8,12.00,'14.11.2016','01.11.2016','201611','Toninho',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,1,8,8,52.00,'15.11.2016','01.11.2016','201611','Toninho',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,2,9,9,-2.00,'15.11.2016','01.11.2016','201611','Pregos',NULL,NULL);
INSERT INTO tb_movimentos VALUES(NULL,NULL,5,7,10,-20.80,'10.11.2016','10.11.2016','201611',NULL,NULL,NULL);

COMMIT WORK;