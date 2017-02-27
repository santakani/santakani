@extends('layouts.app', [
    'title' => trans('design.designs'),
    'body_id' => 'design-index-page',
    'body_classes' => ['design-index-page', 'index-page', 'design-page'],
    'active_nav' => 'design',
])

@section('main')
<div id="design-list">
    <div class="container">
        <div class="row">
            @foreach ($designs as $design)
                <div class="col-sm-6 col-md-4">
                    @include('components.cards.design-card', ['design' => $design])
                </div>
            @endforeach
        </div>

        <div class="text-center">
            {!! $designs->appends(app('request')->all())->links() !!}
        </div>
    </div><!-- /.container -->
</div><!-- /#design-list -->
@endsection
