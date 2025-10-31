@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Reviews</div>
    <div class="card-body table-responsive">

        <p>
            <a href="{{ route('review.add') }}" class="btn btn-info">
                <i class="fa-light fa-plus"></i> Add New
            </a>
        </p>

        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">User ID</th>
                    <th width="10%">Product ID</th>
                    <th width="10%">Order ID</th>
                    <th width="10%">Rating</th>
                    <th>Content</th>
                    <th width="10%">Status</th>
                    <th width="10%">Created</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->userid }}</td>
                    <td>{{ $value->productid }}</td>
                    <td>{{ $value->orderid ?? '-' }}</td>
                    <td>{{ $value->rating }}/5</td>
                    <td>{{ Str::limit($value->content, 50) }}</td>
                    <td>
                        @if($value->status === 'Approved')
                        <span class="badge bg-success">{{ $value->status }}</span>
                        @elseif($value->status === 'Rejected')
                        <span class="badge bg-danger">{{ $value->status }}</span>
                        @else
                        <span class="badge bg-secondary">{{ $value->status }}</span>
                        @endif
                    </td>
                    <td>{{ $value->created_at ? $value->created_at->format('Y-m-d') : '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('review.update', ['id' => $value->id]) }}">
                            <i class="fa-light fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('review.delete', ['id' => $value->id]) }}"
                            onclick="return confirm('Do you want to delete this review #{{ $value->id }} ?')">
                            <i class="fa-light fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-3">
                        No reviews found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection