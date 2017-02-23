{{--

Designs tab

--}}
@if (Auth::check() && Auth::user()->can('edit-designer', $designer))
    <p>
        <a class="btn btn-success" href="{{ url('design/create?designer_id='.$designer->id) }}">
            {{ trans('design.create_design') }}
        </a>
        <a class="btn btn-link">
            {{ trans('common.help')}}
        </a>
    </p>
@endif

<div id="designs" class="row">
    @foreach ($designs as $design)
        <div class="col-sm-6 col-md-4 col-lg-3">
            @include('components.cards.design-card', ['design' => $design, 'hide_designer' => true])
        </div>
    @endforeach
</div>

{!! $designs->appends(app('request')->all())->links() !!}
