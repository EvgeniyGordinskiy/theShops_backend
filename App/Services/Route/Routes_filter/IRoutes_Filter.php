<?php
namespace App\Services\Route\Routes_filter;

interface IRoutes_Filter
{
	/**
	 * Creating pattern from routes url
	 * @param $url
	 * @return mixed
	 */
	public function url($url);

	/**
	 * Checking routes obj
	 * @param $obj
	 * @return mixed
	 */
	public function obj($obj);

	/**
	 * Checking routes version
	 * @param $version
	 * @return mixed
	 */
	public function version($version);

	/**
	 * Checking routes filter
	 * @param $filter
	 * @return mixed
	 */
	public function filter($filter);

	/**
	 * Checked routes beforeRoute
	 * @param $beforeRoute
	 * @return mixed
	 */
	public function beforeRoute($beforeRoute);

	/**
	 * Checked routes afterRoute
	 * @param $afterRoute
	 * @return mixed
	 */
	public function afterRoute($afterRoute);
}