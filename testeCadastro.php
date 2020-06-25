<?php 

    require 'conexao.php';
if($_POST){  
    $tipo = $_post["tipo"];//1 ou 2
    $matricula = $_post['matricula'];
    $nome = $_post['nome'];
    $email = $_post['email'];
    $senha = $_post['senha'];

    $query1 = "SELECT matricula from cad_usuario where matricula= :matricula;";
    $stmt = $con->prepare($query1);
    $stmt->bindValue(':matricula', $matricula, pDO::PARAM_STR);
     
        if($stmt->execute()){
            if($stmt->rowcount()==1){
            
                echo '<div class="alertajacadastrado">Matrícula/SIAPE já cadastrado!';
            }else{
                //cadastro definitivo do usuario
                try {
                    $query2 = "INSERT into cad_usuario SET matricula= :matricula, nome_completo= :nome, email= :email, senha_acesso= :senha, tipo_usuario_cod_tipo= :tipo";
                    $stmt= $con->prepare($query2);
                    $stmt->bindValue(':matricula',$matricula,PDO::PARAM_INT);
                    $stmt->bindValue(':nome',$nome,PDO::PARAM_STR);
                    $stmt->bindValue(':email',$email,PDO::PARAM_STR);
                    $stmt->bindValue(':senha',$senha,PDO::PARAM_STR);
                    $stmt->bindValue(':tipo',$tipo,PDO::PARAM_INT);

                        if($stmt->execute()){
                            echo "<div class='alertasucesso'>Usário cadastrado com sucesso! <a href=''> Clique aqui para fazer o login.</a></div>";
                            
                        }else{
                            echo "<div class='alertanao'>Ops, aconteceu algum erro!</div>";
                        
                        }
                } catch (PDOException $exception) {
                    die('ERROR: '. $exception_>getMessage());
                }
            }
        }
}
?>