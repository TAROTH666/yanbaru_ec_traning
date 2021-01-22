@extends('layouts.app')

@section('content')

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12 card border-dark mt-5">
                    <div class="cord-body ml-3 mb-2">
                        <h4 class="mt-4">お届け先</h4>
                        <p class="mb-2" style="padding-left: 20px;">
                            〒
                            {{$sessionUsers->zipcode}}
                            {{$sessionUsers->prefecture}}
                            {{$sessionUsers->municipality}}
                            {{$sessionUsers->address}}
                            {{$sessionUsers->apartments}}
                        </p>
                        <p style="padding-left: 160px;">
                            {{$sessionUsers->last_name}}
                            {{$sessionUsers->first_name}}
                            様
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <table class="table mt-5 ml-3 border-dark">
                    <thead>
                        <tr class="text-center">
                            <th class="border-bottom border-dark" style="width:13%;">No</th>
                            <th class="border-bottom border-dark" style="width:18%;">商品名</th>
                            <th class="border-bottom border-dark" style="width:15%;">商品カテゴリ</th>
                            <th class="border-bottom border-dark" style="width:15%;">値段</th>
                            <th class="border-bottom border-dark" style="width:15%;">個数</th>
                            <th class="border-bottom border-dark" style="width:15%;">小計</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($cartData as $key => $data)
                                <tr class="text-center">
                                    <th class="align-middle">{{ $key += 1 }}</th>
                                    <td class="align-middle">
                                        @if(isset($data['product_name']))
                                            {{ $data['product_name'] }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if(isset($data['category_name'])) 
                                            {{ $data['category_name'] }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if(isset($data['price']))
                                            {{number_format($data['price']) }}円
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-outline-dark">
                                            @if(isset($data['session_quantity']))
                                                {{ $data['session_quantity'] }}
                                            @endif
                                        </button>
                                        &nbsp;&nbsp;個
                                    </td>
                                    <td class="align-middle">{{ number_format($data['session_quantity'] * $data['price']) }}円</td>

                                    <td class="border-0 align-middle">
                                        {!! Form::open(['route' => ['itemRemove', 'method' => 'post', $data['session_products_id']]]) !!}
                                            {{ Form::submit('削除', ['name' => 'delete_products_id', 'class' => 'btn btn-danger']) }}
                                            {{ Form::hidden('product_id', $data['session_products_id']) }}
                                            {{ Form::hidden('product_quantity', $data['session_quantity']) }}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="text-center">
                                <th class="border-bottom-0 align-middle"></th>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle">合計</td>
                                @php
                                    foreach ($cartData as $key => $data)
                                        $totalPrice = array_sum(array_column($cartData, 'itemPrice'))
                                @endphp
                                    <td class="border-bottom-0 align-middle">{{ number_format($totalPrice) }}円</td>
                            </tr>


                        <tr class="text-right">
                            <th class="border-0"></th>
                            <td class="border-0">
                                <a class="btn btn-success" href="#" role="button">
                                    買い物を続ける
                                </a>
                            </td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0">
                                <a class="btn btn-primary"  href="#" role="button">
                                    注文を確定する
                                </a>
                            </td>
                            <td class="border-0 align-middle"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

@endsection