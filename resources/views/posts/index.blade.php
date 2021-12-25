@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1><i class="fas fa-clipboard-list"></i> Posty</h1>
        </div>
        <div class="col-6">
            <a class="float-right" style="float:right;" href="{{ route('posts.create') }}">
                <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i></button>
            </a>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Treść</th>
                <th scope="col">Kategorie</th>
                <th scope="col">Autor</th>
                <th style="float:right;" scope="col">Akcje</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->content }}</td>
                    <td>
                        @foreach($post->categories as $category)
                            <ul>
                                <li>{{$category->name}}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $post->user->name }}</td>
                    <td>
                        <a style="float:right;" href="{{ route('posts.edit', $post->id) }}">
                            <button class="btn btn-success btn-sm"><i class="far fa-edit"></i></button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
</div>
@endsection