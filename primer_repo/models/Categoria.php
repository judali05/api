<?php
    class Categoria extends Conectar{

        public function get_categoria(){
            $conectar= parent::Conexion();
            parent::set_names();
                $sql="SELECT * FROM categorias WHERE est=1";
                $sql=$conectar->prepare($sql);
                $sql->execute();
        
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>