<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MCategory extends Model
{
    // m_categoriesテーブルから::pluckでcategory_nameとidを抽出
    public static function categoryList()
    {
        return self::pluck('category_name', 'id');
    }
    // リレーション関係の定義
    public function products()
    {
        return $this->hasMany(MProduct::class);
    }
}
