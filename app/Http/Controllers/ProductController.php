<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\MProduct;
use App\MCategory;


class ProductController extends Controller
{
    /*==================================
    検索フォームのみ表示(show)
    ==================================*/
    public function index(Request $request)
    {
        //フォームを機能させるために各情報を取得し、viewに返す
        $category = new MCategory;
        $categories = $category->getCategories();
        $searchWord = $request->input('searchWord');
        $categoryId = $request->input('categoryId');

        return view('searchproduct', [
            'categories' => $categories,
            'searchWord' => $searchWord,
            'categoryId' => $categoryId
        ]);
    }
    /*==================================
    検索メソッド(searchproduct)
    ==================================*/
    public function search(Request $request)
    {
        //入力される値value="{{ }}"の中身を定義する
        $searchWord = $request->input('searchWord'); //商品名の値
        $categoryId = $request->input('categoryId'); //カテゴリの値

        $query = MProduct::query();
        //商品名が入力された場合、m_productsテーブルから一致する商品を$queryに代入
        if (isset($searchWord)) {
            $query->where('product_name', 'like', '%' . self::escapeLike($searchWord) . '%');
        }
        //カテゴリが選択された場合、m_categoriesテーブルからcategory_idが一致する商品を$queryに代入
        if (isset($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        //$queryをcategory_idの昇順に並び替えて$productsに代入
        $products = $query->orderBy('category_id', 'asc')->paginate(15);

        //m_categoriesテーブルからgetLists()関数でcategory_nameとidを取得する
        $category = new MCategory;
        $categories = $category->getCategories();

        return view('searchproduct', [
            'products' => $products,
            'categories' => $categories,
            'searchWord' => $searchWord,
            'categoryId' => $categoryId
        ]);
    }

    //XSS対策「\\」「%」「_」などの記号を文字としてエスケープさせる
    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
}
