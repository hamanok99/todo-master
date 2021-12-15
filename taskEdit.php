<?php
require "task.php";
?>

<script type="text/javascript">
function edit(){
    <?php if($_POST['taskId']): ?>
        <?php $task = new TaskClass($_POST['name'],$_POST['deadline'],false,$_POST['taskId']); ?>
        result = <?php var_export($task->editTask($_POST['taskId'])); ?>
    <?php endif; ?>
}
window.onload = edit;
</script>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="todo.css" media="all" />
        <title>ToDoリスト編集</title>
    </head>
    <body>
        <form action="taskEdit.php" method="post" name='todo'>
            <input type="hidden" name="taskId" value="" >
            <div class="contact">
                <h1 class="titlearea">タスク編集</h1>
                <table class="textarea">
                    <tr>
                        <td>タイトル</td>
                        <td>
                            <input class="text" type="text" id="name" name="name" value="<?php echo $_POST['taskName'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>期限</td>
                        <td>
                            <input type="date" id="deadline" name="deadline" value="<?php echo $_POST['taskDeadline'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="editButton" type="button" value="更新">
                        </td>
                        <td>
                            <input class="backButton" type="button" onclick="location.href='./index.php'" value="戻る">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </body>
</html>