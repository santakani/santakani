<div class="image-preview" style="background-image:url({{ $url or '' }})">
    <div class="progress" style="display:none;">
        <div class="progress-bar progress-bar-striped active" style="width: 0%"></div>
    </div>
    @if (isset($remove) && $remove)
        <span class="remove"><i class="fa fa-times"></i></span>
    @endif
    <input type="hidden" name="{{ $name or 'image' }}" value="{{ $id or '' }}">
</div>
