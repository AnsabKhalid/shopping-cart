@extends('client_layout.client')

@section('title')
        Products-Detail
@endsection

@section('content')

<!-- start content -->

<div class="container-fluid" style="margin: 70px 0 100px 0">
	<div class="row">
		<div class="col-md-6 col-lg-6 ftco-animate mt-5">
			<div class="product">
				<a href="#" class="img-prod"><img class="img-fluid" style="padding-left: 40px" src="{{asset('storage/app/public/product_image/' .$product->product_image) }}" alt="{{ $product->product_name }}">				
				</a>
			</div>
		</div>
		<div class="col-md-6 col-lg-6 ftco-animate mt-5">
			<h2 class="">Product Name : <a href="#">{{ $product->product_name }}</a></h2>
			<h3 class="">Product Price : <a href="#">{{ '$ '.$product->product_price }}</a></h3>

			<h5 class="pull-right">Product Detail : <a href="#">{{ $product->detail }}</a></h5>


			<a href="{{ url('/addtocart/'.$product->id) }}" class="buy-now d-flex mx-1">
				<button class="btn btn-success" style="margin: 5px 0 70px 0">Add to cart</button>
			</a>
		</div>
	</div>
</div>

<section class="ftco-section ftco-partner" style="background-color: #efeff5" >
	<div class="container">
		<div class="row">
			<div class="col-sm ftco-animate">
				<a href="#" class="partner"><img src="{{asset('public/frontend/images/partner-1.png')}}" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner"><img src="{{asset('public/frontend/images/partner-2.png')}}" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner"><img src="{{asset('public/frontend/images/partner-3.png')}}" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner"><img src="{{asset('public/frontend/images/partner-4.png')}}" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-sm ftco-animate">
				<a href="#" class="partner"><img src="{{asset('public/frontend/images/partner-5.png')}}" class="img-fluid" alt="Colorlib Template"></a>
			</div>
		</div>
	</div>
</section>

<!-- end content -->

@endsection
