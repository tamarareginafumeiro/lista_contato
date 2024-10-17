<?php
session_start(); // Iniciar a sessão

require_once 'Database.php';
require_once 'Contato.php';
require_once 'ContatoDAO.php';

$contatoDAO = new ContatoDAO();
$contatos = $contatoDAO->getAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contatos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">    
                   
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['token'])) : ?>
                            <li class="nav-item">
                                <form action="AuthService.php" method="post" style="display: inline;">
                                    <input type="hidden" name="type" value="logout">
                                    <button class="btn btn-link nav-link" type="submit" style="display: inline; border: none; background: none; padding: 0; cursor: pointer;">Logout</button>
                                </form>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="auth.php">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 class="my-4">Lista de Contatos</h1>
        <a href="detalhes.php" class="btn btn-primary mb-4">Adicionar Contato</a>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($contatos as $contato) : ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($contato->getNome(), ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($contato->getTelefone(), ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($contato->getEmail(), ENT_QUOTES, 'UTF-8'); ?></p>
                            <a href="detalhes.php?id=<?php echo $contato->getId(); ?>" class="btn btn-primary">Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>