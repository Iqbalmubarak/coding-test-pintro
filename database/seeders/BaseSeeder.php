<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id'=>'1',
                'slug' 		    => 'admin',
                'name' 			  => 'Admin',
                'permissions'    => '{
                    "user.*" : true,
                    "product.*" : true,
                    "unit.*" : true,
                    "inventory.*" : true,
                    "supplier.*" : true,
                    "inventoryDetail.*" : true,
                    "outInventory.*" : true
                }'
            ],
            [
                'id'=>'2',
                'slug' 		    => 'employee',
                'name' 			  => 'Employee',
                'permissions'    => '{
                    "product.index" : true,
                    "unit.index" : true,
                    "inventory.*" : true,
                    "supplier.*" : true,
                    "inventoryDetail.*" : true,
                    "outInventory.*" : true
                }'
            ]
        ]);

        DB::table('products')->insert([
            [
                'name' 			  => 'Kertas HVS'
            ],
            [
                'name' 			  => 'Pensil'
            ]
        ]);

        DB::table('units')->insert([
            [
                'name' 			  => 'lusin'
            ]
        ]);

        DB::table('suppliers')->insert([
            [
                'name' 			  => 'pintro'
            ]
        ]);
    }
}
