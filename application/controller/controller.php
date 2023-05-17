<?php

    function pre($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

	$previousDir = dirname(__DIR__, 1);

    require_once $previousDir.'/model/kernel.php';
    require_once $previousDir.'/model/main.php';
    $MAIN = new main;

    if (($_POST['authorization']) || ($_POST['exit']))
    {
        if ($_POST['authorization']) { $MAIN->login(); }
        elseif ($_POST['exit']) { $MAIN->logout(); }
    }

    if ($_COOKIE['user'])
    {
        $currentYear = $MAIN->copyrightYear;
        $currentUser = $MAIN->currentUser;

        $siteTitle = ' - '.$currentUser['navigation'][$_GET['page']];
    }

    if (($_GET['page'] == 'profile') || ($_GET['page'] == 'user_create') || ($_GET['page'] == 'users_list'))
    {
        require_once $previousDir.'/model/users.php';
        $USERS = new users;

        if ($_POST['profile_update'])
        { $USERS->profile($currentUser['id']); }
        elseif ($_POST['user_create'])
        { $userCheck = $USERS->userCreate(); }
        elseif ($_GET['page'] == 'users_list')
        {
            $usersList = $userCheck = $USERS->usersList($currentUser['module']);
            if ($_POST['user-edit-modal']) { $USERS->userEdit(); }
            elseif ($_POST['user-delete-modal']) { $USERS->userDelete(); }
        }
    }

    //if ($currentUser['module'] != '') { require_once(__DIR__ . "/controller.php"); }
    if (strlen($currentUser['module'])) { require_once(__DIR__."/{$currentUser['module']}/controller.php"); }