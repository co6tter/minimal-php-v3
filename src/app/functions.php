<?php

function h(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function createToken(): void
{
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}

function validateToken(): void
{
    if (empty($_POST['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
        exit('Invalid post request');
    }
}

function getPdoInstance(): PDO
{
    try {

        $pdo = new PDO(
            DSN,
            DB_USER,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // PHP 8.0以降はデフォルト
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false // PHP 8.1以降の仕様変更によりエミュレート無効にしなくても型変換。セキュリティやSQL挙動の厳密さを求める場合は、依然としてfalseの明示が推奨。
            ]
        );

        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage() . PHP_EOL;
        exit;
    }
}

function addTodo(PDO $pdo): void
{
    $title = trim(filter_input(INPUT_POST, 'title'));
    if ($title === '') {
        return;
    }

    $sql = 'INSERT INTO todos (title) VALUES (:title)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
}

function toggleTodo(PDO $pdo): void
{
    $id = filter_input(INPUT_POST, 'id');
    if (empty($id)) {
        return;
    }

    $sql = 'UPDATE todos SET is_done = NOT is_done WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function deleteTodo(PDO $pdo): void
{
    $id = filter_input(INPUT_POST, 'id');
    if (empty($id)) {
        return;
    }

    $sql = 'DELETE FROM todos WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function getTodos(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM todos ORDER BY id DESC');
    $todos = $stmt->fetchAll();
    return $todos;
}
