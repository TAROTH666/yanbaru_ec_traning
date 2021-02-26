@extends('layouts.app')

@section('content')
<main>
	<div class="container">
		<div class="mx-auto">
			<h2>商品情報</h2>
			<h3>
        @if(isset($product->product_name))
          {{ $product->product_name }}
        @endif
      </h3>
			<div class="row">
				<div class="col-sm">
					<div>
						<p class="itemCategory">
              @if(isset($category_name->category_name))
                  {{ $category_name->category_name }}
              @endif
            </p>
						<p>商品説明:</p>
						<p>
              @if(isset($product->description))
                  {{ $product->description }}
              @endif
            </p>
						<br>
						<p>価格:
              @if(isset($product->price))
                  {{ $product->price }}
              @endif
              円
            </p>
					</div>
					{!! Form::open(['route' => 'addcart']) !!}

					{{-- {{ Form::hidden('users_id', $user->id) }} --}}

					{{ Form::hidden('products_id', $product->id) }}

					<div class="form-group row justify-content-center">
						<label class="col-form-label">購入個数</label>
						<div>
							<input type="number" class="inputNumber form-control" value="1" name="product_quantity" id="prodqty">
						</div>
						<label class="col-form-label">個</label>
						<div class="col-sm-auto">
							{!! Form::submit('カートへ', ['class' => 'btn btn-primary']) !!}
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
</main>

@endsection