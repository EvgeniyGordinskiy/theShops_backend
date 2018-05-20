<?php

namespace App\Services\Console\Commands;

use App\Contracts\Seeder\SeederInterface;
use App\Services\DB\DB;

class Commands
{
	public function migrate($class = '')
	{
		$path = config('app','migrations_path');
		$migrations = scandir($path);
		if($class) {
			$file = basename($class, '.php').'.php';
			if(in_array($file, $migrations)	&& is_file($path.DIRECTORY_SEPARATOR.$file)){
				$this->migrateFile($path, $file);
			} else {
				fwrite(STDOUT, "\033[31m file ". $path.DIRECTORY_SEPARATOR.$file . ' is not found' . PHP_EOL);
				fwrite(STDOUT, "\033[0m " . PHP_EOL);
			}
		} else {
			foreach ($migrations as $migration) {
				if (is_file($path.DIRECTORY_SEPARATOR.$migration)) {
					$this->migrateFile($path, $migration);
				}
			}
		}
	}

	public function seed($class = '')
	{
		$path = config('app','seeds_path');
		$seeds = require ($path.DIRECTORY_SEPARATOR.'OrderDatabaseSeeder.php');
		if($class) {
			$file = basename($class, '.php').'.php';
			if(in_array($file, $seeds)	&& is_file($path.DIRECTORY_SEPARATOR.$file)){
				$this->seedFile($path, $file);
			} else {
				fwrite(STDOUT, "\033[31m file ". $path.DIRECTORY_SEPARATOR.$file . ' is not found' . PHP_EOL);
				fwrite(STDOUT, "\033[0m " . PHP_EOL);
			}
		} else {
			foreach ($seeds as $seed) {
				$this->seedFile($path, $seed);
			}
		}
	}

	protected function checkMigration($migration) 
	{
		fwrite(STDOUT, "\033[0m $migration" . PHP_EOL);

		if (count(DB::select('show tables like "migrations"')) > 0) {
			$result = DB::select('select * from migrations where name = "' .$migration .'"');
			if (!count($result)) {
				return true;
			} else {
				fwrite(STDOUT, "\033[33m migration $migration all ready exist" . PHP_EOL);
				fwrite(STDOUT, "\033[0m " . PHP_EOL);
			}
		} elseif ($migration === '0_migrations.php') {
			return true;
		}
		return false;
	}
	
	protected function migrateFile($path, $migration)
	{
		if ( $this->checkMigration($migration) ) {

			$sql = trim( require "$path/$migration" );
			fwrite(STDOUT, "\033[0m begin migrating $migration" . PHP_EOL);
			DB::getState()->beginTransaction();
			try {
				$exec = DB::execute($sql);
				DB::execute('insert into migrations (name) values (?)', [$migration]);
				DB::getState()->commit();
			} catch (\Throwable $e) {
				fwrite(STDOUT, "\033[0m $e" . PHP_EOL);
				DB::getState()->rollBack();
				exit();
			}

			if ($exec) {
				fwrite(STDOUT, "\033[32m migrated $migration" . PHP_EOL);
				fwrite(STDOUT, "\033[0m " . PHP_EOL);
			} else {
				fwrite(STDOUT, "\033[31m unexpected error" . PHP_EOL);
			}
		}
	}
	
	protected function seedFile($path, $seed)
	{
		if (is_file($path . DIRECTORY_SEPARATOR . $seed)) {
			fwrite(STDOUT, "\033[0m begin to seed $seed" . PHP_EOL);
			try {
				$class = 'database\\seeds\\' . basename($seed, '.php');
				$object = new $class();
				if ($object instanceof SeederInterface) {
					$object->run();
				} else {
					fwrite(STDOUT, '\033[31m' . $path . DIRECTORY_SEPARATOR . $seed . ' must be an instance of SeederInterface' . PHP_EOL);
					exit();
				}
				fwrite(STDOUT, "\033[32m Seeded $seed" . PHP_EOL);
				fwrite(STDOUT, "\033[0m " . PHP_EOL);
			} catch (\Throwable $e) {
				fwrite(STDOUT, "\033[31m Error: " . $e->getMessage() . PHP_EOL);
				fwrite(STDOUT, "\033[0m $e" . PHP_EOL);
				exit();
			}
		}
	}
}