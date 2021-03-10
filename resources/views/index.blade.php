@extends('layout')
@section('title')
    {{ Config::get('app.name') }}
@endsection
@section('content')
    <form action="{{url()->current()}}" method="get" class="mb-3">
        <div class="form-inline">
            <label for="sort" class="sr-only">{{ __('Sort') }}</label>
            <select onchange="this.form.submit()" class="form-control mr-2" name="sort" id="sort">
                <option value="desc" {{ app('request')->input('sort') == 'desc' ? "selected" : "" }}>
                    {{__('New first')}}
                </option>
                <option value="asc" {{ app('request')->input('sort') == 'asc' ? "selected" : "" }}>
                    {{__('Old first')}}
                </option>
            </select>
        </div>

    </form>
    @if (count($posts))
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{route('post', $post)}}">{{ $post->title }}</a></h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $post->published }}</h6>
                    <p class="card-text">
                        @foreach($post->tags as $tag)
                            <span class="badge badge-success">{{$tag->title}}</span>
                        @endforeach
                    </p>
                    <a href="{{route('post', $post)}}" class="card-link">{{__('View')}}</a>
                    <a target="_blank" href="{{ $post->external_url }}" class="card-link">{{__('View on Habr')}}</a>
                </div>
            </div>
        @endforeach
    @else
        {{ __('Posts not found') }}
    @endif
    <div>
        {{ $posts->links() }}
    </div>
@endsection
