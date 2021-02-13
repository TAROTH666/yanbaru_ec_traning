<?php

use Illuminate\Database\Seeder;

class M_UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_users')->insert([
            'password' => bcrypt('sample1'),
            'last_name' => '坂本',
            'first_name' => '健',
            'zipcode' => '1111111',
            'prefecture' => '北海道',
            'municipality' => '札幌',
            'address' => '1-2-3',
            'apartments' => 'テナントA',
            'email' => 'example1@example.com',
            'phone_number' => '1111111111',
            'user_classification_id' => '1',
            'company_name' => '寿司処　柳',
            'delete_flag' => '0'
        ]);
        DB::table('m_users')->insert([
            'password' => bcrypt('sample1'),
            'last_name' => '宮代',
            'first_name' => '邦夫',
            'zipcode' => '2222222',
            'prefecture' => '熊本県',
            'municipality' => '熊本市',
            'address' => '1-2-3',
            'apartments' => 'テナントB',
            'email' => 'example2@example.com',
            'phone_number' => '2222222222',
            'user_classification_id' => '2',
            'company_name' => '宮代精肉店',
            'delete_flag' => '0'
        ]);

        DB::table('m_users')->insert([
            'password' => bcrypt('sample1'),
            'last_name' => '神田',
            'first_name' => '彩香',
            'zipcode' => '3333333',
            'prefecture' => '神奈川県',
            'municipality' => '横浜市',
            'address' => '1-2-3',
            'apartments' => 'CCビル1F',
            'email' => 'example3@example.com',
            'phone_number' => '3333333333',
            'user_classification_id' => '3',
            'company_name' => 'Cafe de normal',
            'delete_flag' => '0'
        ]);
    }
}
