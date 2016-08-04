@extends('layouts.app', [
    'title' => trans('designer.designers'),
    'body_id' => 'designer-index-page',
    'body_classes' => ['designer-index-page', 'index-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('main')
    <section id="designer-filter" class="article-filter">
        <form action="/designer" method="get">
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

    <section id="designer-list" class="article-list">
        <div class="list">
            @foreach ($designers as $designer)
                <article>
                    <a href="{{ $designer->url }}">
                        <div class="cover">
                            @if ($designer->image_id)
                                <img class="image" src="{{ $designer->image->thumb_file_url }}"
                                    srcset="{{ $designer->image->largethumb_file_url }} 2x"/>
                            @endif
                            @if ($designer->logo_id)
                                <img class="logo" src="{{ $designer->logo->small_file_url or '' }}"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $designer->text('name') }}<br></h2>
                                <div class="tagline text-muted">{{ $designer->text('tagline') }}</div>
                                <div class="excerpt">{{ $designer->excerpt('content') }}</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">
            {!! $designers->appends(app('request')->all())->links() !!}
        </div>
    </section><!-- #designer-list -->
@endsection
