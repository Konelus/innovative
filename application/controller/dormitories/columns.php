<?php

	class Columns extends DormController
	{
		private array $columns = [];
		protected array $roomersColumns = [];


		public function getRoomersColumns(): array
		{
			$this->roomersColumns();
			return $this->roomersColumns;
		}


		/** Формирование списка столбцов */
		protected function roomersColumns(): void
		{

			$this->columnsList();

			if ($_GET['dormitory'])
			{
				$this->mainSort();
				$this->columnsSorting();
			}
			else {
				$this->roomersColumns = $this->columns;
			}
		}

		/** Список столбцов таблицы */
		private function columnsList(): void
		{
			if ($_GET['page'] == 'cit_list') {
				$this->columns = ['fio' => ['name' => 'ФИО'], 'id' => ['name' => 'Таб. номер'], 'status' => ['name' => 'Статус'], 'room' => ['name' => '№ комнаты'], 'last-date' => ['name' => 'Активность']];
			}
			elseif ($_GET['page'] == 'cit_appear_list') {
				$this->columns = ['fio' => ['name' => 'ФИО'], 'room' => ['name' => '№ комнаты'], 'last-date' => ['name' => 'Дата']];
			}
		}

		/** Базовая сортировка таблицы */
		private function mainSort(): void
		{
			if (!$_GET['sort']) {
				$_GET['sort'] = 'fio';
			}

			if (!$_GET['sort-type']) {
				$_GET['sort-type'] = 'ASC';
			}
		}

		/** Создание ссылки для сортировки записей в таблице */
		private function columnsSorting(): void
		{
			foreach ($this->columns as $key => $value)
			{
				if ($_GET['sort'] == $key)
				{
					$sortType = '';
					switch ($_GET['sort-type'])
					{
						case 'ASC': $sortType = "DESC"; break;
						case 'DESC': $sortType = 'ASC'; break;
					}
					$this->roomersColumns[$key]['link'] = "?page={$_GET['page']}&dormitory={$_GET['dormitory']}&sort={$_GET['sort']}&sort-type={$sortType}";
				}
				else {
					$this->roomersColumns[$key]['link'] = "?page={$_GET['page']}&dormitory={$_GET['dormitory']}&sort={$key}&sort-type=ASC";
				}
			}
		}
	}