{{--

Images tab

--}}
@if (Auth::check() && Auth::user()->can('edit-designer', $designer))
    <p>
        <a class="btn btn-success" href="{{ $designer->url }}/edit#images">
            {{ trans('image.manage_images') }}
        </a>

        <a class="btn btn-link" href="{{ url('help') }}">
            {{ trans('common.help') }}
        </a>
    </p>
@endif

<div id="images" class="images row">
    @foreach ($images as $image)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <a href="{{ $image->large_file_url }}">
                <img src="{{ $image->thumb_file_url }}">
            </a>
        </div>
    @endforeach
</div>

{!! $images->appends(app('request')->all())->links() !!}
