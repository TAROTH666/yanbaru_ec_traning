<?php

namespace App\Http\Controllers;

use App\User;
use App\MProduct;
use App\MCategory;
use App\TOrder;
use App\TOrdersDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
  /*==================================
    商品をカートに入れるメソッド(iteminfo/id)
    ==================================*/
  //商品詳細画面でカートに商品と個数を入れる処理を実行
  public function addCart(Request $request)
  {
    $cartData = [
      'session_products_id' => $request->products_id,
      'session_quantity' => $request->product_quantity,
    ];
    //session情報にcartDataという連想配列が「無い」場合
    if (!$request->session()->has('cartData')) {
      //商品情報の配列 cartData(key名)に、$cartData(配列)をSessionに追加
      $request->session()->push('cartData', $cartData);
      //session情報にcartDataという連想配列が「有る」場合、情報取得
    } else {
      $sessionCartData = $request->session()->get('cartData');
      //flag定義 product_id同一確認フラグ = 同一ではない状態
      $flag = false;
      foreach ($sessionCartData as $index => $sessionData) {
        //product_idが同一であれば、フラグをtrueにする → 個数の合算処理、及びセッション情報更新。更新は一度のみ
        if ($sessionData['session_products_id'] === $cartData['session_products_id']) {
          $flag = true;
          $quantity = $sessionData['session_quantity'] + $cartData['session_quantity'];
          $request->session()->put('cartData.' . $index . '.session_quantity', $quantity);
          break;
        }
      }
      //product_idが同一ではない状態を指定 その場合であればpushする
      if ($flag === false) {
        $request->session()->push('cartData', $cartData);
      }
    }
    //POST送信された情報をsessionに保存 'users_id'(key)に$request内の'users_id'をセット
    $request->session()->put('users_id', ($request->users_id));
    return redirect()->route('cartlist');
  }

  public function index(Request $request)
  {
    //渡されたセッション情報をkey（名前）用いそれぞれ取得し変数に代入
    $cartData = $request->session()->get('cartData');
    $sessionUsersId = $request->session()->get('users_id');
    if (!empty($cartData)) {
      foreach ($cartData as &$data) {
        //二次元目の配列を指定している$dataに'product'というkeyを生成しそこに値として$productを代入
        $product = MProduct::with('category')->find($data['session_products_id']);
        $data['product'] = $product;
        $itemPrice = $data['product']->price * $data['session_quantity'];
        $data['itemPrice'] = $itemPrice;
      }
      //第二引数に指定したkeyの値を配列として変数に入れる
      $sessionProductsId = array_column($cartData, 'session_products_id');
      $sessionQuantity = array_column($cartData, 'session_quantity');

      //取得したidを元に各テーブルのカラムデータをDBから取得
      $sessionProducts = MProduct::find($sessionProductsId);
      $sessionUsers = User::find($sessionUsersId);
      $user = Auth::user();

      $cartQuantity = count($cartData);

      //Productテーブルに該当IDが存在しない場合、戻り値としてnullが返される → issetで条件分岐を指定し例外処理を行う
      return view('cartlist', compact('sessionUsers', 'cartData', 'totalPrice', 'user', 'cartQuantity'));
    } else {
      $user = Auth::user();
      return view('no_cart_list', compact('user'));
    }
  }
  /*==================================
    商品詳細画面
    ==================================*/
  public function show($id)
  {
    //itemDetail/{id}に該当するidを元に対応するproductを取得
    $product = MProduct::find($id);
    if (!empty($product)) {
      //productのcategory_idを取得し、Category.phpを経由し該当idが所有するカテゴリー名を取得する(リレーション)
      $category_name = MCategory::find($product->category_id);
      $user = Auth::user();
      return view('iteminfo', compact('product', 'category_name', 'user'));
    }
  }
  /*==================================
    カート内商品削除
    ==================================*/
  public function remove(Request $request)
  {
    //POST送信された情報をsessionに保存 'users_id'(key)に$request内の'users_id'をセット
    $sessionUsersId = $request->session()->get('users_id');
    //session情報の取得（product_idと個数の2次元配列）
    $sessionCartData = $request->session()->get('cartData');

    //削除ボタンから受け取ったproduct_idと個数を2次元配列に
    $removeCartItem = [
      [
        'session_products_id' => $request->product_id,
        'session_quantity' => $request->product_quantity
      ]
    ];
    $newCartData = array_udiff($sessionCartData, $removeCartItem, function ($sessionCartData, $removeCartItem) {
      $result1 = $sessionCartData['session_products_id'] - $removeCartItem['session_products_id'];
      $result2 = $sessionCartData['session_quantity'] - $removeCartItem['session_quantity'];
      return $result1 + $result2;
    });

    $request->session()->put('cartData', $newCartData);
    $cartData = $request->session()->get('cartData');

    if (!empty($cartData)) {
      return redirect()->route('cartlist');
    } else {
      $user = Auth::user();
      return view('no_cart_list', compact('user'));
    }
  }
  /*==================================
    注文完了画面 注文データベースに注文詳細情報を保存
    ==================================*/
  public function checkout(Request $request)
  {
    //カート内情報を取得
    $cartData = $request->session()->get('cartData');
    $now = Carbon::now();
    //t_ordersテーブルに接続したインスタンスを作り、id情報と注文日を入力する
    $order = new \App\TOrder;
    $order->user_id = Auth::user()->id;
    $order->order_date = $now;
    $order->save(); //↑の情報を保存する

    $savedOrder = TOrder::where('id', $order->id)->get();
    $savedOrderId = $savedOrder->pluck('id')->toArray();

    foreach ($cartData as $data) {
      $orderDetail = new \App\TOrdersDetail;

      $orderDetail->products_id = $data['session_products_id'];
      $orderDetail->order_id = $savedOrderId[0];
      $orderDetail->shipment_status_id = 1;
      $orderDetail->order_detail_number = rand();
      $orderDetail->order_quantity = $data['session_quantity'];
      $orderDetail->shipment_date = $now;
      $orderDetail->save();
    }
    //カート内情報を削除
    $request->session()->forget('cartData');

    return view('checkout', compact('orderDetail'));
  }
  /*==================================
  カート内商品の数を数える処理
  ==================================*/
  public function count(Request $request)
  {
    $cartData = $request->session()->get('cartData');
    $cartQuantity = count($cartData);
    return view('commons.header', compact('cartData', 'cartQuantity'));
  }
}
