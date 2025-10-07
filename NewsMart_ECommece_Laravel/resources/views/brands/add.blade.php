@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Add Brand</div>
    <div class="card-body">

        <form action="{{ route('brand.add') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Brand Name</label>

                <input type="text" class="form-control" @error('name') is-invalid @enderror id="name" name="name" value="{{ old('name') }}" required />

                @error('name')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="address">Brand Address</label>

                <input type="text" class="form-control" @error('address') is-invalid @enderror id="address" name="address" value="{{ old('address') }}" />

                @error('address')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Brand Email</label>

                <input type="email" class="form-control" @error('email') is-invalid @enderror id="email" name="email" value="{{ old('email') }}" />

                @error('email')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="contact">Brand Contact</label>

                <input type="text" class="form-control" @error('contact') is-invalid @enderror id="contact" name="contact" value="{{ old('contact') }}" />

                @error('contact')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Brand Description</label>

                <textarea class="form-control" @error('description') is-invalid @enderror id="description" name="description" rows="3">{{ old('description') }}</textarea>

                @error('description')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-light fa-save"></i> Add to Database</button>
        </form>

    </div>
</div>
@endsection