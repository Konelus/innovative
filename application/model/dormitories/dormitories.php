<?php
/**
 * User: Konel
 * Date: 12.11.2022
 * Time: 22:59
 */

    abstract class abstractDormitories extends kernel
    {
        abstract public function roomersList();
        abstract public function roomersMissing();
    }

    class dormitories extends abstractDormitories
    {
        const SORTING = ['fio' => 'fio', 'id' => 'tabelnomer', 'status' => 'marsrut', 'room' => 'kkomu', 'last-date' => 'ldatekey'];

        private $dormitoryURL;
        public int $dormitoriesQuantity;

        public function __construct()
        {
            parent::__construct();
            if ($_POST) { $_POST = $this->preQuery($_POST); }

            $this->dormitoryURL = parse_ini_file(__DIR__ . "/dormitory_URL.ini");
            $this->dormitoriesQuantity = count($this->dormitoryURL);

            if ($_GET['dormitory'])
            {
                $_GET['dormitory'] = (int) $_GET['dormitory'];

                if ($this->dormitoryURL[$_GET['dormitory']] == '')
                { $_GET['dormitory'] = ''; }
            }
        }

        public function roomersList(): array
        {
            if (($_POST['block']) || ($_POST['unblock']))
            { $variables = ['action' => key($_POST), 'id' => key(current($_POST))]; }

            $variables['sort'] = self::SORTING[$_GET['sort']];
            $variables['sort-type'] = $_GET['sort-type'];
            $roomersListTemp = explode("\r\n", $this->remoteAccess($this->dormitoryURL[$_GET['dormitory']], $variables));

            $roomersList = $roomersCount = array();

            if ($roomersListTemp != null)
            {
                $roomersCount['all'] = count($roomersListTemp);
                $roomersCount['active'] = $roomersCount['blocked'] = 0;

                foreach ($roomersListTemp as $key => $value)
                {
                    list($roomersList[$key]['fio'], $roomersList[$key]['id'], $roomersList[$key]['roomer-status'], $roomersList[$key]['room'], $roomersList[$key]['last-date'], $roomersList[$key]['pass-status'], $roomersList[$key]['block-date']) = explode(";", $value);

                    list($date['year'], $date['month'], $date['day']) = explode(".", $roomersList[$key]['last-date']);
                    $roomersList[$key]['last-date'] = "{$date['day']}.{$date['month']}.{$date['year']}";

                    if (($roomersList[$key]['roomer-status'] != '2') && ($roomersList[$key]['roomer-status'] != '1'))
                    {
                        $roomersList[$key]['roomer-status'] = 'Активно';
                        $roomersList[$key]['status']['table'] = '';
                        $roomersList[$key]['status']['btn'] = 'btn-danger';
                        $roomersList[$key]['status']['btn-text'] = 'Заблокировать';
                        $roomersList[$key]['status']['btn-action'] = 'block';
                        $roomersCount['active']++;
                    }
                    else
                    {
                        $roomersList[$key]['roomer-status'] = 'Заблокировано';
                        $roomersList[$key]['status']['table'] = 'bg-danger';
                        $roomersList[$key]['status']['btn'] = 'btn-success';
                        $roomersList[$key]['status']['btn-text'] = 'Разблокировать';
                        $roomersList[$key]['status']['btn-action'] = 'unblock';
                        $roomersCount['blocked']++;

                        $roomersList[$key]['last-date'] .= "<br><b>{$roomersList[$key]['block-date']}</b>";
                    }

                    if (stripos($roomersList[$key]['room'],iconv("CP1251","UTF-8","нет")) !== false) { unset($roomersList[$key]); }
                }
            }

            return array($roomersList, $roomersCount);
        }

        public function roomersMissing(): array
        {
            $variables = ['sort' => self::SORTING[$_GET['sort']], 'sort-type' => $_GET['sort-type']];
            $roomersMissingListTemp = explode("\r\n", $this->remoteAccess($this->dormitoryURL[$_GET['dormitory']], $variables));

            $misses = array();

            if ($roomersMissingListTemp != null)
            {
                $constDate['date-1'] = strtotime(date("d.m.Y", strtotime("-1 day")));
                $constDate['date-2'] = strtotime(date("d.m.Y", strtotime("-3 day")));

                foreach ($roomersMissingListTemp as $key => $value)
                {
                    list($roomersMissingList[$key]['fio'], $roomersMissingList[$key]['id'], $roomersMissingList[$key]['roomer-status'], $roomersMissingList[$key]['room'], $roomersMissingList[$key]['last-date'], $roomersMissingList[$key]['pass-status'], $roomersMissingList[$key]['block-date']) = explode(";", $value);

                    list($year, $month, $day) = explode(".",$roomersMissingList[$key]['last-date']);
                    $date[$key]['date'] = "$day.$month.$year";
                    $date[$key]['time'] = strtotime($date[$key]['date']);

                    if (($date[$key]['time'] <= $constDate['date-1']) && ($date[$key]['time'] > $constDate['date-2']))
                    {
                        $misses['warning'][$key] = $roomersMissingList[$key];
                        $misses['warning'][$key]['last-date'] = $date[$key]['date'];
                    }
                    elseif ($date[$key]['time'] <= $constDate['date-2'])
                    {
                        $misses['danger'][$key] = $roomersMissingList[$key];
                        $misses['danger'][$key]['last-date'] = $date[$key]['date'];
                    }
                }
            }

            return $misses;
        }

    }