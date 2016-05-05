var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('place-map-draw'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 8
  });
}

$(function () {
    $('#place-map-inner').affix({
        offset: {
            top: function () {
                return this.top = $('#kanibar').outerHeight(true) + 20;
            },
            bottom: function () {
                return this.bottom = $('footer').outerHeight(true) + 20;
            }
        }
    });
});
