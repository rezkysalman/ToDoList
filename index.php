<?php
include 'functions.php';

// Simulasi data tugas (bisa dihubungkan ke file/database untuk data permanen)
$tasks = [
    ['judul' => 'Belajar Matematika', 'status' => 'belum'],
    ['judul' => 'Ngerjain Tugas Kuliah', 'status' => 'selesai']
];

// Logika menambahkan tugas baru dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['judul'])) {
    $tasks[] = ['judul' => $_POST['judul'], 'status' => 'belum'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ToDoList</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>ToDoList Sederhana</h1>
    </header>

    <section class="form-section">
        <h2>Tambah Tugas Baru</h2>
        <form method="post" action="">
            <input type="text" name="judul" placeholder="Nama tugas..." required>
            <button type="submit">Tambah</button>
        </form>
    </section>

    <section class="task-section">
        <h2>Daftar Tugas</h2>
        <?php tampilkanDaftar($tasks); ?>
    </section>
</body>
</html>