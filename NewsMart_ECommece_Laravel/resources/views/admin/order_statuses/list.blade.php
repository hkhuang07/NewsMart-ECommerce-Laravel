@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Order Statuses
    </div>
    <div class="card-body table-responsive">
        <p>
            <a href="{{ route('order_status.add') }}" class="btn btn-info">
                <i class="fa-light fa-plus"></i> Add New
            </a>
        </p>
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="45%">Status Name</th>
                    <th width="40%">Description</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order_statuses as $status)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->description }}</td>
                    <td class="text-center">
                        <a href="{{ route('order_status.edit', ['id' => $status->id]) }}">
                            <i class="fa-light fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('order_status.delete', ['id' => $status->id]) }}"
                           onclick="return confirm('Do you want to delete this status: {{ $status->name }} ?')">
                            <i class="fa-light fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No statuses found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection