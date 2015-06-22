<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		DB::table('users')->delete();
		User::create([
				'username' => 'koorkp',
				'password' => bcrypt('koorkp'),
				'name' => 'Koor KP',
				'personable_id' => 0,
				'personable_type' => 'admin',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			]);
	}

}
