@extends('layouts.app')

@section('content')
<main>

	<div class="container-fluid py-3">
		<div class="row col-12 justify-content-center m-0 h-100">
			<div class="col-12">
				@if (!$orderHistoryDetails->isEmpty())
				<!-- お届け先 -->
				<div class="col-12 py-3 px-3 border border-dark rounded">
					<h5 class="mb-0">
                                お届け先
                            </h5>
					<div class="px-3 py-1">
						<div class="col-12 row px-3">
							<div class="col-2"><span id="postal_code">〒{{ formatPostal($orderHistoryDetails[0]->zipcode) }}</span>
							</div>
							<div class="col-8" id="address">
								<span>{{ $orderHistoryDetails[0]->prefecture }}</span>
								<span>{{ $orderHistoryDetails[0]->municipality }}</span>
								<span>{{ $orderHistoryDetails[0]->address }}</span>
								<span>{{ $orderHistoryDetails[0]->apartments }}</span>
							</div>
						</div>
						<div class="col-12 row px-3">
							<div class="col-2"></div>
							<div class="col-8" id="name">
								{{ $orderHistoryDetails[0]->last_name }} {{$orderHistoryDetails[0]->first_name}}
								<span class="ml-1">様</span>
							</div>
						</div>
					</div>
				</div>
				<!-- 注文番号・注文状態 -->
				<div class="col-12 py-3 px-4">
					<div class="row">
						<div>
							注文番号：
						</div>
						<div id="order_number">
							{{ $orderHistoryDetails[0]->order_detail_number }}
						</div>
					</div>
					<div class="row">
						<div>
							発送状態：
						</div>
						<div id="current_order_status">
							{{$currentOrderStatus ?? ''}}
						</div>
					</div>
				</div>
				<!-- 注文キャンセルボタン -->
				<div class="col-12 text-right p-0">
					<button id="delete_btn" onclick="confirmDelete(
                                    {{$orderHistoryDetails[0]->id}},
                                    {{$orderHistoryDetails[0]->order_detail_number}}
                                )" class="btn btn-danger btn-sm">
						注文をキャンセルする
					</button>
				</div>

				<div class="mt-2">
					<table class="table border-bottom">
						<thead>
							<tr class="d-flex">
								<th scope="col" class="col-1 px-0 py-1 text-center">No</th>
								<th scope="col" class="col-2 px-0 py-1 text-center">商品名</th>
								<th scope="col" class="col-2 px-0 py-1 text-center">商品カテゴリ</th>
								<th scope="col" class="col-2 px-0 py-1 text-center">値段</th>
								<th scope="col" class="col-1 px-0 py-1 text-center">個数</th>
								<th scope="col" class="col-2 px-0 py-1 text-center">小計</th>
								<th scope="col" class="col-2 px-0 py-1 text-center"></th>
							</tr>
						</thead>
						<tbody class="" style="overflow-y:auto;max-height:400px;display:block">
							<?php $total = 0; ?>
							@foreach ($orderHistoryDetails as $key => $detail)
							<tr class="d-flex">
								<th scope="row" class="col-1 px-0 text-center">{{$key+1}}</th>
								<td class="col-2 px-0 text-center">{{ $detail->product_name }}</td><!-- 商品名 -->
								<td class="col-2 px-0 text-center">{{ $detail->category_name }}</td><!-- カテゴリ -->
								<td class="col-2 px-0 text-center">{{ $detail->price }}<span>円</span></td><!-- 値段 -->
								<td class="col-1 px-0 text-center">{{ $detail->order_quantity }}<span>個</span></td><!-- 個数 -->
								<td class="col-2 px-0 text-center">{{ $detail->sub_ttl }}<span>円</span></td>
								</td><!-- 小計 -->
								<td class="col-2 px-0 text-center">
									注文状態：<span id="order_status_1">{{ $detail->shipment_status_name }}</span><!-- 注文状態 -->
								</td><!-- 小計 -->
							</tr>
							<?php $total = $total + (int)$detail->sub_ttl ?>
							@endforeach
						</tbody>
					</table>
					<!-- 合計 -->
					<div class="col-12 row justify-content-end m-0 p-0">
						<div class="col-1 text-center px-0">合計</div>
						<div class="col-2 text-center px-0">{{ $total }}<span>円</span></div>
						<div class="col-2 text-center"></div>
					</div>
					<!-- ボタン -->
					<div class="col-12 row justify-content-end mt-3 p-0 no-gutters">
						{!! link_to_route('o_history', '注文履歴に戻る', [], ['class' => 'btn btn-info btn-sm']) !!}
					</div>
				</div>
				@else
				<div class="col-12 py-3 px-3 d-flex align-items-center justify-content-center">
					<div>
						<h4 class="col-12 text-center">該当の注文は見つかりませんでした。</h4>
						<h5 class="col-12 text-center">注文画面に戻り、やり直してください</h5>
						<!-- ボタン -->
						<div class="col-12 row justify-content-center mt-3 p-0 no-gutters">
							{!! link_to_route('o_history', '注文履歴に戻る', [], ['class' => 'btn btn-info btn-sm']) !!}
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>

</main>
<script>
	function confirmDelete(baseNumber, detailNumber) {
            let result = confirm('注文データを削除しますか？');
            if (result) {
                if (baseNumber && detailNumber) {
                    let base = '{!! route("delete_order") !!}';
                    let url = base+'?base_number='+baseNumber+'&detail_number='+detailNumber ;
                    window.location.href=url;
                }
            } else {
                return
            }
        }
</script>
@endsection