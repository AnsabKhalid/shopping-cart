@extends('client_layout.client')

@section('title')
	Wishlist
@endsection

@section('content')

<!-- start content -->

<?php 
		use App\Http\Controllers\ClientController;

		$totalWishlist = 0;
		if(Session::has('client')) {
			$totalWishlist = ClientController::wishlistTotal();
		}
	?>
	
<div class="hero-wrap hero-bread" style="background-image: url('{{ asset('public/frontend/images/bg_1.jpg') }}');">
	<div class="container">
	<div class="row no-gutters slider-text align-items-center justify-content-center">
		<div class="col-md-9 ftco-animate text-center">
		<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Products</span></p>
		<h1 class="mb-0 bread">Products</h1>
		</div>
	</div>
	</div>
</div>

<section class="ftco-section">
<div class="container">

		@if (Session::has('status'))
			<div class="alert alert-success">
				{{Session::get('status')}}
			</div>
		@endif

<div class="row">
@if($totalWishlist > 0)
@foreach($products as $product)
	<div class="col-md-6 col-lg-3 ftco-animate">
		<div class="product">
			<a href="#" class="img-prod"><img class="img-fluid" src="{{asset('storage/app/public/product_image/' .$product->product_image) }}" alt="{{ $product->product_name }}">
				<div class="overlay"></div>
			</a>
			<div class="text py-3 pb-4 px-3 text-center">
				<h3><a href="#">{{ $product->product_name }}</a></h3>
				<div class="d-flex">
					<div class="pricing">
						<p class="price"><span>{{ '$ '.$product->product_price }}</span></p>
					</div>
				</div>
				<div class="bottom-area d-flex px-3">
					<div class="m-auto d-flex">
						<a href="{{ url('/product_detail/'.$product->id) }}" class="add-to-cart d-flex justify-content-center align-items-center text-center">
							<span><i class="ion-ios-menu" title="View Details"></i></span>
						</a>
						<a href="{{ url('/addtocart/'.$product->id) }}" class="buy-now d-flex justify-content-center align-items-center mx-1">
							<span><i class="ion-ios-cart" title="Add to cart"></i></span>
						</a>

						<form action="wishlist" method="POST">
							@csrf
							<input type="hidden" name="product_id" value = {{ $product->id }}>
							@if(Session::has('client'))
								<a href="{{ url('/remove_wishlist_item/'.$product->wishlist_id) }}" class="heart d-flex justify-content-center align-items-center ">
	    							<span><i class="ion-ios-heart"></i></span>
	    						</a>
								@else
									<button type="button" class="btn btn-success userLogin">
										<span><i class="ion-ios-heart-empty"></i></span>
									</button>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach

@else 
	<h3 style="margin: 10px 0 20px 28%; color: green">There are no products in your wishlist</h3>
@endif
</div>

	<div class="row mt-5">
		<div class="col text-center">
			<div class="d-flex justify-content-center">
              <h2 style="font-style: italic">End of page</h2>
            </div> 
		</div>
	</div>
</div>
</section>

<!-- end content -->

@endsection

@section('scripts')

	<script>
		$(document).ready(function(){
			$(".userLogin").click(function(){
			alert("Login to add products in your wishlist...")
			});
		});
	</script>
@endsection