<?php

class ModalidadeDao {

    public function __construct() {}

    public function getAllAtivo() 
    {
        $sql = "SELECT `id_modalidade_mod`, `txt_modalidade_mod`, `dat_fim_mod` FROM `tb_modalidade_mod` WHERE `dat_fim_mod` IS NULL";
        $conn = new conexao;
        $data = $conn->db()->query($sql);
        return $data;
    }

} 