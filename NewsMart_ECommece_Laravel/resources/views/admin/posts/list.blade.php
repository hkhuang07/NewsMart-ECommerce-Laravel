@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Posts
    </div>

    <div class="card-body table-responsive">
        <p>
            <a href="{{ route('post.add') }}" class="btn btn-info">
                <i class="fa-light fa-plus"></i> Add New Post
            </a>
        </p>

        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="30%">Title</th>
                    <th width="30%">Content Preview</th>
                    <th width="15%">Author</th>
                    <th width="10%">Created</th>
                    <th width="5%">Edit</th>
                    <th width="5%">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ Str::limit(strip_tags($post->content), 60) }}</td>
                    <td>{{ $post->user->name ?? 'N/A' }}</td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>

                    <td class="text-center">
                        <a href="{{ route('post.update', ['id' => $post->id]) }}" title="Edit Post">
                            <i class="fa-light fa-edit"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('post.delete', ['id' => $post->id]) }}"
                            onclick="return confirm('Do you want to delete this post: {{ $post->title }} ?')"
                            title="Delete Post">
                            <i class="fa-light fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No posts found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection