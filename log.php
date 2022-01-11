<?php
    session_start();
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if ($_SESSION["nacesso"] == 10){
            header("location: aadm.php");
        }
        else{
            header("location: ausuario.php");
        }
        exit;
    }
    
    require_once "script/conf.php";
    require_once ("../wp/wp-includes/class-phpass.php");
    //require_once "class-phpass.php";
    $username = $password = '';
    $username_err = $password_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = "Insira um usuário.";
        } else{
            $username = trim($_POST["username"]);
        }
        if(empty(trim($_POST["password"]))){
            $password_err = "Digite a senha.";
        } else{
            $password = trim($_POST["password"]);
        }
        if(empty($username_err) && empty($password_err)){
            if (strchr($username,"@")=== FALSE){
                $sql = "SELECT USERS.ID, USERS.user_login, USERS.user_email, USERS.user_pass, USMETA.meta_value FROM abpee03.wp_users USERS JOIN abpee03.wp_usermeta USMETA ON USERS.ID = USMETA.user_id WHERE USERS.user_login = ? AND USMETA.meta_key = 'wp_user_level'";
            }
            else{
                $sql = "SELECT USERS.ID, USERS.user_login, USERS.user_email, USERS.user_pass, USMETA.meta_value FROM abpee03.wp_users USERS JOIN abpee03.wp_usermeta USMETA ON USERS.ID = USMETA.user_id WHERE USERS.user_email = ? AND USMETA.meta_key = 'wp_user_level'";
            }
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("s", $param_username);
                $param_username = $username;
                if($stmt->execute()){
                    $stmt->store_result();
                    if($stmt->num_rows == 1){                    
                        $stmt->bind_result($id, $username,$email, $hashed_password,$nacesso);
                        if($stmt->fetch()){
                            $hsh = new PasswordHash(8,true);
                            if($hsh->CheckPassword($password, $hashed_password)){
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["permissao"] = (int)$nacesso;
                                if($nacesso=="10"){
                                    header("location: aadm.php");
                                }
                                else{
                                    header("location: ausuario.php");
                                }
                            } else{
                                $password_err = "As credenciais não são válidas.";
                                $username_err = $password_err;
                            }
                        }
                    } else{
                        $password_err = "As credenciais não são válidas.";
                        $username_err = $password_err;
                    }
                } else{
                    echo "Tivemos problemas ao autenticar seus dados. Tente mais tarde";
                }
            }
            $stmt->close();
        }
        $mysqli->close();
    }
?>
 
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login Área de Administração -- Abpee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light  bg-light"> <!-- justify-content-end -->
        <div class="navbar-header">
            <a class="navbar-brand" href="https://abpee.net" style="color: lightgreen; font-weight: 900;">Abpee</a>
        </div>
        <ul class="navbar-nav ">  
          <li class="nav-item"><a href="https://abpee.net" class="nav-link">Voltar ao site</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2>Login</h2>
                <p>Utilize suas credenciais do site Abpee para acessar.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Usuário</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                        <br>
                        <?php echo (!empty($username_err)) ? "<span class=\"alert alert-danger\"> ". $username_err . "</span>" : ''; ?>
                    </div>    
                    <div class="form-group " >
                        <label>Senha</label>
                        <input type="password" name="password" class="form-control" required>
                        <br>
                        <?php echo (!empty($password_err)) ? "<span class=\"alert alert-danger\"> ". $password_err . "</span>" : ''; ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>    
</body>
</html>
