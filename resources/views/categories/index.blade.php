@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1><i class="fas fa-clipboard-list"></i> Kategorie</h1>
        </div>
        <div class="col-6">
            <a class="float-right" style="float:right;" href="{{ route('categories.create') }}">
                <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i></button>
            </a>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nazwa</th>
                <th style="float:right;" scope="col">Akcje</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a style="float:right;" href="{{ route('categories.edit', $category->id) }}">
                            <button class="btn btn-success btn-sm"><i class="far fa-edit"></i></button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>
@endsection