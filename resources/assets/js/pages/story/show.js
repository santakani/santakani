var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');
var PageContent = require('../../views/content/page-content');

new DeleteButton({el: '#delete-button'});
new DeleteButton({el: '#force-delete-button', forceDelete: true});
new LikeButton({el: '#like-button'});
new PageContent();
