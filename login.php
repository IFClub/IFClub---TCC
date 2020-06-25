<!DOCTYPE html>
<html>
<head>
  <title>IFClub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Ultra' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://kit.fontawesome.com/b19763012c.js" crossorigin="anonymous"></script>
</head>
<style>

  body{
    font-family: Arial, Helvetica, sans-serif;
    color: #212529;
    background-color: #fff;
  }

  *{
    box-sizing: border-box;
  }

  h1{
    font-family: 'Ultra';
    font-size: 48px;
    text-align: center;
    padding-bottom: 10%;
  }

  .usuarioSenha{
    font-size: 20px;
    text-align: center;
    color: #b94646;
    text-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    margin-top: -25%;
  }

  .conteudo {
    font-weight: bold;
    padding: 20px;
    width: 40%;
    margin: auto;
    justify-content: center;
  }

  .inputContainer{
    display: -ms-flexbox;
    display: flex;
    width: 100%;
    margin-bottom: 15px;
    padding: 12px;
  }

  .icon {
    padding: 10px;
    color: #212529;
    min-width: 50px;
    text-align: center;
    font-size: 24px;
  }

  .caixaInput{
    width: 100%;
    padding: 10px;
    outline: none;
    border-radius: 50px;
    border: 2px solid #212529;
  }

  .enviar {
    background-color: #57b846;
    color: #fff;
    outline: none;
    border-radius: 50px;
    border: 2px solid #57b846;
    cursor: pointer;
    width: 100%;
    box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.3);
  }

  .enviar:hover {
    opacity: 0.9;
  }

  .ul{
    padding-top: 10%;
  }

  ul, li{
    list-style-type: none;
    text-align: center;
  }

  .li{
    margin-bottom: 8px;
  }
  .txt {
    color: #212529;
    line-height: 1.5;
  }

  .link {
    color: #57b846;
    line-height: 1.5;
  }
</style>
</head>
<body>

  <form class="conteudo" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
    <h1>IFCLUB</h1>

      <!--<div class="usuarioSenha">
      <span>Usuário e/ou senha incorretos! Tentar novamente</span>
      </div>-->

      <div class="inputContainer">
        <i class="fa fa-envelope icon"></i>
        <input class="caixaInput" type="email" placeholder="E-mail" name="email" required>
      </div>
      <div class="inputContainer">
        <i class="fa fa-key icon"></i>
        <input class="caixaInput" type="password" placeholder="Senha" name="senha" required>
      </div>
      <div class="inputContainer">
      <i class="fas fa-sign-in-alt icon"></i>
      <button type="submit" class="enviar">Logar</button>
      </div>


      <ul class="ul">
      <li class="li">
      <span class="txt">Esqueceu a </span><a href="#" class="link"> senha?</a>
      </li>
      <li>
      <span class="txt">Não tem uma conta? </span><a href="#" class="link"> Cadastre-se</a>
      </li>
      </ul>
  </form>
</body>
</html>

<?php 
   if($_POST){

    require 'conexao.php';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

   
    try{
      
        $query = "SELECT email, senha_acesso, tipo_usuario_cod_tipo  FROM cad_usuario WHERE email= :email and senha_acesso= :senha";
        $stmt = $con->prepare($query);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        
        if($stmt->execute()){
            $num = $stmt->rowCount();
            

            if($num == 0){
              echo '<div class="usuarioSenha">';
                echo '<span>Usuário e/ou senha incorretos! Tente novamente</span>';
                echo '</div>';
            }

            if($num = 1){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if($row['tipo_usuario_cod_tipo'] == 1){
                    header("Location: homeAdm.php"); //vai para a página de ADM.//
                    echo 'oioi';
                }elseif($row['tipo_usuario_cod_tipo'] == 2){
                    header("Location: homeProf.php"); //vai para a página de Professor.//
                }elseif($row['tipo_usuario_cod_tipo'] == 3){
                    header("Location: homeAluno.php"); //vai para a página de Alunno.//
                }else{} 
            }    
        }else{
          echo 'não executou';
        }
    }catch(PDOException $e){
        die('ERROR: ' . $e->getMessage());
    }
}
?>
