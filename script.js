$(document).ready(function() {
    loadTasks();

    $('#taskForm').submit(function(event) {
        event.preventDefault();
        var taskName = $('#taskName').val();
        var description = $('#description').val();

        $.ajax({
            url: 'backend.php',
            method: 'POST',
            data: {
                action: 'addTask',
                taskName: taskName,
                description: description
            },
            success: function(response) {
                $('#taskForm')[0].reset();
                loadTasks();
            }
        });
    });

    // Excluir tarefa
    $(document).on('click', '.delete-task', function() {
        var taskId = $(this).data('task-id');
        $.ajax({
            url: 'backend.php',
            method: 'POST',
            data: {
                action: 'deleteTask',
                taskId: taskId
            },
            success: function(response) {
                loadTasks();
            }
        });
    });

    // Editar tarefa (adapte conforme sua lógica de edição)
    // Editar tarefa
$(document).on('click', '.edit-task', function() {
    var taskId = $(this).data('task-id');
    // Requisição para buscar os detalhes da tarefa específica para edição
    $.ajax({
        url: 'backend.php',
        method: 'GET',
        data: {
            action: 'getTaskDetails',
            taskId: taskId
        },
        success: function(response) {
            var task = JSON.parse(response);
            // Preenche o alert de edição com os detalhes da tarefa
            $('#editTaskId').val(task.id);
            $('#editTaskName').val(task.task_name);
            $('#editTaskDescription').val(task.description);
            $('#editTaskAlert').addClass('show'); // Mostra o alert
        }
    });
});

// Submissão do formulário de edição
$('#editTaskForm').submit(function(event) {
    event.preventDefault();
    var taskId = $('#editTaskId').val();
    var taskName = $('#editTaskName').val();
    var description = $('#editTaskDescription').val();

    $.ajax({
        url: 'backend.php',
        method: 'POST',
        data: {
            action: 'editTask',
            taskId: taskId,
            taskName: taskName,
            description: description
        },
        success: function(response) {
            $('#editTaskAlert').removeClass('show'); // Esconde o alert após a edição
            loadTasks(); // Recarrega a lista de tarefas após a edição
        }
    });
});


    function loadTasks() {
        $.ajax({
            url: 'backend.php',
            method: 'GET',
            data: { action: 'getTasks' },
            success: function(response) {
                $('#taskList').html(response);
            }
        });
    }
    
});

