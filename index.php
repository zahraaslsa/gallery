<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Landing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: lightslategrey;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        ul li {
            display: inline-block;
            margin-right: 10px;
        }

        ul li a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        ul li a:hover {
            background-color: #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: white;
        }

        img {
            max-width: 200px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Halaman Gallery Foto</h1>
    <?php
    session_start();
    if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
        ?>
        <p>Selamat Datang <b>
                <?= htmlspecialchars($_SESSION['namalengkap']) ?>
            </b></p>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="album.php">Album</a></li>
            <li><a href="foto.php">Foto</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <?php
    } else {
        ?>
        <ul>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
        <?php
    }
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Uploader</th>
            <th>Jumlah Like</th>
            <th>Aksi</th>
        </tr>
        <?php
        include "koneksi.php";
        $sql = "SELECT foto.fotoid, foto.judulfoto, foto.deskripsifoto, foto.lokasifile, user.namalengkap FROM foto INNER JOIN user ON foto.userid=user.userid";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td>
                    <?= htmlspecialchars($data['fotoid']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($data['judulfoto']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($data['deskripsifoto']) ?>
                </td>
                <td>
                    <img src="gambar/<?= htmlspecialchars($data['lokasifile']) ?>" alt="Foto" width="200">
                </td>
                <td>
                    <?= htmlspecialchars($data['namalengkap']) ?>
                </td>
                <td>
                    <?php
                    $fotoid = $data['fotoid'];
                    $sql2 = "SELECT * FROM likefoto WHERE fotoid=?";
                    $stmt = mysqli_prepare($conn, $sql2);
                    mysqli_stmt_bind_param($stmt, "i", $fotoid);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    echo mysqli_stmt_num_rows($stmt);
                    mysqli_stmt_close($stmt);
                    ?>
                </td>
                <td>
                    <a href="like.php?fotoid=<?= htmlspecialchars($data['fotoid']) ?>">Like</a>
                    <a href="komentar.php?fotoid=<?= htmlspecialchars($data['fotoid']) ?>">Komentar</a>
                </td>
            </tr>
            <?php
        }
        mysqli_close($conn);
        ?>
    </table>

</body>

</html>