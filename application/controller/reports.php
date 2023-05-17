<?php
/**
 * User: Konel
 * Date: 09.12.2022
 * Time: 12:03
 */

    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/reports/reports.php";
    $REPORTS = new reports;

    /** Настройки модуля */
    $module['title'] = "Reports<sup>©</sup> - обработка данных и создание отчётов";

    if (($_GET['page'] == '') && ($currentUser != '') || ($currentUser['navigation'][$_GET['page']] == ''))
    { header("Location: /?page=single_report"); }

    if (($_GET['page'] == 'single_report') && (($_POST['create']) || ($_POST['download'])))
    {
        list($userInfo, $singleReport, $userFio, $reportDate) = $REPORTS->single();

        if ($_POST['download'])
        { header("Location: /temp/report_activity_{$userFio}_$reportDate.csv"); }
    }


