@extends('layouts.app', [
    'title' => trans('common.edit') . ': ' . $story->text('title') . ' - ' . trans('story.story'),
    'body_id' => 'story-edit-page',
    'body_classes' => ['story-edit-page', 'story-page', 'edit-page'],
    'active_nav' => 'story',
])

@section('header')
    <div class="container">
        <h1 class="page-header">{{ trans('common.edit') }}: {{ $story->text('title') }}</h1>
    </div>
@endsection

@section('main')
    <div class="container">
        <form id="story-edit-form" class="edit-form form" action="{{ $story->url }}" data-id="{{ $story->id }}">

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
                <label class="control-label">{{ trans('common.cover_image') }}</label>
                @include('components.upload.image-chooser', ['id' => 'cover-chooser', 'image' => $story->image])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('common.tags') }}</label>
                <select name="tag_ids[]" class="tag-select form-control" style="width: 100%" multiple="multiple">
                    @foreach ($story->tags as $tag)
                        <option value="{{ $tag->id }}" selected="selected">{{ $tag->text('name') }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-default">Save</button>

        </form>
    </div><!-- /.container -->
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.image-manager')
@endpush
