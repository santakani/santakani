@extends('layouts.app', [
    'title' => trans('common.edit') . ': ' . $tag->text('name'),
    'body_id' => 'tag-edit-page',
    'body_classes' => ['tag-edit-page', 'tag-page', 'edit-page'],
    'active_nav' => 'tag',
])

@section('header')
    <div class="container">
        <h1 class="page-header">{{ trans('common.edit') }}: {{ $tag->text('name') }}</h1>
    </div>
@endsection

@section('main')
    <div class="container">
        <form id="edit-form" class="edit-form" action="/tag/{{ $tag->id }}"
            data-id="{{ $tag->id }}">

            {!! csrf_field() !!}

            <div class="tab-pane-group">
                <!-- Nav tabs -->
                <ul id="translation-tabs" class="nav nav-tabs">
                    @foreach (App\Localization\Languages::names() as $locale => $names)
                        <li class="{{ $locale==='en'?'active':'' }}">
                            <a href="#translation-{{ $locale }}" data-toggle="tab" title="{{ $names['native'] }}">
                                {{ $names['localized'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach (App\Localization\Languages::all() as $locale)
                        <?php $translation = $tag->translations()->where('locale', $locale)->first(); ?>
                        <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                            <div class="form-group">
                                <label>{{ trans('common.name') }}</label>
                                <input name="translations[{{ $locale }}][name]" value="{{ $translation->name or '' }}"
                                       class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('common.alias') }}</label>
                                <input name="translations[{{ $locale }}][alias]" value="{{ $translation->alias or '' }}"
                                       class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('common.description') }}</label>
                                <textarea name="translations[{{ $locale }}][description]"
                                    class="form-control">{{ $translation->description or '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <br>

            <div class="form-group">
                <label>{{ trans('image.cover_image') }}</label>
                @include('components.upload.image-chooser', [
                    'id' => 'cover-chooser',
                    'image' => $tag->image,
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('common.level') }}</label>
                <input name="level" value="{{ $tag->level or '' }}"
                       class="form-control" type="number" min="0" max="255">
            </div>

            <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>

            <a class="btn btn-link" href="{{ $tag->url }}">{{ trans('common.cancel') }}</a>

        </form>
    </div><!-- .container -->
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.upload.image-manager')
@endpush
