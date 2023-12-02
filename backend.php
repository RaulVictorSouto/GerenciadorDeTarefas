<?php
// Conexão com o banco de dados (substitua pelos seus detalhes)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'gerenciador';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Adicionar tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addTask') {
    $taskName = $_POST['taskName'];
    $description = $_POST['description'];

    $sql = "INSERT INTO tasks (task_name, description) VALUES ('$taskName', '$description')";
    $conn->query($sql);
}

// Excluir tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deleteTask') {
    $taskId = $_POST['taskId'];

    $sql = "DELETE FROM tasks WHERE id = '$taskId'";
    $conn->query($sql);
}

// Buscar tarefas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getTasks') {
    $output = '';

    $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output .= '<div class="col-lg-4 mb-2">';
            $output .= '<div class="card">';
            $output .= '<div class="card-body">';
            $output .= '<h5 class="card-title">' . $row['task_name'] . '</h5>';
            $output .= '<p class="card-text">' . $row['description'] . '</p>';
            $output .= '<button class="btn btn-danger delete-task" data-task-id="' . $row['id'] . '">Excluir</button>';
            $output .= '<button class="btn btn-primary edit-task ml-2" data-task-id="' . $row['id'] . '">Editar</button>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    } else {
        $output = '<p class="text-muted">Nenhuma tarefa encontrada</p>';
    }

    echo $output;
}

// Obter detalhes da tarefa para edição
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getTaskDetails') {
    $taskId = $_GET['taskId'];

    $sql = "SELECT * FROM tasks WHERE id = '$taskId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $taskDetails = $result->fetch_assoc();
        echo json_encode($taskDetails); // Retorna os detalhes da tarefa como JSON para serem usados no front-end
    } else {
        echo json_encode([]); // Retorna um array vazio caso a tarefa não seja encontrada
    }
}

// Editar tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editTask') {
    $taskId = $_POST['taskId'];
    $taskName = $_POST['taskName'];
    $description = $_POST['description'];

    $sql = "UPDATE tasks SET task_name = '$taskName', description = '$description' WHERE id = '$taskId'";
    $conn->query($sql);
}

// Fechar conexão
$conn->close();

?>
