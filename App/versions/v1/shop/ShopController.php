<?php
namespace App\versions\v1\shop;

use App\Services\Controller\BaseController;
use App\versions\v1\dayOfWeek\DayWeekModel;
use App\versions\v1\schedule\ScheduleModel;
use App\versions\v1\scheduleHistory\ScheduleHistoryModel;
use App\versions\v1\shop\ShopModel;

class ShopController extends BaseController
{
	/**
	 * This method fetches shops, filters by $data and/or $time
	 * 	and paginates by $limit and $page
	 *
	 * @param string $date
	 * @param string $time
	 * @param int $limit
	 * @param int $page
	 */
	public function index ($date = '', $time = '', $limit = 0, $page = 0)
	{
		$this->send(ScheduleHistoryModel::get_open_shops_by_the_date($date, $time, $limit, $page));
	}

	/**
	 * This method updates shop and shop's schedule by shop_id
	 *
	 * @param $id
	 * @param string $name
	 * @param string $description
	 * @param string $short_description
	 * @param string $sunday_start
	 * @param string $sunday_end
	 * @param string $monday_start
	 * @param string $monday_end
	 * @param string $tuesday_start
	 * @param string $tuesday_end
	 * @param string $wednesday_start
	 * @param string $wednesday_end
	 * @param string $thursday_start
	 * @param string $thursday_end
	 * @param string $friday_start
	 * @param string $friday_end
	 * @param string $saturday_start
	 * @param string $saturday_end
	 */
	public function update (
							 $id,
							string $name,
							string $description,
							string $short_description,
							string $sunday_start = '',
							string $sunday_end = '',
							string $monday_start = '',
							string $monday_end = '',
							string $tuesday_start = '',
							string $tuesday_end = '',
							string $wednesday_start = '',
							string $wednesday_end = '',
							string $thursday_start = '',
							string $thursday_end = '',
							string $friday_start = '',
							string $friday_end = '',
							string $saturday_start = '',
							string $saturday_end = ''
							)
	{

		$daysWeek = DayWeekModel::getDays();
		$newSchedule = [];

		foreach ($daysWeek as $day => $dayId) {
			$newSchedule[$day]['start'] = ${$day.ScheduleModel::SUFFIX_START};
			$newSchedule[$day]['end'] = ${$day.ScheduleModel::SUFFIX_END};
			$newSchedule[$day]['id'] = $dayId;
		}
		var_dump($newSchedule);
		$updatedShop             = ShopModel::update($id, $name, $description, $short_description);

		$updatedShop['schedule'] = ScheduleModel::update(intval($id), $newSchedule);
		
		$this->send($updatedShop);
	}
}