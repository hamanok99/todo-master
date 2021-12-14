<?php
require "task.php";

require "taskMgt.php";
$taskManager = new TaskMgtClass();
//未完了タスクを取得
if (isset($_POST['inComplete'])){
    $tasklist = $taskManager->getIncompleteList();
    $selectTask = "未完了タスク一覧";
}
//完了タスクを取得
if (isset($_POST['complete'])){
    $tasklist = $taskManager->getCompleteList();
    $selectTask = "完了タスク一覧";
}
//期限切れタスクを取得
if (isset($_POST['expired'])){
    $tasklist = $taskManager->getExpiredList();
    $selectTask = "期限切れタスク一覧";
}
//全てのタスクを取得
if (isset($_POST['all'])){
    $tasklist = $taskManager->getAllList();
    $selectTask = "全タスク一覧";
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

function regist(){
    <?php if(isset($_POST['name'])): ?>
        <?php $task = new TaskClass($_POST['name'],$_POST['deadline'],false); ?>
        result ="<?php var_export($task->registTask()); ?>";
        if(result){
            alert("登録完了いたしました");
        }
        <?php endif; ?>
}

function updateOnflg(id){
    check = window.confirm('このタスクを完了します');
    if (check){
        document.todo.taskId.value = id;
        document.todo.submit();
        <?php if($_POST['taskId']): ?>
            <?php $task = new TaskClass($_POST['name'],$_POST['deadline'],false); ?>
            <?php var_export($task->updateTask($_POST['taskId'])); ?>
        <?php endif; ?>
        return true;
    }else{
        return false;
    }
}

function editOnflg(id, name, deadline){


        alert(id);
        alert(name);
        alert(deadline);


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
        <form action="index.php" method="post" name='todo'>
            <input type="hidden" name="taskId" value="" >
            <input type="hidden" name="taskName" value="" >
            <input type="hidden" name="taskDeadline" value="" >
            <div class="contact">
                <h1 class="titlearea">ToDoリスト</h1>
                <table class="listarea">
                    <tr>
                        <?php if(isset($_POST['inComplete'])): ?>
                            <td class="font-change"><font color="black"><?php echo $selectTask; ?></font></td>
                        <?php endif; ?>
                        <?php if(isset($_POST['complete'])): ?>
                            <td class="font-change"><font color="gray"><?php echo $selectTask; ?></font></td>
                        <?php endif; ?>
                        <?php if(isset($_POST['expired'])): ?>
                            <td class="font-change"><font color="#ff7f50"><?php echo $selectTask; ?></font></td>
                        <?php endif; ?>
                        <?php if(isset($_POST['all'])): ?>
                            <td class="font-change"><font color="skyblue"><?php echo $selectTask; ?></font></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th class="font-change">タイトル</th>
                        <th class="font-change">期限</th>
                    </tr>
                    <?php foreach ($tasklist as $task): ?>
                        <tr>
                            <?php if ($task->expiredTask() && !$task->completeTask()): ?>
                                <td class="font_red"><?php echo $task->getName(); ?></td>
                                <td class="font_red"><?php echo $task->getDeadline(); ?></td>
                                <td>
                                    <input class="expiredButton" type="button" onclick="updateOnflg(<? echo $task->getId() ?>)" value="完了">
                                </td>
                                <td>
                                    <input class="editButton" type="button" onclick="editOnflg(<? echo $task->getId() ?>, '<? echo $task->getName() ?>', '<? echo $task->getDeadline() ?>')" value="編集">
                                </td>
                            <?php elseif($task->expiredTask() && $task->completeTask()): ?>
                                <td class="font_red"><?php echo $task->getName(); ?></td>
                                <td class="font_red"><?php echo $task->getDeadline(); ?></td>
                                <td>
                                    <input class="editButton" type="button" onclick="editOnflg(<? echo $task->getId() ?>, '<? echo $task->getName() ?>', '<? echo $task->getDeadline() ?>')" value="編集">
                                </td>
                            <?php elseif($task->completeTask()): ?>
                                <td class="font_gray"><?php echo $task->getName(); ?></td>
                                <td class="font_gray"><?php echo $task->getDeadline(); ?></td>
                                <td>
                                    <input class="editButton" type="button" onclick="editOnflg(<? echo $task->getId() ?>, '<? echo $task->getName() ?>', '<? echo $task->getDeadline() ?>')" value="編集">
                                </td>
                            <?php else: ?>
                                <td class="font_black"><?php echo $task->getName(); ?></td>
                                <td class="font_black"><?php echo $task->getDeadline(); ?></td>
                                <td>
                                    <input class="inCompleteButton" type="button" onclick="updateOnflg(<? echo $task->getId() ?>)" value="完了">
                                </td>
                                <td>
                                    <input class="editButton" type="button" onclick="editOnflg(<? echo $task->getId() ?>, <? echo $task->getName() ?>, <? echo $task->getDeadline() ?>)" value="編集">
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="font-change"><?php echo htmlspecialchars(@$_POST['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="font-change"><?php echo htmlspecialchars(@$_POST['deadline'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </table>
                <hr class="hr-border">
                <table class="buttonarea">
                    <tr>
                        <td>
                            <input class="inCompleteButton" type="submit" name="inComplete" value="未完了">
                        </td>
                        <td>
                            <input class="completeButton" type="submit" name="complete" value="完了">
                        </td>
                        <td>
                            <input class="expiredButton" type="submit" name="expired" value="期限切れ">
                        </td>
                        <td>
                            <input class="allButton" type="submit" name="all" value="全て">
                        </td>
                    </tr>
                </table>
                <table class="textarea">
                    <tr>
                        <td>
                            <input class="text" type="text" id="name" name="name" value="">
                        </td>
                        <td>
                            <input type="date" id="deadline" name="deadline" value="">
                        </td>
                        <td>
                            <input class="registButton" type="submit" value="登録" onclick="nameCheck();regist()">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </body>
</html>