<?php 
   if($_POST){

    require_once 'conexao.php';
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    echo $email . ''. $senha;
    try{
        $query = "SELECT email, senha_acesso, tipo_usuario_cod_tipo  FROM cad_usuario WHERE email= ':email' and senha_acesso= ':senha'";
        $stmt = $con->prepare($query);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);

        if($stmt->execute()){
            $num = $stmt->fetchColumn();
            
            if($num = 1){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if($row['tipo_usuario_cod_tipo'] == 1){
                    header("Location: oi.php"); //vai para a página de ADM.//
                    echo 'oioi';
                }elseif($row['tipo_usuario_cod_tipo'] == 2){
                    header("Location: oi.php"); //vai para a página de Professor.//
                }elseif($row['tipo_usuario_cod_tipo'] == 3){
                    header("Location: oi.php"); //vai para a página de Alunno.//
                }
            }else{
                echo '<div class="mensagemerro">';
                echo    '<p>Matrícula ou senha incorretas</p>';
                echo '</div>';
            }
        }else{
          echo 'não executou';
        }
    }catch(PDOException $e){
        die('ERROR: ' . $e->getMessage());
    }
}
?>