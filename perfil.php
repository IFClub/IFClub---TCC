<?php 

require_once 'conexao.php';

session_start();
if((!isset ($_SESSION['emailAluno']) == true) and (!isset ($_SESSION['senhaAluno']) == true)){
  unset($_SESSION['emailAluno']);
  unset($_SESSION['senhaAluno']);
  header('location:login.php');
  session_destroy();
  exit;
  }
try {
      $querySelect = "Select nome_completo, email, senha_acesso, matricula from cad_usuario where email= :email;";
      $stmt = $con->prepare($querySelect);
      $stmt->bindValue(':email', $_SESSION['emailAluno'], PDO::PARAM_STR);

      if($stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome = $row['nome_completo'];
        $email = $row['email'];
        $senha = $row['senha_acesso'];
        $matricula = $row['matricula'];
      }
}catch(PDOException $e){
  die("Error: " . $e->getMessage());
}
?>


<!DOCTYPE HTML>
<html>
<head>
    <title>IFCLUB</title> 
    <meta charset="utf_8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Passion+One:400' rel='stylesheet'>  
    <link href='https://fonts.googleapis.com/css?family=Ultra' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/b19763012c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
</head> 
<style>

  body {
    color: rgba(255, 255, 255, 0.85);
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 300;
    line-height: 1.65;
    background: #202024;
  }

  a {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    border-bottom: 1px dotted;
    outline: 0;
  }

  h1{
    color: #fff;
  }

  .content{
    margin-left: auto;
    margin-right: auto;
    margin-top: 16px;
  }

  .boxSombra{
      box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
  }

  .icon{
      margin-right: 16px;
      font-size: 24px;
  }

  .row:after{
      padding: 0;    
      content: "";
      display: table;
      clear: both;
  }

  .row>.direita{
      padding: 0 12px;
  }

  .container{
      padding: 0.16px 16px;
      background: #2c2c32;
  }

  .container:after,.container:before{
      content: "";
      display: table;
      clear: both;
  }

  .esquerda,.direita{
      float: left; 
      width: 100%;
      height: 100%;
  }

  .esquerda{
      width:35%;
  }

  .direita{
      width: 60%;
  }

  .foto{
      background: #2c2c32;
      position: relative;
  }

  .status {
    border: none;
    outline: none;
    padding: 10px 16px;
    background-color: #f1f1f1;
    cursor: pointer;
    font-size: 18px;
    width: 30%;
    text-align: center;
  }

  .active, .status:hover {
    background-color: #57b846;
    color: white;
  }

  .botao {
      border-radius: 4px;
      border: 0;
      color: #fff;
      padding: 12px 0;
      text-align: center;
      text-decoration: none;  
      display: block;
      width: 48%;
      margin-bottom: 16px;
  }

  .botao:hover {
      opacity: 0.8;
  }

  .editarPerfil{
      background-color: #57b846;
      float: left;
      padding: 18px;
  }

  .sair{
      background-color: #b94646;
      float: right;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(120, 120, 120, 0.5);
  }

  .modalContent {
    position: relative;
    background-color: #2c2c32;
    margin: 5% auto 15% auto;
    width: 70%;
    box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.3);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
  }

  @-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
  }

  @keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
  }

  .fecharModal {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .fecharModal:hover,
  .fecharModal:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

  .modalHeader, .modalFooter{
    padding: 2px 16px;
    background-color: #202024;
    color: white;
    text-align: center;
  }

  .modalBody {
    padding: 16px 16px;
    font-weight: bold;
    width: 70%;
    margin: auto;
    justify-content: center;
    align-items: center;
  }

  .caixaInput{
    outline: none;
    border-radius: 50px;
    border: 2px solid #212529;
    margin: 8px 0;
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    box-sizing: border-box;
  }
  
  .salvar {
    background-color: #57b846;
    color: #fff;
    outline: none;
    border-radius: 50px;
    border: 2px solid #57b846;
    cursor: pointer;
    width: 50%;
    box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.3);
    padding: 12px;
    margin: auto;
    justify-content: center;
    align-items: center;
  }

  .salvar:hover {
    opacity: 0.9;
  }

  footer {
      padding: 64px 0 32px 0;
      background-color: #1b1b1f;
      text-align: center;
      margin-top: 16px;
  }

  footer .footerContainer {
      width: 50%;
      margin: 0 auto;
  }

  footer p {
      color: rgba(255, 255, 255, 0.5);
      font-size: 16px;
      margin: 0 0 32px 0;
      padding: 0;
      text-align: center;
  }   
  

</style>
<body>

<div class="content" style="max-width:1400px;">
  <div class="row">
    <div class="esquerda">
      <div class="boxSombra">
            <div class="foto">
              <img src="images/pic02.jpeg" style="width:100%">
            </div>

        <div class="container">
          <p><i class="fa fa-user icon"></i><?php echo $nome; ?></p>
          <p><i class="fa fa-envelope icon"></i><?php echo $email; ?></p>
          <p ><i class="fa fa-key icon"></i><?php echo $senha;?></p>
          <p><i class="fa fa-marker icon"></i><?php echo $matricula;?></p>
          <p><div id="myDIV">
              <button class="status">Online</button>
              <button class="status">Inativo</button>
              <button class="status">Offline</button>
          </div></p>
          <hr>
            <button id="abrirModal" class="botao editarPerfil">Editar Perfil</button>
            <div id="editarPerfil" class="modal">
              <div class="modalContent">
                <div class="modalHeader">
                  <span class="fecharModal">&times;</span>
                  <h2>Editar Perfil</h2>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                  <div class="modalBody">
                      <label for="nome">NOME COMPLETO</label><br>
                      <input class="caixaInput" type="text" value="<?php echo $nome; ?>" name="nome">

                      <label for="email">E-MAIL</label>
                      <input class="caixaInput" type="email" value="<?php echo $email; ?>" name="email">

                      <label for="senha">SENHA</label>
                      <input class="caixaInput" type="password" value="<?php echo $senha; ?>" name="senha"> 
                      
                    </div>
                    <div class="modalFooter">
                      <h3><button type="submit" class="salvar">Salvar</button></h3>
                    </div>
                </form>
              </div>
            </div>
          <a href="home.html" class="botao sair">Sair</a>
          <br>
        </div>
      </div><br>
    </div>

    <div class="direita">
      <div class="container boxSombra" style="margin-bottom: 16px;">
        <div class="container">
          <h1><b>Basquete</b></h1>
          <h3><i class="fa fa-calendar icon"></i>Horário</h3>
          <h3>Professor</h3>
          <h3>Local</h3>
          <hr>
        </div>
        <div class="container">
          <h1><b>Futsal</b></h1>
          <h3><i class="fa fa-calendar icon"></i>Horário</h3>
          <h3>Professor</h3>
          <h3>Local</h3>
          <hr>
        </div>
        <div class="container">
          <h1><b>Vôlei</b></h1>
          <h3><i class="fa fa-calendar icon"></i>Horário</h3>
          <h3>Professor</h3>
          <h3>Local</h3>
          <hr>
        </div>
      </div>
    </div>
  </div>
</div>

    <footer>
        <div class="footerContainer">
            <h2>IFCLUB</h2>
            <p>aaa</p>
            <p>aa <a href="#">aa</a></p>
        </div>
    </footer>

    <script>
        var header = document.getElementById("myDIV");
        var btns = header.getElementsByClassName("status");
        for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        if (current.length > 0) { 
        current[0].className = current[0].className.replace(" active", "");
        }
        this.className += " active";
        });
        }

      var modal = document.getElementById("editarPerfil");
      var btn = document.getElementById("abrirModal");
      var span = document.getElementsByClassName("fecharModal")[0];
      btn.onclick = function() {
        modal.style.display = "block";
      }
      span.onclick = function() {
        modal.style.display = "none";
      }
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    </script>
    
</body>
</html>
<?php 
  if($_POST){
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    try{  
      $queryUpdate = "UPDATE cad_usuario set nome_completo = :nome , email= :email , senha_acesso = :senha WHERE matricula = :matricula ;";
      $stmt = $con->prepare($queryUpdate);
      $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
      $stmt->bindValue(":email", $email, PDO::PARAM_STR);
      $stmt->bindValue(":senha", $senha ,PDO::PARAM_STR);
      $stmt->bindValue(":matricula", $matricula, PDO::PARAM_INT);

      if($stmt->execute()){
        
        
        session_destroy();
      
    }
  }catch(PDOException $e){
    die('ERROR: ' . $e->getMessage());
  }
  }
?>