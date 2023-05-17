<?php

	class Labels extends DormController
	{
		protected int $dormitoriesQuantity = 1;
		protected string $dormitoryNumLabel = '';


		public function getDormNum(): int
		{
			$this->dormNum();
			return $this->dormitoriesQuantity;
		}

		public function getDormLabel(): string
		{
			echo '2';
			$this->dormLabel();
			return $this->dormitoryNumLabel;
		}


		/** Формирование номера [выбранного] общежития  */
		protected function dormNum(): void
		{
			if ($this->currentUser['status'] != 'admin') { $_GET['dormitory'] = $this->currentUser['type']; }
			else
			{

				$this->dormitoriesQuantity = $this->Dorm->dormitoriesQuantity;
				pre($this->dormitoriesQuantity);
			}
			pre($this->dormitoriesQuantity);
		}

		/** Вывод номера [выбранного] общежития */
		protected function dormLabel(): void
		{
			if ($_GET['dormitory']) {
				$this->dormitoryNumLabel = "Общежитие № {$_GET['dormitory']}";
			}
			else
			{
				$this->dormitoryNumLabel = 'Номер общежития';
			}
		}
	}