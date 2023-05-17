<?php
/**
 * User: Konel
 * Date: 25.10.2022
 * Time: 22:43
 */

    abstract class abstractOrders extends kernel
    {
        abstract protected function executor();
        abstract public function orderCreate();
        abstract public function ordersList();
        abstract public function passCreate();
        abstract public function passRemove();
        abstract public function statistics();
        abstract public function visitorLastOrders();
    }

    class orders extends abstractOrders
    {

        public function __construct()
        {
            parent::__construct();
            if ($_POST) { $_POST = $this->preQuery($_POST); }
        }

        protected function executor()
        {
            if ($_POST['key'] != '')
            {
                list(, $ip ,,) = explode(".", $_SERVER['HTTP_X_FORWARDED_FOR']);
                if ($ip == '98') { $executor = 2; } else { $executor = 1; }
            }
            else { $executor = 0; }
            return $executor;
        }

        public function orderCreate()
        {
            $executor = $this->executor();
            $_POST['key'] = $this->translation($_POST['key']);

            $this->insert("orders","null, '$this->date', '$this->time', '{$_POST['fio']}', '{$_POST['type']}', '{$this->currentUser['id']}', '{$_SERVER['HTTP_X_FORWARDED_FOR']}', '{$_POST['comment']}', $executor, '{$_POST['key']}'");
            $queryOrderID = implode(mysqli_fetch_row($this->select("max(id)","orders","","id DESC")));
            
            if ($_POST['key'] != '')
            {
                $variables = ['id' => 'bp_'.$queryOrderID, 'date' => $this->date, 'fio' => $_POST['fio'], 'comment' => $_POST['comment'], 'key' => $_POST['key']];
				$this->remoteAccess('10.37.0.20/functions/pass_create.php', $variables);
            }

            return ($queryOrderID);
        }

        public function ordersList()
        {
            if ($this->currentUser['status'] == 'user') { $where = "users.id = '{$this->currentUser['id']}' AND orders.author = '{$this->currentUser['id']}'"; }
            else
            {
                $where = "date = '$this->date' AND users.id = orders.author";

                if (($_POST['order-search']) && (!$_POST['order-search']['refresh']))
                {
                    $searchValue = trim($_POST['order-search']['value']);
                    $where .= " AND orders.{$_POST['order-search']['type']} LIKE '%$searchValue%'";
                }
                elseif ($_POST['order-search']['refresh']) { $_POST['order-search'] = array(); }

                if ((!$_GET['show']) || ($_GET['show'] == '')) { $_GET['show'] = 'waiting'; }
                switch ($_GET['show'])
                {
                    case 'waiting': $where .= " AND executor = 0"; break;
                    case 'completed': $where .= " AND executor != 0"; break;
                }
            }

            $ordersList = $this->select("orders.visitor as fio, orders.visitor_type as type, users.department_full as department, users.room as room, orders.date as date, orders.time as time, orders.comment as comment, orders.id as id, orders.executor as executor","users, orders","$where", 'orders.id DESC','1000');

            $orders = array();
            $count['pages'] = 1;
            $count['records'] = 0;

            if ($ordersList->num_rows != 0)
            {
                while ($array = mysqli_fetch_array($ordersList, MYSQLI_ASSOC))
                {
                    $count['records']++;

                    $orders[$count['pages']][$array['id']]['fio'] = $array['fio'];
                    $orders[$count['pages']][$array['id']]['type'] = $array['type'];

                    switch ($array['type'])
                    {
                        case 'Студент': $orders[$count['pages']][$array['id']]['selected-type'][0] = 'selected'; break;
                        case 'Выпускник': $orders[$count['pages']][$array['id']]['selected-type'][1] = 'selected'; break;
                        case 'Сотрудник': $orders[$count['pages']][$array['id']]['selected-type'][2] = 'selected'; break;
                        case 'Гость': $orders[$count['pages']][$array['id']]['selected-type'][3] = 'selected'; break;
                    }

                    $orders[$count['pages']][$array['id']]['department'] = $array['department'];
                    $orders[$count['pages']][$array['id']]['room'] = $array['room'];

                    list($year, $month, $day) = explode("-", $array['date']);
                    $orders[$count['pages']][$array['id']]['date'] = $day.'.'.$month.'.'.$year;
                    $orders[$count['pages']][$array['id']]['time'] = $array['time'];
                    $orders[$count['pages']][$array['id']]['comment'] = $array['comment'];
                    $orders[$count['pages']][$array['id']]['order'] = 'bp_'.$array['id'];
                    $orders[$count['pages']][$array['id']]['executor'] = $array['executor'];

                    if (($array['date'] != date("Y-m-d")) && ($array['executor'] == '0'))
                    { $orders[$count['pages']][$array['id']]['status'] = 'bg-danger'; }
                    elseif ($array['executor'] != '0')
                    { $orders[$count['pages']][$array['id']]['status'] = 'bg-success'; }
                    else { $orders[$count['pages']][$array['id']]['status'] = 'bg-light'; }

                    if ($count['records'] % 50 == 0) { $count['pages']++; }
                }
            }

            return array($orders, $count['records']);
        }

        public function passCreate()
        {
            $executor = $this->executor();
			$_POST['key'] = $this->translation($_POST['key']);
            
            $this->update("orders","visitor = '{$_POST['fio']}', visitor_type = '{$_POST['type']}', cart_key = '{$_POST['key']}', executor = '$executor'","id = '{$_POST['id']}'");
            
            $variables = ['id' => $_POST['order-num'], 'room' => $_POST['room'], 'department' => $_POST['department'], 'date' => $this->date, 'fio' => $_POST['fio'], 'comment' => $_POST['comment'], 'key' => $_POST['key']];
            $this->remoteAccess('10.37.0.20/functions/pass_create.php', $variables);

            header("Location: /?page=orders_list&number={$_GET['number']}&show={$_GET['show']}");
        }

        public function passRemove()
        {
            $this->update("orders","cart_key = ''","cart_key = '{$_POST['pass_remove']}'");
			
            $variables['key'] = $this->translation($_POST['pass_remove']);
			$this->remoteAccess('10.37.0.20/functions/pass_rem.php', $variables);
        }

        public function statistics()
        {
            $ordersCount = $query = array();

            $query['waiting'] = $this->select("COUNT(id)","orders","executor = 0 AND date = '$this->date'");
            $query['completed'] = $this->select("COUNT(id)","orders","executor != 0 AND date = '$this->date'");

            foreach ($query as $key => $value)
            {
                if ($value->num_rows != 0) { $ordersCount[$key] = implode(mysqli_fetch_row($value)); }
                else { $ordersCount[$key] = 0; }
            }

            if ($this->currentUser['status'] == 'admin')
            {
                $query = array();
                $beforeDate = date("Y-m-d", strtotime("-1 weeks"));

                $query['weak-total'] = $this->select("COUNT(id)","orders","date BETWEEN '$beforeDate' AND '$this->date'");
                $query['weak-completed'] = $this->select("COUNT(id)","orders","date BETWEEN '$beforeDate' AND '$this->date' AND executor != 0");
                $query['weak-user-first'] = $this->select("COUNT(id)","orders","date BETWEEN '$beforeDate' AND '$this->date' AND executor = 1");
                $query['today-user-first'] = $this->select("COUNT(id)","orders","date = '$this->date' AND executor = 1");
                $query['year-user-first'] = $this->select("COUNT(id)","orders","year(date) = year('$this->date') AND executor = 1");
                $query['weak-user-second'] = $this->select("COUNT(id)","orders","date BETWEEN '$beforeDate' AND '$this->date' AND executor = 2");
                $query['today-user-second'] = $this->select("COUNT(id)","orders","date = '$this->date' AND executor = 2");
                $query['year-user-second'] = $this->select("COUNT(id)","orders","year(date) = year('$this->date') AND executor = 2");
                $query['total-missed'] = $this->select("COUNT(id)","orders","date != '$this->date' AND executor != 0 AND cart_key != ''");

                foreach ($query as $key => $value)
                {
                    if ($value->num_rows != 0) { $ordersCount[$key] = implode(mysqli_fetch_row($value)); }
                    else { $ordersCount[$key] = 0; }
                }
                $ordersCount['year-all-users'] = $ordersCount['year-user-first'] + $ordersCount['year-user-second'];
            }

            return $ordersCount;
        }

        public function visitorLastOrders()
        {
            $orderID = key($_POST['order-edit']);
            $sql['visitor'] = $this->select("visitor","orders","id = '$orderID'");
            $visitor = implode(mysqli_fetch_row($sql['visitor']));

            $lastOrders = array();
            $sql['last-orders'] = $this->select("id, cart_key as status","orders","visitor = '$visitor' AND date != '$this->date'","id DESC");
            if ($sql['last-orders']->num_rows != 0)
            {
                while($array = mysqli_fetch_array($sql['last-orders'], MYSQLI_ASSOC))
                { $lastOrders[$array['id']]['status'] = $array['status']; }
            }

            return $lastOrders;
        }
    }