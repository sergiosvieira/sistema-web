<?php $v->layout("_theme"); ?>

<script>
  function show_hidden() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}
</script>

<div id="login">
    <h3 class="text-center pt-5">Página de Acesso</h3>
    <div class="container">
      <div id="login-row" class="row justify-content-center align-items-center">
        <div id="login-column" class="col-md-6">
          <div id="login-box" class="col-md-12">
            <form id="login-form" class="form" action="" method="post">
              <h3 class="text-center">Login</h3>
              <div class="form-group">
                <label for="username">Nome do usuário:</label><br>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password" >Senha:</label><br>
                <input type="password" name="password" id="password" class="form-control" required>                
                <input  type="checkbox" onclick="show_hidden()"> <label >Exibir Senha</label>
              </div>
              <div class="form-group">
                <label for="remember-me" ><a href="" >Esqueci minha
                    senha</a></label><br>
                <input type="submit" name="submit" class="btn-primary btn-btn-md" value="Enviar">
              </div>
              <div id="register-link" class="text-right">
                <a href="#" >Registre-se aqui</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
