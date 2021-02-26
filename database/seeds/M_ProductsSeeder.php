<?php

use Illuminate\Database\Seeder;

class M_ProductsSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      DB::table('m_products')->insert([
         'id' => 1,
         'product_name' => '黒毛和牛サーロイン',
         'category_id' => 1,
         'price' => 8000,
         'description' => 'なめらかでとろける食感と、甘くコクがある上品な香りが特徴です',
         'sale_status_id' => 1,
         'product_status_id' => 1,
         'resist_date' => date('Y-m-d H:i:s'),
         'user_id' => 1,
         'delete_flag' => ''
      ]);
      DB::table('m_products')->insert([
         'id' => 2,
         'product_name' => 'A5ランク松坂牛',
         'category_id' => 1,
         'price' => 12000,
         'description' => '松坂牛は濃厚で上品な甘みが絶品！',
         'sale_status_id' => 1,
         'product_status_id' => 1,
         'resist_date' => date('Y-m-d H:i:s'),
         'user_id' => 1,
         'delete_flag' => ''
      ]);
      DB::table('m_products')->insert([
         'id' => 3,
         'product_name' => 'フィレステーキ',
         'category_id' => 1,
         'price' => 5000,
         'description' => '老若男女問わず選ばれる柔らかさのフィレステーキです',
         'sale_status_id' => 1,
         'product_status_id' => 1,
         'resist_date' => date('Y-m-d H:i:s'),
         'user_id' => 1,
         'delete_flag' => ''
      ]);
      DB::table('m_products')->insert([
         'id' => 4,
         'product_name' => '越前ガニ',
         'category_id' => 2,
         'price' => 6000,
         'description' => '食べ応え抜群で身がぎっしり！',
         'sale_status_id' => 1,
         'product_status_id' => 1,
         'resist_date' => date('Y-m-d H:i:s'),
         'user_id' => 2,
         'delete_flag' => ''
      ]);
      DB::table('m_products')->insert([
         'id' => 5,
         'product_name' => '特選いくら',
         'category_id' => 2,
         'price' => 4000,
         'description' => '一粒一粒に旨味が凝縮された贅沢な一品',
         'sale_status_id' => 1,
         'product_status_id' => 1,
         'resist_date' => date('Y-m-d H:i:s'),
         'user_id' => 2,
         'delete_flag' => ''
      ]);
   }
}
