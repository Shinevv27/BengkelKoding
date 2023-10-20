<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Register</title>
  </head>
  <body>
    <?php
      require_once 'connect.php'; // Koneksi ke database

      /**
       * Cegah akses ke halaman login saat sedang login.
       */
      if(isset($_SESSION['is_login']) || isset($_COOKIE['_logged'])) {
        header('location: /');
      }

      if(isset($_POST['submit'])) {
        /**
         * Mendapatkan data dari formulir pendaftaran.
         * Data: Email, Kata Sandi, Nama Lengkap, dan NIM.
         */
        $email    = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $name     = strip_tags($_POST['name']);
        $nim      = strip_tags($_POST['nim']);

        if(empty($email) || empty($password) || empty($name) || empty($nim)) {
          /**
           * Cek apakah formulir telah terisi data.
           */
          echo '<b>Warning!</b> Silahkan isi data yang diperlukan.';
        } elseif(count((array) $connect->query('SELECT email FROM mahasiswa WHERE email = "'.$email.'" OR nim = "'.$nim.'"')->fetch_array()) > 1) {
          /**
           * Cek jika email atau NIM telah terdaftar.
           */
          echo '<b>Warning!</b> Email atau NIM telah terdaftar.';
        } else {
          /**
           * Memasukkan data ke database.
           */
          $insert = $connect->query('INSERT INTO `mahasiswa`(`email`, `password`, `nama_lengkap`, `nim`) VALUES("'.$email.'", "'.password_hash($password, PASSWORD_BCRYPT).'", "'.$name.'", "'.$nim.'")');
          if($insert) {
            echo 'Pendaftaran berhasil!';
          } else {
            echo 'Pendaftaran gagal!';
          }
        }
      }
    ?>
    <form method="POST">
      <input type="text" name="email" value="" autocomplete="off" placeholder="Email">
      <br/>
      <input type="password" name="password" value="" autocomplete="off" placeholder="Kata sandi">
      <br/>
      <input type="text" name="name" value="" autocomplete="off" placeholder="Nama lengkap">
      <br/>
      <input type="text" name="nim" value="" autocomplete="off" placeholder="NIM">
      <br/>
      <input type="submit" name="submit" value="Register">
    </form>
  </body>
</html>