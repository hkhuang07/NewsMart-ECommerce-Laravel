@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Configurations</div>
    <div class="card-body table-responsive">
        <p>
            <a href="{{ route('configuration.add') }}" class="btn btn-info">
                <i class="fa-light fa-plus"></i> Add New
            </a>
        </p>

        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="25%">Setting Key</th>
                    <th width="45%">Setting Value</th>
                    <th width="20%">Description</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($configurations as $config)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $config->settingkey }}</td>
                    <td>{{ Str::limit($config->settingvalue, 80) }}</td>
                    <td>{{ Str::limit($config->description, 50) }}</td>
                    <td class="text-center">
                        <a href="{{ route('configuration.update', ['settingkey' => $config->settingkey]) }}">
                            <i class="fa-light fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('configuration.delete', ['settingkey' => $config->settingkey]) }}"
                            onclick="return confirm('Do you want to delete configuration {{ $config->settingkey }} ?')">
                            <i class="fa-light fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No configurations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
