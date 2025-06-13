<?php
/**
 * Menampilkan daftar tugas dalam tabel Bootstrap.
 * Checkbox untuk ubah status, dan tombol hapus.
 *
 * @param array $tasks
 */
function tampilkanDaftar(array $tasks): void {
    echo '<table class="table table-bordered mt-4">';
    echo '<thead class="table-light"><tr><th>Status</th><th>Judul Tugas</th><th>Aksi</th></tr></thead><tbody>';

    foreach ($tasks as $index => $task) {
        $checked   = $task['status'] === 'selesai' ? 'checked' : '';
        $rowClass  = $task['status'] === 'selesai' ? 'table-success' : '';

        echo "<tr class='$rowClass'>";
        
        // Checkbox status
        echo "<td>
                <form method='post' class='d-inline'>
                    <input type='hidden' name='toggle_index' value='$index'>
                    <input type='checkbox' onchange='this.form.submit()' $checked>
                </form>
              </td>";

        // Judul tugas
        echo "<td>" . htmlspecialchars($task['judul']) . "</td>";

        // Tombol hapus
        echo "<td>
                <form method='post' class='d-inline'>
                    <input type='hidden' name='hapus_index' value='$index'>
                    <button class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus tugas ini?\")'>Hapus</button>
                </form>
              </td>";

        echo "</tr>";
    }

    echo '</tbody></table>';
}