@extends('layouts.app')
@section('content')
	<!-- Page content -->
	<main class="content-wrapper">
	
		<section class="container mt-4 mb-4">
			<div class="position-relative overflow-hidden rounded-5 p-4 p-sm-5" style="background:linear-gradient(90deg, var(--primary-light) 0%, var(--primary-lighter) 100%)">
					<span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip" style="background:linear-gradient(90deg, var(--primary-light) 0%, var(--primary-lighter) 100%)"></span>
						<span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip" style="background:linear-gradient(90deg, var(--accent-dark) 0%, var(--primary-super-dark) 100%)"></span>
				<div class="position-relative z-2 text-center py-4 py-md-5 my-md-2 my-lg-5 mx-auto" style="max-width:536px">
					<h1 class="pt-xl-4 mb-4">Thank You for Your Order!</h1>
					<p class="text-dark-emphasis pb-3 pb-sm-4">Your order <span class="fw-semibold">#234000</span> has been accepted and will be processed soon. <span class="fw-semibold">Sunday, November 9, 2025.</span></p>
					<a class="btn btn-lg btn-dark rounded-pill mb-xl-4" href="{{ route('frontend.home') }}">Continue Shopping</a>
				</div>
				<img src="{{ asset('public/assets/img/checkout/thankyou-bg-1.png') }}" class="animate-up-down position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Background image" />
 <img src="{{ asset('public/assets/img/checkout/thankyou-bg-2.png') }}" class="animate-down-up position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Background image" />
			</div>
		</section>
	</main>
@endsection