# GerenciadorDeTarefas
Gerenciador de Tarefas que utiliza as tecnologias: HTML, CSS, Javascript, PHP e Bootstrap

Criar o banco de dados através do seguinte comando:

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
