@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edycja postu</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.update', $post->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right">Treść</label>

                            <div class="col-md-6">
                                <textarea id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" autofocus required>{{ $post->content }}</textarea>

                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="categories" class="col-md-4 col-form-label text-md-right">Kategorie</label>
                            <div class="col-md-6">
                            <select name="categories[]" class="form-select" multiple aria-label="multiple select example" required>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if(in_array($category->id, $post_categories))  selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>

                                @error('categories')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                Zapisz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
