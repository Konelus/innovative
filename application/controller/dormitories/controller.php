<?php

/**
 * @var array $currentUser
 */

	require_once __DIR__.'/require.php';

	class DormController
	{
		protected array $currentUser;
		protected $Dorm;

		protected array $roomersColumns;
		protected array $roomers;
		protected array $labels;


		public function setCurrentUser($currentUser): void
		{
			$this->currentUser = $currentUser;
			$this->pageRequest();
		}

		public function setDorm($Dorm): void
		{
			$this->Dorm = $Dorm;
		}


		public function getDormColumns(): array
		{
			$this->dormColumns();
			return $this->roomersColumns;
		}

		public function getDormRoomers(): array
		{
			$this->dormRoomers();
			return $this->roomers;
		}

		public function getDormLabels(): array
		{
			$this->dormLabels();
			return $this->labels;
		}


		/** Главная страница модуля общежития */
		private function pageRequest(): void
		{
			if (!$_GET['page'] && ($this->currentUser != '') && !$_POST['dormitory-num']) {
				header("Location: /?page=cit_appear_list");
			}
			/** Выбран номер общежития */
			elseif ($_POST['dormitory-num']) {
				header("Location: /?page={$_GET['page']}&dormitory={$_POST['dormitory-num']}");
			}
		}

		/** Столбцы таблиц */
		public function dormColumns(): void
		{
			$DormColumns = new Columns();
			$this->roomersColumns = $DormColumns->GetRoomersColumns();
		}

		/** Жители общежития */
		public function dormRoomers(): void
		{
			$DormController = new Dorm();
			$this->roomers = $DormController->getRoomers($this->Dorm);
		}

		/** Надписи для вывода в виде */
		public function dormLabels(): void
		{
			$DormLabels = new Labels();
			$this->labels['dormitoriesQuantity'] = $DormLabels->getDormNum();
			$this->labels['dormitoryNumLabel'] = $DormLabels->getDormLabel();
		}

	}

	$DormController = new DormController;
	$DormController->setDorm($Dorm = new Dorm);
	$DormController->setCurrentUser($currentUser);

	$roomersColumns = $DormController->getDormColumns();
	$roomers = $DormController->getDormRoomers();
	$labels = $DormController->getDormLabels();

	/** Настройки модуля */
	$module['title'] = "Dormitory<sup>©</sup> - учёт и контроль студентов";