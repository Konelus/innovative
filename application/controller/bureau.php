<?php
/**
 * @var array $currentUser
 * @var string $previousDir
 */

	class bureau
	{

		private string $previousDir = '';
		private array $currentUser = [];
		private object $Orders;

		public function __construct()
		{
			$this->previousDir =  dirname(__DIR__, 1);
			require_once $this->previousDir.'/model/bureau/orders.php';
			$this->Orders = new orders;
		}

		public function setCurrentUser($currentUser): void
		{
			$this->currentUser = $currentUser;
			$this->pageRequest();
		}

		protected function pageRequest(): void
		{
			/** Главная страница модуля общежития */
			if (!$_GET['page'] && ($this->currentUser != '')) {
				if ($this->currentUser['status'] == 'user') {
					header("Location: /?page=order_create");
				}
				else {
					header("Location: /?page=orders_list&show=waiting");
				}
			}
		}

		/** Вся работа с заявками */
		protected function orders(): void
		{
			/** Вызов метода создания заявки */
			if ($_POST['order_create']) {
				$orderNum = $this->Orders->orderCreate();
			}
			/** Работа со списком заявок */
			elseif ($_GET['page'] == 'orders_list') {
				$this->ordersMainSort();
				$this->orderList();
			}
			/** Удаление пропуска */
			elseif ($_POST['pass_remove']) {
				$this->Orders->passRemove();
			}
		}

		/**  */
		protected function orderList(): void
		{


			list($ordersList, $recordsCount) = $this->Orders->ordersList();
			$ordersCount = $this->Orders->statistics();
			if ($_POST['order-edit']) {
				$this->orderEdit();
			}
			elseif ($_POST['pass-create']) {
				$this->Orders->passCreate();
			}
		}

		/** Сортировка заявок по умолчанию + сброс сортировки */
		protected function ordersMainSort():void
		{
			if (!$_GET['show']) {
				$_GET['show'] = 'waiting';
			}
			if ($_POST['order-search']['refresh']) {
				header("Location: /?page=orders_list&show={$_GET['show']}");
			}
		}

		protected function orderEdit(): void
		{
			$lastOrders = $this->Orders->visitorLastOrders();
			if ($lastOrders != null) {
				$modalWidth = 'modal-lg';
				foreach ($lastOrders as $key => $value) {
					$lastOrders[$key]['check-status'] = $lastOrders[$key]['label-status'] = '';
					if ($value['status'] == '') {
						$lastOrders[$key]['check-status'] = 'checked';
					}
					else {
						$lastOrders[$key]['label-status'] = 'missed';
					}
				}
			}
			else {
				$modalWidth = 'modal-md';
			}
		}
	}



    if ((($_GET['page'] == 'order_create') || ($_GET['page'] == 'orders_list') || ($_GET['page'] == 'pass_rem')) && ((!$_POST['authorization']) && (!$_POST['exit'])))
    {

    }



    /** Настройки модуля */
    $module['title'] = "Pass Office<sup>©</sup> - заказ и выдача пропусков";


    /** Внешняя часть страницы orders_list */
    if ($_GET['page'] == 'orders_list')
    {
        if ($currentUse['status'] != 'user')
        {
            /** Категория поиска */
            if (($_POST['order-search']) && (!$_POST['order-search']['refresh']))
            {
                $searchType = array();
                $searchType[$_POST['order-search']['type']] = 'selected';
            }

            /** Тип отображаемых заявок */
            $showBtn['all'] = $showBtn['completed'] = $showBtn['waiting'] = 'btn-secondary';
            $showBtn[$_GET['show']] = 'btn-info';
        }

        /** Номер страницы по умолчанию */
        if ((!$_GET['number']) || ($_GET['number'] == '')) { $_GET['number'] = 1; }
        else { $_GET['number'] = (int) $_GET['number']; }

        /** Выбранный номер страницы */
        if ($recordsCount > 50)
        {
            for($pageNumber = 1; $pageNumber <= count($ordersList); $pageNumber++)
            {
                if ($_GET['number'] == $pageNumber) { $pageList[$pageNumber] = 'btn-info'; }
                else { $pageList[$pageNumber] = 'btn-dark'; }
            }
        }
    }


    /** Внешняя часть страницы order_create */
    elseif ($_GET['page'] == 'order_create')
    {
        if ($currentUser['status'] == 'user')
        {
            $infoText = 'Внимание! Все пропуска выдаются в <b>Бюро Пропусков</b>!';
            $successText = "Заявка <b>bp_$orderNum</b> успешно создана!";
            $btnText = 'Создать заявку';
        }
        else
        {
            $infoText = 'Форма ручного добавления пропусков в систему';
            $successText = "Пропуск <b>bp_$orderNum</b> успешно создан!";
            $btnText = 'Создать пропуск';
        }
    }


