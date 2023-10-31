<?php
require_once "../utils/conn.php";

$query = "SELECT tb_karyawan.idkaryawan AS idkaryawan, tb_karyawan.nama AS nama, tb_login.username AS username, tb_login.email AS email, alamat, telp, 
CASE
    WHEN tb_login.idkaryawan IS NOT NULL OR auth.idkaryawan IS NOT NULL
    THEN 1
    ELSE 0
END as is_used
FROM `tb_karyawan` LEFT JOIN tb_login 
USING(idkaryawan)
LEFT JOIN auth 
USING(idkaryawan) 
ORDER BY tb_karyawan.idkaryawan ASC";

$sql = queryData($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
<?php include "../components/navbar.php" ?>

    <main class="main-container">    
        <a href="add.php" class="btn-add btn btn-primary">Tambah data</a>
        <div class='table-con'>
            <table>
                <thead>
                    <th>ID Karyawan</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th class="action-head">Actions</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($sql as $data) {
                        echo "<tr>";
                        $inner = "";

                        $is_used = array_pop($data);
                        $attr_btn = $is_used ? "pointer-events: none; cursor: not-allowed; opacity: 0.35;" : "";
                        $del_link = $is_used ? "api/delete.php?id={$data['idkaryawan']}" : "";

                        foreach ($data as $val) {
                            $value = empty($val) ? "<a href='../register.php?ignoreAuth&redirect={$_SERVER['REQUEST_URI']}&k=${data['idkaryawan']}'><i style='opacity: .5'>Not Set~</i></a>" : $val;
                            $inner = $inner . "<td>" . $value . "</td>";
                        }


                        echo $inner;
                        echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a style="$attr_btn" class='table-action unselect' href='$del_link'>DELETE</a>
                            <a class='table-action unselect' href='edit.php?id={$data['idkaryawan']}'>EDIT</a>
                        </div>
                    </td> 
                    act;
                    }

                    echo "</tr>";
                    ?>

                </tbody>
            </table>
        </div>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>