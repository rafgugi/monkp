<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Lecturer as Dosen;

class UserTableSeeder extends Seeder {

	/**
	 * Create admin user and lecturer users.
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
				'personable_id' => Dosen::where('nip', '0')->first()->id,
				'personable_type' => 'lecturer',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			]);
		User::create([
				'username' => 'tu',
				'password' => bcrypt('tu'),
				'personable_id' => Dosen::where('nip', '0')->first()->id,
				'personable_type' => 'lecturer',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			]);

		$dosens = Dosen::whereNotIn('nip', ['0', '1'])->get();
		foreach ($dosens as $dosen) {
			User::create([
					'username' => $dosen['nip'],
					'password' => bcrypt($dosen['nip']),
					'personable_id' => $dosen->id,
					'personable_type' => 'lecturer',
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
				]);
		}
	}

}
