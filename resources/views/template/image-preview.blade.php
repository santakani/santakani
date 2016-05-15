<template id="image-preview-template">
    <div class="progress" style="display:none;">
        <div class="progress-bar progress-bar-striped active" style="width: <%= progress %>%"></div>
    </div>
    <span class="remove">×</span>
    <input type="hidden" name="image" value="<%= id %>">
</template>
