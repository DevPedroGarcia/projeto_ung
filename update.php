<?php
require 'conexao.php';

$usuario = null;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            echo "Usuário não encontrado.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    try {
        $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Usuário atualizado com sucesso!";
            header("Location: read.php");
            exit();
        } else {
            echo "Erro ao atualizar o usuário.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Editar Usuário</title>
</head>
<body>
    <div class="logo-container">
        <img src="imagens/trabalho_ung.png" alt="Logo UNG">
    </div>
    <h1>Editar Usuário</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id'] ?? '') ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
        <br>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
        <br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
