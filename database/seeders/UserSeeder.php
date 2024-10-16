<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User,Role,Permission,PermissionsUser};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::insert([
               [ 'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 12345678,
                'role_id' => '1'
        ],
        [ 'name' => 'Super Stokez',
        'email' => 'superstokez@gmail.com',
        'password' => 12345678,
        'role_id' => '2'
        ],
        [ 'name' => 'Stokez',
        'email' => 'stokez@gmail.com',
        'password' => 12345678,
        'role_id' => '3'
        ],
        [ 'name' => 'Agents',
        'email' => 'agents@gmail.com',
        'password' => 12345678,
        'role_id' => '4'
        ]
            ]);


            // Inserting multiple roles
        Role::insert([
            ['name' => 'Admin'],
            ['name' => 'Super Stokez'],
            ['name' => 'Stokez'],
            ['name' => 'Agents'],
            ['name' => 'Player'],
        ]);

        // Inserting multiple permissions
        Permission::insert([
            ['name' => 'View Super Stokez'],
            ['name' => 'Add Super Stokez'],
            ['name' => 'View Stokez'],
            ['name' => 'Add Stokez'],
            ['name' => 'View Agent'],
            ['name' => 'Add Agent'],
            ['name' => 'View Player'],
            ['name' => 'Add Player'],
            ['name' => 'Transfer Points'],
            ['name' => 'Adjust Points'],
            ['name' => 'Change Password'],
            ['name' => 'Player History'],
            ['name' => 'Transaction Report'],
            ['name' => 'Game Details'],
            ['name' => 'ID Password Change'],
            ['name' => 'Block/unblock'],
            ['name' => 'Assign Role'],
            ['name' => 'Result history'],
            ['name' => 'Instant win'],
            ['name' => 'Security'],
            ['name' => 'Sales Report'],
            ['name' => 'Revenue'],
            ['name' => 'limited Access'],
            ['name' => 'Stokez Setting'],
        ]);

        PermissionsUser::insert([
            ['role_id' => '1',
            'permissions_id' => '{"Admin":["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24"],"SuperStokez":["1","2","3","4","5","6","7","8"],"Stokez":["3","4","5","6","7","8"],"Agents":["5","6","7","8"]}'],

        ]);
    }
}
