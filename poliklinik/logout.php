<?php
require_once 'connect.php'; // Koneksi ke database.
if(isset($_SESSION['is_login']) || isset($_COOKIE['_logged'])) {
  /**
   * Menghapus sesi atau cookie yang aktif.
   */
  if(session_destroy()) {
    setcookie('_logged', null, -(60 * 60 * 24), '/');
    header('location: /');
    exit;
  }
} else {
  header('location: /');
}
?>