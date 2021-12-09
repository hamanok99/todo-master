<?php
require "task.php";
$task = new TaskClass($_POST['name'],$_POST['deadline'],false);
$task->updateTask();

require "taskMgt.php";
$taskManager = new TaskMgtClass();
//未完了タスクを取得
if (isset($_POST['inComplete'])){
    $tasklist = $taskManager->getIncompleteList();
}
//完了タスクを取得
if (isset($_POST['complete'])){
    $tasklist = $taskManager->getCompleteList();
}
//期限切れタスクを取得
if (isset($_POST['expired'])){
    $tasklist = $taskManager->getExpiredList();
}
//全てのタスクを取得
if (isset($_POST['all'])){
    $tasklist = $taskManager->getAllList();
}
?>

<script type="text/javascript">
function nameCheck(){
    getName = document.todo.name.value;
    if(getName){
        return true;
    }else {
        alert("タイトルを入力してください");
        return false;
    }
}

window.onload = function(){
    regist();

}
function regist(){
    <?php if($_POST['name']): ?>
        <?php $task = new TaskClass($_POST['name'],$_POST['deadline'],false); ?>
        result ="<?php var_export($task->registTask()); ?>";
        var_dump(result);
        if(result){
            alert('登録完了いたしました');
        }
    <?php endif; ?>

    <?php if($_POST['taskId']): ?>
        <?php $task = new TaskClass($_POST['name'],$_POST['deadline'],false,$_POST['taskId']); ?>
        result = <?php var_export($task->updateTask()); ?>
        if(result){
            alert('更新完了いたしました');
        }
    <?php endif; ?>

}
window.onload = regist;

function updateOnflg(id) {
    document.main.taskId.value = id;
    document.main.submit();
}

</script>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="todo.css" media="all" />
        <title>ToDoリスト</title>
    </head>
    <body>
        <form name="main" action="index.php" method="post" name='todo'>
        <input type="hidden" name="taskId" value="" />
            <div>
                <h1>ToDoリスト</h1>
                <table>
                    <tr>
                        <td>タイトル</td>
                        <td>期限</td>
                    </tr>
                    <?php foreach ($tasklist as $task): ?>
                        <tr>
                        <?php if ($task->expiredTask() && !$task->completeTask()): ?>
                            <td class="font_red"><?php echo $task->getName(); ?></td>
                            <td class="font_red"><?php echo $task->getDeadline(); ?></td>
                            <td><input type="button" onclick="updateOnflg(<? echo $task->getId() ?>)" value="完了"></td>
                        <?php elseif($task->expiredTask() && $task->completeTask()): ?>
                            <td class="font_red"><?php echo $task->getName(); ?></td>
                            <td class="font_red"><?php echo $task->getDeadline(); ?></td>
                        <?php elseif($task->completeTask()): ?>
                            <td class="font_gray"><?php echo $task->getName(); ?></td>
                            <td class="font_gray"><?php echo $task->getDeadline(); ?></td>
                        <?php else: ?>
                            <td class="font_black"><?php echo $task->getName(); ?></td>
                            <td class="font_black"><?php echo $task->getDeadline(); ?></td>
                            <td><input type="button" onclick="updateOnflg(<? echo $task->getId() ?>)" value="完了"></td>
                        <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><?php echo htmlspecialchars(@$_POST['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars(@$_POST['deadline'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </table>
                <hr>
                <table>
                    <tr>
                        <td>タイトル</td>
                        <td>期限</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="name" name="name" value="">
                        </td>
                        <td>
                            <input type="date" id="deadline" name="deadline" value="">
                        </td>
                        <td>
                            <input type="submit" value="登録" onclick="nameCheck()">
                        </td>
                        <td>
                            <input type="submit" name="inComplete" value="未完了">
                        </td>
                        <td>
                            <input type="submit" name="complete" value="完了">
                        </td>
                        <td>
                            <input type="submit" name="expired" value="期限切れ">
                        </td>
                        <td>
                            <input type="submit" name="all" value="全て">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </body>
</html>