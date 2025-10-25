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
                    <th width="20%">Setting Key</th>
                    <th width="35%">Setting Value</th>
                    <th width="25%">Description</th>
                    <th width="10%">Updated At</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($configurations as $config)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $config->settingkey }}</td>
                    <td class="text-break">{{ Str::limit($config->settingvalue, 80) }}</td>
                    <td>{{ $config->description }}</td>
                    <td>{{ $config->updated_at ? $config->updated_at->format('Y-m-d H:i') : '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('configuration.edit', ['settingkey' => $config->settingkey]) }}">
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
                    <td colspan="7" class="text-center text-muted">No configurations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection