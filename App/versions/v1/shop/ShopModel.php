<?php
namespace App\versions\v1\shop;

use App\Services\Model\Model;
use App\Services\DB\DB;


class ShopModel extends Model
{
	public static function getAll()
	{
		$sql = "select id, name, description, short_description from shops";
		$res = DB::select($sql);
		return $res;
	}
	
	public static function getShopById($id)
	{
		$sql = "select id, name, description, short_description from shops WHERE id = '$id'";
		$res = DB::select($sql);
		return $res[0];
	}


	public static function getShopsDay($day)
	{
		$sql = "select s.id, s.name, s.description, s.short_description
					from shops as s 
					JOIN schedules as sch on sch.shop_id = s.id
					JOIN  daysOfWeek as d on sch.day_of_week_id = d.id
					WHERE d.name = '$day'";
		return DB::select($sql);
	}
	
	public static function update($id, $name, $description, $short_description)
	{
		$sql = "
				update shops set
				 	name = ?,
				 	description = ?,
				 	short_description = ?
				 	where id = ?
		";

		DB::execute($sql, [$name, $description, $short_description, $id]);
		
		return self::getShopById($id);
	}
}