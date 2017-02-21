@extends('layouts.app', [
    'title' => trans('designer.designers'),
    'body_id' => 'designer-index-page',
    'body_classes' => ['designer-index-page', 'index-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('main')

<div id="designer-list">
    <div class="container">
        <div class="row">
            @foreach ($designers as $designer)
                <div class="col-sm-6 col-lg-4">
                    @include('components.cards.designer-card', ['designer' => $designer])
                </div>
            @endforeach
        </div>

        {!! $designers->appends(app('request')->all())->links() !!}
    </div><!-- /.container -->
</section><!-- /#designer-list -->

@endsection {{-- main --}}
