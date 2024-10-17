<?php
session_start();
require_once 'Usuario.php';
require_once 'UsuarioDAO.php';

$type = filter_input(INPUT_POST, "type");

if($type === "register") {
    //// Cadastro de Usuario

    // Recebimento de dados vindos por iput
    $new_nome = filter_input(INPUT_POST, "new_nome");
    $new_email = filter_input(INPUT_POST, "new_email", FILTER_SANITIZE_EMAIL);
    $new_password = filter_input(INPUT_POST, "new_password");
    $confirm_password = filter_input(INPUT_POST, "confirm_password");

    //Verificação do dados
    if($new_email && $new_nome && $new_password) {
        if($new_password === $confirm_password) {
           
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(25));

            // Criação do Usuário no banco de dados
            $usuario = new Usuario(null, $new_nome, $hashed_password, $new_email, null);
            $usuarioDAO = new UsuarioDAO();

            if(!$usuarioDAO->getByEmail($new_email))

            $success = $usuarioDAO->create($usuario);

            if($success){
                $_SESSION ['token'= $token];
            header('Location: index.php');
                exit();
            } else {
                echo "Email já utilizado";
            }
     } else {
        echo "As senhas devem ser iguais!";
     }
    } else {
        echo "Dados inválidos!";
    }
} elseif ($type === "login") {
    /// login de usuário

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password");

    // Verificar se o cadastro exixte
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->getByEmail($email);
    
    // Redirecionar o usuário para index autenticado
    if ($usuario && password_verify($passeword, $usuario->getSenha())) {
        $token = bin2hex(random_bytes(25));
        $usuarioDAO->updateToken($usuario->getId(), $token); 
        $_SESSION['token'] = $token;
        header('Location: index.php');
        exit();

     } else {
        echo "Email ou senha inválidos!";
     } 
    
}  elseif ($type === "logout") {
    // Limpa todas as varáveis da sessão 
    $_SESSION = array();

    // Destruir a sessão
    session_destroy();

    // Redirecionar para a página de login
    header('Location: index.php');
    exit();
}

?>