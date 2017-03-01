@extends('layouts.app', [
    'title' => trans('common.edit') . ' ' . $story->text('title'),
    'body_id' => 'story-edit-page',
    'body_classes' => ['story-edit-page', 'story-page', 'edit-page'],
    'active_nav' => 'story',
])

@section('main')
<div class="container">

    <h1 class="page-header">{{ trans('common.edit') }} <a href="{{ $story->url }}">{{ $story->text('title') }}</a></h1>

    <form id="story-edit-form" class="edit-form" action="{{ $story->url }}" data-id="{{ $story->id }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                <li class="more dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {{ trans('common.more') }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right"></ul>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                @foreach (App\Localization\Languages::all() as $locale)
                    <?php $translation = $story->translations()->where('locale', $locale)->first(); ?>
                    <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                        <div class="form-group">
                            <label class="control-label">{{ trans('common.title') }}</label>
                            <input name="translations[{{ $locale }}][title]" value="{{ $translation->title or '' }}"
                                id="title-input-{{ $locale }}" class="form-control" type="text" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label class="control-label">{{ trans('common.content') }}</label>
                            <textarea name="translations[{{ $locale }}][content]"
                                class="content-editor">{{ $translation->content or '' }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div><!-- /.tab-content -->
        </div><!-- /.tab-pane -->

        <br/>

        <div class="form-group">
            <label>{{ trans('image.cover_image') }}</label>
            @include('components.upload.image-chooser', [
                'id' => 'cover-chooser',
                'image' => $story->image,
                'name' => 'image_id',
                'width' => 600,
                'height' => 300,
                'size' => 'banner',
            ])
            <p class="text-muted">{{ trans('image.recommended_size', ['width' => 600, 'height' => 300]) }}
        </div>

        <div class="form-group">
            <label class="control-label">{{ trans('common.tags') }}</label>
            @include('components.selects.tag-select', ['selected' => $story->tags])
        </div>

        <div class="form-group">
            <label class="control-label">{{ trans('story.status') }}</label>
            <select class="form-control" name="status">
                <option value="draft" {{ $story->published_at ? '' : 'selected' }}>{{ trans('story.draft') }}</option>
                <option value="published" {{ $story->published_at ? 'selected' : '' }}>{{ trans('story.published') }}</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>

        <a class="btn btn-link" href="{{ url('story/'.$story->id) }}">{{ trans('common.cancel') }}</a>

    </form>

</div><!-- /.container -->

@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.upload.image-manager')
@endpush
