<?php

/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 28.11.2022
 * Time: 23:01
 */

    require_once(__DIR__ . "/connection.php");

    abstract class abstractKernel extends connection
    {
        abstract protected function currentUserInfo();
        abstract protected function remoteAccess($address, $variables = '');
        abstract protected function preQuery($arr);
        abstract protected function translation($str = '');
    }

    class kernel extends abstractKernel
    {
        public $currentUser;
        protected $date, $time;

        protected function __construct()
        {
            parent::__construct();
            $this->date = date("Y-m-d");
            $this->time = date("H:i:s");

            if ($_COOKIE['user'])
            { $this->currentUserInfo(); }
        }

        protected function currentUserInfo()
        {
            $userInfo = $this->select("status, department_full, department_short, room, phone, module, type",'users',"id = {$_COOKIE['user']}");
            if ($userInfo->num_rows != 0)
            {
                $this->currentUser = mysqli_fetch_array($userInfo, MYSQLI_ASSOC);
                $this->currentUser['id'] = $_COOKIE['user'];

                if ($this->currentUser['type'] != '') { $this->currentUser['description'] = $this->currentUser['department_short'].' ('.$this->currentUser['type'].')'; }
                else { $this->currentUser['description'] = $this->currentUser['department_short']; }
            }
        }

        protected function remoteAccess($address, $variables = '')
        {
            $forwarding = '';

            if ($variables != '') { $forwarding = '?'.http_build_query($variables); }
            $cURL = curl_init();
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_URL, $address.$forwarding);
            $result = curl_exec($cURL);
            curl_close($cURL);

            return $result;
        }

        protected function preQuery($arr)
        {
            foreach ($arr as $key => $value)
            {
                if (!is_array($value))
                { $arr[$key] = htmlspecialchars($this->mysql->real_escape_string($value)); }
                else
                {
                    foreach ($value as $key2 => $value2)
                    {
                        if (!is_array($value2))
                        { $arr[$key][$key2] = htmlspecialchars($this->mysql->real_escape_string($value2)); }
                        else { break; }
                    }
                }
            }

            return $arr;
        }

        protected function translation($str = '')
        {
            $result = '';
            if ($str != '')
            {
                $array = array(
                    'й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r',
                    'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o',
                    'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's',
                    'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j',
                    'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z',
                    'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n',
                    'ь' => 'm', 'б' => ',', 'ю' => '.'
                );

                preg_match_all('#.{1}#uis', $str, $str_array);
                $parsed = $str_array[0];

                foreach ($parsed as $key => $value)
                {
                    foreach ($array as $key2 => $value2)
                    {
                        if (mb_strtoupper($value) == mb_strtoupper($key2))
                        { $parsed[$key] = mb_strtoupper($value2); }
                    }
                }
                $result = strtoupper(implode($parsed));
            }
            return $result;
        }
    }