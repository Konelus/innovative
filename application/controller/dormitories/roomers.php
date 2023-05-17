<?php
/**
 * @var array $currentUser
 */

	class Dorm extends DormController
	{
		protected array $roomers = [];


		public function getRoomers(): array
		{
			$this->roomers();
			return $this->roomers;
		}

		protected function roomers(): void
		{
			if ($_GET['page'] == 'cit_list') {
				list($this->roomers['citizens'], $this->roomers['roomersCount']) = $this->Dorm->roomersList();
			}
			elseif ($_GET['page'] == 'cit_appear_list') { $this->roomers['misses'] = $this->Dorm->roomersMissing(); }
		}

	}