@extends('layouts.app')
@section('content')<div class="card">
    <div class="card-header">Brands</div>
    <div class="card-body table-responsive">
        <p><a href="{{ route('brand.add') }}" class="btn btn-info"><i class="fa-light fa-plus"></i> Add New</a></p>
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="45%">Brand Name</th>
                    <th width="40%">Brand Slug</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->slug }}</td>
                    <td class="text-center"><a href="{{ route('brand.edit', ['id' => $value->id]) }}"><i class="fa-light fa-edit"></i></a></td>
                    <td class="text-center"><a href="{{ route('brand.delete', ['id' => $value->id]) }}" onclick="return confirm('Do you want to delete this brand {{ $value->name }} ?')"><i class="fa-light fa-trash-alt text-danger"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection