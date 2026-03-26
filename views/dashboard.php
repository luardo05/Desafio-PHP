<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: auth/login.php");
    exit;
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Agenda - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    
    <style>
        body { background-color: #f8f9fa; }
        #calendar { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-height: 500px; }
        .fc-event { cursor: pointer; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="bi bi-calendar-check"></i> Minha Agenda</a>
        <div class="d-flex border-start ps-3">
            <span class="navbar-text me-3 text-white">Olá, <strong><?php echo $_SESSION['usuario_login']; ?></strong></span>
            <a href="?logout=1" class="btn btn-outline-danger btn-sm">Sair</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Ações</h5>
                    <a href="atividades/criar.php" class="btn btn-primary w-100 mb-2">+ Nova Atividade</a>
                    <a href="atividades/listar.php" class="btn btn-outline-secondary w-100">Gerenciar Lista</a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/pt-br.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        initialView: 'dayGridMonth', 
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'atividades/eventos.php',
        
        eventClick: function(info) {
            window.location.href = 'atividades/editar.php?id=' + info.event.id;
        }
    });
    calendar.render();
});
</script>
</body>
</html>