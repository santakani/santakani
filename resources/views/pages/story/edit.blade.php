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
        <form id="story-edit-form" class="form" action="{{ $story->url }}" data-id="{{ $story->id }}">

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
                            More <span class="caret"></span>
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
                                <label class="control-label">Title</label>
                                <input name="translations[{{ $locale }}][title]" value="{{ $translation->title or '' }}"
                                    id="title-input-{{ $locale }}" class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Content</label>
                                <textarea name="translations[{{ $locale }}][content]"
                                    class="content-editor">{{ $translation->content or '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- /.tab-pane -->

            <br/>

            <div id="image-form-group" class="form-group">
                <label class="control-label">Cover image</label>
                <div id="cover-editor" class="cover-editor">
                    <button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button><br><br>
                    @if ($story->image_id)
                        @include('components.image-preview', ['image' => $story->image])
                    @else
                        @include('components.image-preview')
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">Tags</label>
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
