@extends('layout')
@section('title')
    {{ Config::get('app.name') }}
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            @foreach($post->tags as $tag)
                <span class="badge badge-success">{{$tag->title}}</span>
            @endforeach
        </div>
        <div class="card-body">
            <h3 class="card-title">{{ $post->title }}</h3>
            <h6 class="card-subtitle mb-2 text-muted">{{ $post->published }}</h6>
            <div class="card-text">{!! HTMLHelper::purify($post->content) !!}</div>
        </div>
    </div>
@endsection
