<?php
/**
 * User: Konel
 * Date: 26.10.2022
 * Time: 22:10
 */

    abstract class abstractUsers extends kernel
    {
        abstract public function profile($userID);
        abstract public function userCreate();
        abstract public function usersList($currentUserModule);
        abstract public function userEdit();
        abstract public function userDelete();
    }

    class users extends abstractUsers
    {

        public function __construct()
        {
            parent::__construct();
            if ($_POST) { $_POST = $this->preQuery($_POST); }

        }

        public function profile($userID)
        {
            $this->update("users","department_full = '{$_POST['department_full']}', department_short = '{$_POST['department_short']}', room = '{$_POST['room']}', phone = '{$_POST['phone']}'","id = '$userID'");
            header("Location: /?page=profile");
        }

        public function userCreate()
        {
            $queryLoginCheck = $this->select("id","users", "login = '{$_POST['login']}'");
            if ($queryLoginCheck->num_rows == 0)
            {
                $this->insert("users","null, '{$_POST['department_full']}', '{$_POST['department_short']}', '{$_POST['type']}', '{$_POST['room']}', '{$_POST['phone']}', '{$_POST['login']}', '{$_POST['password']}', '{$_POST['module']}', 'user'");
                return "1";
            }
            else { return "0"; }
        }

        public function usersList($currentUserModule)
        {
            $usersList = array();
            $queryUsersList = $this->select("*","users","module = '{$currentUserModule}'","department_full ASC");
            if ($queryUsersList->num_rows != 0)
            {
                while ($array = mysqli_fetch_array($queryUsersList, MYSQLI_ASSOC))
                {
                    if ($array['status'] == 'user')
                    { $usersList[$array['id']] = $array; }
                }
            }
            return $usersList;
        }

        public function userEdit()
        {
            $this->update("users","department_full = '{$_POST['department_full']}', department_short = '{$_POST['department_short']}', type = '{$_POST['type']}', room = '{$_POST['room']}', phone = '{$_POST['phone']}', login = '{$_POST['login']}', password = '{$_POST['password']}'","id = '{$_POST['id']}'");
            header("Location: /?page=users_list");
        }

        public function userDelete()
        {
            $this->delete("users","id = '{$_POST['id']}'");
            header("Location: /?page=users_list");
        }

    }