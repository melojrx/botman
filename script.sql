CREATE database Fisiculturismo;

CREATE TABLE `tb_modalidade_mod` (`id_modalidade_mod` bigint(11) NOT NULL AUTO_INCREMENT,`txt_modalidade_mod` varchar(100) NOT NULL, 
`dat_fim_mod` timestamp NULL, CONSTRAINT modalidade_pk PRIMARY KEY (id_modalidade_mod));

CREATE TABLE `tb_cliente_cli` ( `id_cliente_cli` bigint(11) NOT NULL AUTO_INCREMENT, `txt_nome_cli` varchar(100) NOT NULL, 
`txt_email_cli` varchar(50) NOT NULL, `txt_endereco_cli` varchar(100) NOT NULL, `txt_fone_cli` varchar(15) NOT NULL, 
`id_modalidade_cli` int null, `txt_modalidade_cli` varchar(100) NULL, `flg_fisicuturista_cli` tinyint(1) DEFAULT NULL, `flg_marcial_cli` tinyint(1) DEFAULT NULL, 
`dat_inicio_cli` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), CONSTRAINT client_pk PRIMARY KEY (id_cliente_cli));


ALTER TABLE `tb_cliente_cli` ADD CONSTRAINT `modalidade_fk` FOREIGN KEY ( `id_cliente_cli` ) REFERENCES `tb_modalidade_mod` (`id_modalidade_mod`) ;

--INSERT INTO `tb_modalidade_mod`(`txt_modalidade_mod`, `dat_fim_mod`) VALUES ('Fisiculturismo',null);
INSERT INTO `tb_modalidade_mod`(`id_modalidade_mod`, `txt_modalidade_mod`, `dat_fim_mod`) VALUES (1,'MMA',null);
INSERT INTO `tb_modalidade_mod`(`id_modalidade_mod`,`txt_modalidade_mod`, `dat_fim_mod`) VALUES (2,'Jiu-jitsu',null);
INSERT INTO `tb_modalidade_mod`(`id_modalidade_mod`,`txt_modalidade_mod`, `dat_fim_mod`) VALUES (3,'Boxe',null);
INSERT INTO `tb_modalidade_mod`(`id_modalidade_mod`,`txt_modalidade_mod`, `dat_fim_mod`) VALUES (4,'Muay Thai',null);
INSERT INTO `tb_modalidade_mod`(`id_modalidade_mod`,`txt_modalidade_mod`, `dat_fim_mod`) VALUES (5,'Karatê',null);
INSERT INTO `tb_modalidade_mod`(`id_modalidade_mod`,`txt_modalidade_mod`, `dat_fim_mod`) VALUES (6,'Outros?',null);
