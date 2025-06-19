<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

$tasks = $_SESSION['tasks'];

// Tambah tugas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['judul'])) {
    $judul = trim($_POST['judul']);
    if (!empty($judul)) {
        $tasks[] = ['judul' => $judul, 'status' => 'belum'];
    }
}

// Ubah status
if (isset($_POST['toggle_index'])) {
    $i = (int) $_POST['toggle_index'];
    if (isset($tasks[$i])) {
        $tasks[$i]['status'] = $tasks[$i]['status'] === 'selesai' ? 'belum' : 'selesai';
    }
}

// Hapus tugas
if (isset($_POST['hapus_index'])) {
    $i = (int) $_POST['hapus_index'];
    if (isset($tasks[$i])) {
        unset($tasks[$i]);
        $tasks = array_values($tasks);
    }
}

// Edit tugas
if (isset($_POST['edit_index']) && isset($_POST['edit_judul'])) {
    $i = (int) $_POST['edit_index'];
    $judulBaru = trim($_POST['edit_judul']);
    if (isset($tasks[$i]) && !empty($judulBaru)) {
        $tasks[$i]['judul'] = $judulBaru;
    }
}

$_SESSION['tasks'] = $tasks;

// Fungsi untuk menampilkan daftar tugas
function tampilkanDaftar($tasks) {
    echo "<table class='table'>";
    echo "<thead><tr><th>#</th><th>Judul</th><th>Status</th><th>Aksi</th></tr></thead><tbody>";
    foreach ($tasks as $i => $task) {
        $statusClass = $task['status'] === 'selesai' ? 'table-success' : '';
        echo "<tr class='$statusClass'>";
        echo "<td>" . ($i + 1) . "</td>";

        if (isset($_POST['edit_mode']) && $_POST['edit_mode'] == $i) {
            echo "<td colspan='2'>
                    <form method='post' class='d-flex gap-2'>
                        <input type='hidden' name='edit_index' value='$i'>
                        <input type='text' name='edit_judul' value='" . htmlspecialchars($task['judul']) . "' class='form-control' required>
                        <button type='submit' class='btn btn-success'>Simpan</button>
                    </form>
                  </td>";
        } else {
            echo "<td>" . htmlspecialchars($task['judul']) . "</td>";
            echo "<td>" . ucfirst($task['status']) . "</td>";
        }

        echo "<td class='d-flex gap-1'>
                <form method='post'>
                    <input type='hidden' name='toggle_index' value='$i'>
                    <button type='submit' class='btn btn-sm btn-warning'>✔</button>
                </form>
                <form method='post'>
                    <input type='hidden' name='hapus_index' value='$i'>
                    <button type='submit' class='btn btn-sm btn-danger'>🗑</button>
                </form>";

        if (!isset($_POST['edit_mode']) || $_POST['edit_mode'] != $i) {
            echo "<form method='post'>
                    <input type='hidden' name='edit_mode' value='$i'>
                    <button type='submit' class='btn btn-sm btn-info'>✏️</button>
                  </form>";
        }

        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(to right, #FFDEE9, #B5FFFC);
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #FF6B6B;
            border: none;
        }
        .btn-primary:hover {
            background-color: #FF4C4C;
        }
        .form-control {
            border-radius: 10px;
        }
        .table {
            border-radius: 15px;
            overflow: hidden;
        }
        th {
            background-color: #ffe6f0;
        }
        .table-success {
            background-color: #d4fcdc !important;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <header class="text-center mb-4">
        <h1 class="text-danger">🎉 ToDoList</h1>
        <p class="text-dark">Tandai tugas selesai, hapus yang tidak perlu, dan edit bila perlu</p>
    </header>

    <!-- Form tambah tugas -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="post" class="d-flex gap-2">
                <input type="text" name="judul" class="form-control" placeholder="Tulis tugas baru..." required>
                <button type="submit" class="btn btn-primary px-4">Tambah</button>
            </form>
        </div>
    </div>

    <!-- Tabel daftar tugas -->
    <div class="card">
        <div class="card-body">
            <?php
            if (empty($tasks)) {
                echo "<p class='text-center text-muted'>✨ Belum ada tugas, yuk tambah satu!</p>";
            } else {
                tampilkanDaftar($tasks);
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
