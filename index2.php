<?php

// 画面を開いた際に $_GETでページIDと画面モードを取得
$page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 1;
$mode = isset($_GET['mode']) ? $_GET['mode'] : "incomplete";

// DB接続
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
// クエリ実行
$stmt = $pdo->query($query);

?>

<html>
    <body>
        <form>
            <div>
                <input type="button" onclick="location.href='./index2.php?page_id=1&mode=incomplete'" value="未完了一覧">
                &nbsp;
                <input type="button" onclick="location.href='./index2.php?page_id=1&mode=complete'" value="完了一覧">
            </div>
        </form>
        <table border=1>
        <tr>
            <td>名前</td>
            <td>期限</td>
        </tr>
        <?php foreach ($stmt as $data): ?>
                <tr>
                    <td><?php echo $data[1];?></td>
                    <td><?php echo $data[2];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if($page_id > 1): ?>
        <a href="index2.php?<?php echo sprintf("page_id=%s&mode=%s",($page_id - 1), $mode); ?>">前のページ</a>
        <?php else: ?>
        <span>前のページ</span>
        <?php endif; ?>
        <a href="index2.php?<?php echo sprintf("page_id=%s&mode=%s",($page_id + 1), $mode); ?>">次のページ</a>
    </body>
</html>
