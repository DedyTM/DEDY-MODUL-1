<?php
session_start(); // Start session to store data

// Inisialisasi variabel untuk menyimpan nilai input dan error
$nama = $email = $nomor = $tiket = $minta = $tanggal = "";
$namaErr = $emailErr = $nomorErr = $mintaErr = $tanggalErr = "";

// Initialize session data array if not already set
if (!isset($_SESSION['submittedData'])) {
    $_SESSION['submittedData'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    $nama = $_POST["nama"];
    if (empty($nama)) {
        $namaErr = "Nama wajib diisi";
    }

    // Validasi Email
    $email = $_POST["email"];
    if (empty($email)) {
        $emailErr = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Email harus mengandung karakter '@' dan format yang valid";
    }

    // Validasi Nomor Telepon
    $nomor = $_POST["nomor"];
    if (empty($nomor)) {
        $nomorErr = "Nomor Telepon wajib diisi";
    } elseif (!ctype_digit($nomor)) {
        $nomorErr = "Nomor Telepon harus berupa angka";
    } elseif (strlen($nomor) != 12) {
        $nomorErr = "Nomor Telepon harus terdiri dari 12 angka";
    }

    // Validasi minta   
    $minta = $_POST["minta"];
    // Tidak ada validasi wajib diisi untuk permintaan khusus
    
    $tanggal = $_POST["date"];
    if (empty($tanggal)) {
        $tanggalErr = "Tanggal wajib diisi";
    }

    // Menyimpan pilihan mobil tanpa validasi khusus
    $tiket = $_POST["tiket"];

    if (!$namaErr && !$emailErr && !$nomorErr && !$mintaErr && !$tanggalErr) {
        // Store submitted data in session
        $_SESSION['submittedData'][] = [
            'nama' => $nama,
            'email' => $email,
            'nomor' => $nomor,
            'tanggal' => $tanggal,
            'tiket' => $tiket,
            'minta' => $minta
        ];

        // Clear input fields
        $nama = $email = $nomor = $tiket = $minta = $tanggal = "";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Tiket Menara Teratai</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Form Pembelian Tiket Menara Teratai</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>">
                <span class="error"><?php echo $namaErr ? "* $namaErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr ? "* $emailErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="nomor">Nomor Telepon:</label>
                <input type="text" id="nomor" name="nomor" value="<?php echo $nomor; ?>">
                <span class="error"><?php echo $nomorErr ? "* $nomorErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="date">Tanggal Pemesanan:</label>
                <input type="date" id="date" name="date" value="<?php echo $tanggal; ?>">
                <span class="error"><?php echo $tanggalErr ? "* $tanggalErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="tiket">Pilih Tiket:</label>
                <select id="tiket" name="tiket">
                    <option value="Tiket LT 5" <?php echo ($tiket == "Tiket LT 5") ? "selected" : ""; ?>>Tiket LT 5</option>
                    <option value="Tiket LT 4" <?php echo ($tiket == "Tiket LT 4") ? "selected" : ""; ?>>Tiket LT 4</option>
                    <option value="Tiket LT 3" <?php echo ($tiket == "Tiket LT 3") ? "selected" : ""; ?>>Tiket LT 3</option>
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="minta">Permintaan khusus:</label>
                <textarea id="minta" name="minta"><?php echo $minta; ?></textarea>
                <span class="error"><?php echo $mintaErr ? "* $mintaErr" : ""; ?></span>
            </div>

            <div class="button-container">
                <button type="submit">Pesan Tiket</button>
            </div>
        </form>
    </div>

    <?php if (!empty($_SESSION['submittedData'])) { ?>
    <div class="container">
        <h3>Data Pembelian:</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="20%">Nama</th>
                        <th width="20%">Email</th>
                        <th width="15%">Nomor Telepon</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Tiket</th>
                        <th width="30%">Permintaan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['submittedData'] as $data) { ?>
                    <tr>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['nomor']; ?></td>
                        <td><?php echo $data['tanggal']; ?></td>
                        <td><?php echo $data['tiket']; ?></td>
                        <td><?php echo $data['minta']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</body>

</html>