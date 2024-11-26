<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Usuário excluído com sucesso!";
        } else {
            echo "Erro ao excluir o usuário.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    header("Location: read.php");
    exit();
} else {
    echo "ID inválido.";
    exit();
}
?>
