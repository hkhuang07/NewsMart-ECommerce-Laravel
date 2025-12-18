@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Comments</div>
    <div class="card-body table-responsive">

        <p>
            <a href="{{ route('admin.comment.add') }}" class="btn btn-info">
                <i class="fa-light fa-plus"></i> Add New
            </a>
        </p>

        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Comment ID</th>
                    <th width="10%">Post ID</th>
                    <th width="10%">User ID</th>
                    <th width="15%">Parent ID</th>
                    <th>Content</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>

            <tbody>
                @foreach($comments as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->postid }}</td>
                    <td>{{ $value->userid }}</td>
                    <td>{{ $value->parentcommentid ?? '—' }}</td>
                    <td>{{ Str::limit($value->content, 50) }}</td>

                    <td class="text-center">
                        <a href="{{ route('admin.comments.edit', ['id' => $value->id]) }}">
                            <i class="fa-light fa-edit"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        <a href="#" 
                           onclick="openDeleteCommentModal({{ $value->id }}, {
                               postid: '{{ $value->postid }}',
                               userid: '{{ $value->userid }}',
                               parentcommentid: '{{ $value->parentcommentid }}',
                               content: @json($value->content)
                           })">
                            <i class="fa-light fa-trash-alt text-danger"></i>
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@include('admin.comments.modal_delete') {{-- delete modal --}}
@endsection
