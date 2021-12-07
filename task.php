<?php
class TaskClass{
    //ID
    private $id;

    //タイトルネーム
    private $name;

    //期限
    private $deadline;

    //完了フラグ
    private $fix_flg;

    function __construct($name, $deadline, $fix_flg, $id = null){
        $this->name = $name;
        $this->deadline = $deadline;
        $this->fix_flg = $fix_flg;
        $this->id = $id;
    }

    // //タスクが完了済みか確認するメソッド
    // public function completeTask(){

    // }

    //タスクが期限切れか確認するメソッド
    public function expiredTask(){

    }

    //タスクを登録するメソッド
    public function registTask(){
        require "connect.php";
        try{
            $sql = sprintf("INSERT INTO public.todo (name, deadline, fix_flg) VALUES ('%s', '%s', %s);", $this->name, $this->deadline, var_export($this->fix_flg, true));
            $pdo->exec($sql);
            return true;
        }catch(PDOException $e){
            echo "DB登録で例外が発生" . $e->getMessage();
            return false;
        }

    }

    //タスクを更新するメソッド
    public function updateTask(){

    }
}
?>