<?php

$page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 1;
$mode = isset($_GET['mode']) ? $_GET['mode'] : "incomplete";

$url = parse_url(getenv('DATABASE_URL'));
$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
$pdo = new PDO($dsn, $url['user'], $url['pass']);

switch ($mode) {
    case "incomplete":
        $query = sprintf("SELECT id, name, deadline, fix_flg FROM public.todo WHERE fix_flg = false ORDER BY id LIMIT 5 OFFSET %d;",5 * ($page_id - 1));
        break;
    case "complete":
        $query = sprintf("SELECT id, name, deadline, fix_flg FROM public.todo WHERE fix_flg = true ORDER BY id LIMIT 5 OFFSET %d;",5 * ($page_id - 1));
        break;
}

$stmt = $pdo->query($query);
?>

<html>
    <body>
        <form>
            <div><input type="button" onclick="location.href='./index2.html?page_id=1&mode=incomplete'" value="未完了一覧"></div>
            <div><input type="button" onclick="location.href='./index2.html?page_id=1&mode=complete'" value="完了一覧"></div>
        </form>
        <table>
            <?php foreach ($stmt as $data): ?>
                <tr>
                    <td><?php echo $data[1];?></td>
                    <td><?php echo $data[2];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="index2.php?page_id=<?php echo ($page_id-1); ?>">前のページ</a>
        <a href="index2.php?page_id=<?php echo ($page_id+1); ?>">次のページ</a>
    </body>
</html>
