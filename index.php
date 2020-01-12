<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db_name = 'proect';
        $link = mysqli_connect($host, $user, $pass, $db_name);

        if (!$link) {
            echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
            exit;
        }
        //Добавление пользователя
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $sql = mysqli_query($link, "INSERT INTO `User` (`username`, `firstname`, `lastname`, `register_date`) VALUES ('{$_POST['username']}', '{$_POST['firstname']}', '{$_POST['lastname']}', NOW())");
            if ($sql) {
                echo '<p>Данные успешно добавлены в таблицу.</p>';
            } else {
                echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
            }
        }
        //Отображение пользователей
        $sql = mysqli_query($link, 'SELECT `id`, `username`, `register_date` FROM `User`');
        while ($result = mysqli_fetch_array($sql)) {
            $date = date('d.m.Y h:i', strtotime($result['register_date']));
            echo "{$result['id']}. {$result['username']}. $date - <a href='?del={$result['id']}'>Удалить</a><br>";
        }
        //Удаление пользователя
            if (isset($_GET['del'])) {
            $sql = mysqli_query($link, "DELETE FROM `User` WHERE `id` = {$_GET['del']}");
            if ($sql) {
                echo "<p>Пользователь удален.</p>";
            } else {
                echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
            }
        }
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td>Имя пользователя:</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Имя:</td>
                <td><input type="text" name="firstname"></td>
            </tr>
            <tr>
                <td>Фамилия:</td>
                <td><input type="text" name="lastname"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="OK"></td>
            </tr>
        </table>
    </form>
</body>
</html>