@extends('layouts.app', [
    'title' => trans('design.design'),
    'body_id' => 'design-index-page',
    'body_classes' => ['design-index-page', 'index-page', 'design-page'],
    'active_nav' => 'design',
])

@section('main')
    <section id="design-filter" class="article-filter">
        <form action="/design" method="get">
            <div class="form-group">
                <label>{{ trans('common.search') }}</label>
                <input type="search" name="search" value="{{ request()->input('search') }}"
                       class="form-control" placeholder="{{ trans('common.search') }}"
                       maxlength="50"/>
            </div>
            <div class="form-group">
                <label>{{ trans('common.tag') }}</label>
                @include('components.tag-filter', ['selected' => request()->input('tag_id')])
            </div>
        </form>
    </section>

    <section id="design-list" class="article-list">
        <div class="list">
            @foreach ($designs as $design)
                <article>
                    <a href="{{ $design->url }}">
                        <div class="cover">
                            @if ($design->image_id)
                                <img class="image" src="{{ $design->image->thumb_file_url }}"
                                    srcset="{{ $design->image->largethumb_file_url }} 2x"/>
                            @else
                                <img class="image" src="{{ url('img/placeholder/square.png') }}"/>
                            @endif
                            @if ($design->logo_id)
                                <img class="logo" src="{{ $design->logo->small_file_url }}"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $design->text('name') }}<br></h2>
                                <div class="excerpt">{{ $design->excerpt('content') }}</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">
            {!! $designs->appends(app('request')->all())->links() !!}
        </div>
    </section><!-- #design-list -->
@endsection
