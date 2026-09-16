<?php
session_start();
include "koneksi.php";

$email = $_POST['email'];
$password_input = $_POST['password']; // Password yang diketik user

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    
    // PERBAIKAN BUG: Menggunakan password_verify untuk mencocokkan password_hash
    if (password_verify($password_input, $data['password'])) {
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['jurusan'] = $data['jurusan'];
        $_SESSION['status'] = "login";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Password salah! <a href='login.php'>Kembali</a>";
    }
} else {
    echo "Email tidak ditemukan! <a href='login.php'>Kembali</a>";
}
?>
