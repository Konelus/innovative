<?php

/**
 * User: Konel
 * Date: 22.12.2022
 * Time: 21:34
 */

    abstract class abstractReports extends kernel
    {
        abstract public function single();
    }

    class reports extends abstractReports
    {
        private $weekdays = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота'];

        public function __construct()
        {
            parent::__construct();
            if ($_POST) { $_POST = $this->preQuery($_POST); }
        }

        public function single()
        {



            for ($currentDate = new DateTime($_POST['date-1']); $currentDate->format('Y-m-d') <= $_POST['date-2']; $currentDate->modify('+1 day'))
            {
                if ($this->weekdays[date('w', strtotime($currentDate->format("Y-m-d")))] != '')
                { $result[$currentDate->format("Y-m-d")]['record-1'] = $result[$currentDate->format("Y-m-d")]['record-2'] = array(); }
            }

            if ($_POST['add'] || $_POST['edit'] || $_POST['del'])
            {
                $variables['action'] = key($_POST);
                $variables['id'] = key(current($_POST));
                $variables['date'] = $_POST;
            }

			$variables['fio'] = $_POST['fio'];
			list($userInfo['id'], $userInfo['fio'], $userInfo['department'], $userInfo['position'], $userInfo['rotes'], $userInfo['birthday'], $userInfo['phone']) = explode(';', $this->remoteAccess('http://10.37.0.20/functions/user_info.php', $variables));

            $variables = ['fio' => $_POST['fio'], 'date-1' => $_POST['date-1'], 'date-2' => $_POST['date-2']];
            $preSingleReport = $this->remoteAccess('http://10.37.0.20/functions/single_report.php');
			$singleReportTemp = explode('\t', $preSingleReport, $variables);

            if ($_POST['download'])
            {
                $reportDate = date("Y-m-d");
                $preSingleReport = str_replace("\\t","","$preSingleReport");
                file_put_contents(__DIR__."/files/report_activity_{$userInfo['fio']}_$reportDate.csv","$preSingleReport");
            }

            foreach ($singleReportTemp as $key => $value)
            {
                $dailyValue[$key] = explode('\r\n', $value);
                list($singleReport[$key]['record-1']['date'], $singleReport[$key]['record-1']['time'], $singleReport[$key]['record-1']['place']) = explode(';', $dailyValue[$key][0]);
                list($singleReport[$key]['record-2']['time'], $singleReport[$key]['record-2']['time'], $singleReport[$key]['record-2']['place']) = explode(';', $dailyValue[$key][1]);

                if ($singleReport[$key]['record-1']['date'] != null) { $date[$key] = $singleReport[$key]['record-1']['date']; }
                elseif ($singleReport[$key]['record-2']['date'] != null) { $date[$key] = $singleReport[$key]['record-2']['date']; }

                if (($date[$key] != '') && ($this->weekdays[date('w', strtotime($date[$key]))] != '')) 
				{ $result[$date[$key]] = $singleReport[$key]; }
            }

            foreach ($result as $key => $value)
            {
                list($year, $month, $day) = explode('-', $key);
                $result[$key]['date'] = "$day.$month.$year";
                $result[$key]['weekday'] = $this->weekdays[date('w', strtotime($key))];

                if (($value['record-1'] == null) && ($value['record-2'] == null))
                { 
					if (date('w', strtotime($key)) != 6){ $result[$key]['row'] = 'table-danger'; }
					else { $result[$key]['row'] = 'table-info'; }
				}

                for ($count = 1; $count <= 2; $count++)
                {
                    if ($value["record-$count"]['time'] == null)
                    {
						if (date('w', strtotime($key)) != 6) { $result[$key]["record-$count"]['col'] = 'table-danger'; }
						else { $result[$key]["record-$count"]['col'] = 'table-info'; }
                        $result[$key]["record-$count"]['time'] = $result[$key]["record-$count"]['place'] = '<br>';
                    }
                }
            }

            return array($userInfo, $result, $userInfo['fio'], $reportDate);
        }
    }