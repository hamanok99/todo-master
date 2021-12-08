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

    //名前を取得する(getter)
    public function getName(){
        return $this->name;
    }

    //期限を取得する(getter)
    public function getDeadline(){
        return $this->deadline;
    }

    // IDを取得する
    public function getId(){
        return $this->id;
    }

    //タスクが完了済みか確認するメソッド
    public function completeTask(){
        if($this->fix_flg === true){
            return true;
        } else {
            return false;
        }
    }

    //タスクが期限切れか確認するメソッド
    public function expiredTask(){
        $today = strtotime(date('Y-m-d'));
        $expired_flag = strtotime($this->deadline);
        if($today > $expired_flag){
            return true;
        }else {
            return false;
        }
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
    public function updateTask($id){
        require "connect.php";
        try{
            $sql = sprintf("UPDATE public.todo SET %s==%s WHERE id = $id;", $this->fix_flg, true);
            $pdo->exec($sql);
            return true;
        }catch(PDOException $e){
            echo "DB登録で例外が発生" . $e->getMessage();
            return false;
        }
    }
}
?>

