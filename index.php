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

  .registroSucesso{
    font-size: 20px;
    text-align: center;
    color: #57b846;
    text-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    margin-top: -35%;
  }

  .registroNegado{
    font-size: 20px;
    text-align: center;
    color: #b94646;
    text-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    margin-top: -35%;
  }

  .registro{
    color: #212529;
  }

  .conteudo {
    font-weight: bold;
    padding: 20px;
    width: 40%;
    margin: auto;
    justify-content: center;
  }

  .caixaInput{
    width: 100%;
    padding: 10px;
    outline: none;
    border-radius: 50px;
    border: 2px solid #212529;
    margin: 8px 0;
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
    padding: 12px;
    margin: 24px 0;
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
    <form class="conteudo" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <h1>CADASTRO</h1>

      <!--<div class="registroSucesso">
      <span>Registrado com Sucesso! </span><a href="#" class="registro"> Acessar</a>
      </div>
      <div class="registroNegado">
      <span>Registro Negado!  </span><a href="#" class="registro"> Tentar novamente</a>
      </div>-->


      <label for="prof/aluno">VOCÊ É?</label><br>
      <input type="radio" style="margin-top: 8px;" name="tipo" value="2" required>
      <label for="male">Professor(a)</label><br>
      <input type="radio" style="margin-bottom: 24px;" name="tipo" value="3" required>
      <label for="female">Aluno(a)</label><br>

      <label for="numero">NÚMERO DE MATRÍCULA/SIAPE</label><br>
      <input class="caixaInput" type="text" placeholder="Digite aqui seu número de matrícula/SIAPE" name="matricula" required>

      <label for="nome">NOME COMPLETO</label><br>
      <input class="caixaInput" type="text" placeholder="Digite aqui seu nome completo" name="nome" required>

      <label for="email">E-MAIL</label>
      <input class="caixaInput" type="email" placeholder="Digite aqui seu e-mail" name="email" required>

      <label for="senha">SENHA</label>
      <input class="caixaInput" type="password" placeholder="Digite aqui sua senha" name="senha" required>

      <button type="submit" class="enviar">Cadastrar</button>


      <ul class="ul">
      <li class="li">
      <span class="txt">Já tem uma conta? </span><a href="login.php" class="link"> Entrar</a>
      </li>
      </ul>
    </form>
</body>
</html>

<?php 

    require 'conexao.php';
    if($_POST){  
      $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';//2 ou 3
      $matricula = isset($_POST['matricula']) ? $_POST['matricula'] : '' ;
      $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      $senha = isset($_POST['senha']) ? $_POST['senha']: '';
  
      $query1 = "SELECT matricula from cad_usuario where matricula= :matricula;";
      $stmt = $con->prepare($query1);
      $stmt->bindValue(':matricula', $matricula, PDO::PARAM_INT);
       
      if($stmt->execute()){
        $num = $stmt->rowCount();
        
        if($num >= 1){
          echo '<div class="registroNegado">';
          echo '<span>Matricula/SIAPE já registrada! </span>';
          echo '</div>';
          
        }else{  
        
          
      //cadastro definitivo do usuario
                  try {
                      $query2 = "INSERT into cad_usuario SET matricula= :matricula, nome_completo= :nome, email= :email, senha_acesso= :senha, tipo_usuario_cod_tipo= :tipo";
                      $stmt2= $con->prepare($query2);
                      $stmt2->bindValue(':matricula',$matricula,PDO::PARAM_INT);
                      $stmt2->bindValue(':nome',$nome,PDO::PARAM_STR);
                      $stmt2->bindValue(':email',$email,PDO::PARAM_STR);
                      $stmt2->bindValue(':senha',$senha,PDO::PARAM_STR);
                      $stmt2->bindValue(':tipo',$tipo,PDO::PARAM_INT);
  
                          if($stmt2->execute()){
                              echo '<div class="registroSucesso">';
                              echo '<span>Registrado com Sucesso! </span><a href="login.php" class="registro"> Acessar</a>';
                              echo '</div>';
                          }else{
                              echo '<div class="registroNegado">';
                              echo '<span>Houve algum problema no cadastro! Tente novamente mais tarde.</span>';
                              echo '</div>';
                          
                          }
                  } catch (PDOException $exception) {
                      die('ERROR: '. $exception_>getMessage());
                  }
          }
      }
          
  }
  ?>