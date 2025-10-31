@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Roles
    </div>
    <div class="card-body table-responsive">
        <p>
            <a href="{{ route('role.add') }}" class="btn btn-info">
                <i class="fa-light fa-plus"></i> Add New
            </a>
        </p>
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="40%">Role Name</th>
                    <th width="40%">Role Slug</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->slug }}</td>
                    <td class="text-center">
                        <a href="{{ route('role.edit', ['id' => $role->id]) }}">
                            <i class="fa-light fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('role.delete', ['id' => $role->id]) }}"
                           onclick="return confirm('Do you want to delete this role {{ $role->name }} ?')">
                            <i class="fa-light fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No roles found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
