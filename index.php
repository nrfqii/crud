<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "dbmahasiswa";

$koneksi = mysqli_connect($host, $user, $password, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi " . mysqli_connect_error());
}

$id = "";
$nim = "";
$nama = "";
$alamat = "";
$fakultas = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = '';
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM mahasiswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['nim'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $fakultas = $r1['fakultas'];
}

// Input data
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $fakultas = $_POST['fakultas'];

    if ($nim && $alamat && $fakultas && $nama) {
        if ($op == 'edit') {
            $sql1 = "UPDATE mahasiswa SET nim = '$nim', nama = '$nama', alamat = '$alamat', fakultas = '$fakultas' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
        } else {
            $sql1 = "INSERT INTO mahasiswa (id, nim, nama, alamat, fakultas) VALUES ('$id', '$nim', '$nama', '$alamat', '$fakultas')";
            $q1 = mysqli_query($koneksi, $sql1);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>
  <div class="mx-auto">
    <!-- Input Data -->
    <div class="card">
        <div class="card-header">
            Create / Edit Data
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>">
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                </div>
                <div class="mb-3">
                    <select name="fakultas" id="fakultas" class="form-control">
                        <option value="">-Pilih Fakultas-</option>
                        <option value="Sistem Informasi" <?php if($fakultas=="Sistem Informasi") echo "selected" ?>>Sistem Informasi</option>
                        <option value="Teknik Informatika" <?php if($fakultas=="Teknik Informatika") echo "selected" ?>>Teknik Informatika</option>
                        <option value="Akuntansi" <?php if($fakultas=="Akuntansi") echo "selected" ?>>Akuntansi</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- Output Data -->
    <div class="card">
        <div class="card-header text-white bg-secondary">
            Data Mahasiswa
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Fakultas</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT * FROM mahasiswa ORDER BY id DESC";
                    $q2 = mysqli_query($koneksi, $sql2);
                    $urut = 1;
                    while($r2 = mysqli_fetch_array($q2)){
                        $id = $r2['id'];
                        $nim = $r2['nim'];
                        $nama = $r2['nama'];
                        $alamat = $r2['alamat'];
                        $fakultas = $r2['fakultas'];
                    ?>
                    <tr>
                        <th scope="row"><?php echo $urut++ ?></th>
                        <td><?php echo $id ?></td>
                        <td><?php echo $nim ?></td>
                        <td><?php echo $nama ?></td>
                        <td><?php echo $alamat ?></td>
                        <td><?php echo $fakultas ?></td>
                        <td><a href="index.php?op=edit&id=<?php echo $id?>" class="btn btn-warning">Edit</a> 
                            <a href="index.php?op=delete&id=<?php echo $id ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
