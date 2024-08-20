<?php
include ('../../config/conexao.php');

if (isset ($_GET['idDel'])){
    $id = $_GET ['idDel'];
    echo "<h1>". $id. "<h1>";
    //primeiro, recupere o nome da imagem do registro
    $select = "SELECT foto_contatos FROM tb_contatos WHERE id_contatos=id";
    try{
        $result = $conect -> prepare($select);
        $result -> bindValue (':id', $id, PDO::PARAM_INT);
        $result -> execute();
        $contar = $result -> rowCount();

        if($contar > 0){
            $show = $result -> fetch(PDO::FETCH_OBJ);
            $foto = $show -> foto_contatos;
        }

        if($foto != 'avatar-padrão.png'){
            //caminho da imagem no servidor
            $filePath = "../../img/cont/" . $foto;

            //verfica se o arquivo existe e deleta 
            if(file_exists($filePath)){
                unlink ($filePath);
            }
        }
        // agora, delete o registro do banco de dados 
        $delete = "DELECT FROM tb_contatos WHERE id_contatos = :id";
        try{
            $result = $conect -> prepare($delete);
            $result -> bindValue (':id', $id, PDO::PARAM_INT);
            $result -> execute();

            $contar = $result -> rowCount();
            if($contar > 0){
                header("Location: ../home.php");
            }else{
                header("Location: ../home.php");
            }
            
        }catch(PDOException $e){
            echo "<strong> ERRO DE DELETE: </strong>" . $e -> getMessage();

        }else{
        header("Location: ../home.php");
    }
    }catch (PDOException $e){
        echo "<strong> ERRO DE SELECT: </strong>" . $e -> getMessage();

    }





}
