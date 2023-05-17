<?php
/**
 * User: Konel
 * Date: 25.10.2022
 * Time: 18:25
 */

    abstract class abstractMain extends kernel
    {
        abstract public function copyrightYear();
        abstract public function navigation();
        abstract public function login();
        abstract public function logout();
    }

    class main extends abstractMain
    {
        const RELEASE = 2022;
        public $copyrightYear;

        public function __construct()
        {
            parent::__construct();

            $this->copyrightYear();
            if ($_COOKIE['user'])
            { $this->navigation(); }
        }

        public function copyrightYear()
        {
            if (date("Y") > $this::RELEASE) { $this->copyrightYear = $this::RELEASE." - ".date("Y"); }
            else { $this->copyrightYear = $this::RELEASE; }
        }

        public function navigation()
        {
            $pagesList = $this->select("name, translation", "pages","module = '{$this->currentUser['module']}' AND {$this->currentUser['status']} = 1");
            if ($pagesList->num_rows != 0)
            {
                while ($array = mysqli_fetch_array($pagesList, MYSQLI_ASSOC))
                { $this->currentUser['navigation'][$array['name']] = $array['translation']; }
            }
        }

        public function login()
        {
            $_POST = $this->preQuery($_POST);

            $loginQuery = $this->select("id","users","login = '{$_POST['login']}' AND password = '{$_POST['password']}'");
            if ($loginQuery->num_rows != 0)
            {
                setcookie('user', implode(mysqli_fetch_row($loginQuery)));
                header("Location: /");
            }
        }

        public function logout()
        {
            setcookie("user","",time()-3600);
            header("Location: /");
        }

    }