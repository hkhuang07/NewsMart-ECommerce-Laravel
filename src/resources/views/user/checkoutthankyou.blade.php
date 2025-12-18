@extends('layouts.app')
@section('title', 'Placed Order Successfully')
@section('content')
<main class="content-wrapper">
	<section class="container mt-4 mb-4">
		<div class="position-relative overflow-hidden rounded-5 p-4 p-sm-5" style="background-color:var(--cz-success-border-subtle)">

			<div class="position-relative z-3 text-center py-4 py-md-5 my-md-2 my-lg-5 mx-auto" style="max-width:536px">
				<h1 class="pt-xl-4 mb-4" style="font-size:3rem; color:lavender !important; text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">Thank you for your order!</h1>
				<p class="pb-3 pb-sm-4" style="color:aquamarine !important; font-size: 1.1rem; font-weight:bold !important; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">The order has been accepted and will be processed as soon as possible.</p>
				<a class="btn btn-lg btn-success rounded-pill mb-xl-4" style="background: linear-gradient(to right,#000990 0%, #0007DD 50%,#0550FF 100%) !important; border:none;" href="{{ route('frontend.home') }}">Continue shopping</a>
			</div>

			<img src="{{ asset('public/images/thankyou.jpg') }}" class="animate-up-down position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 1;" alt="Background image" />
			<div class="position-absolute top-0 start-0 w-100 h-100"
				style="background-color: rgba(0, 6, 36, 0.6); 
                        backdrop-filter: blur(2px);
                        -webkit-backdrop-filter: blur(2px); 
                        z-index: 2;">
			</div>
			<img src="{{ asset('public/images/thankyou-icon.png') }}" class="animate-down-up position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 1;" alt="Icon image" />
		</div>
	</section>
</main>
@endsection