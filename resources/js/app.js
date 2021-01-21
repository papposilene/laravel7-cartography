/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'leaflet/dist/leaflet-src.js';
import 'leaflet-spin/leaflet.spin.js';
import 'leaflet-control-geocoder/dist/Control.Geocoder.js';
import 'leaflet-easyprint/dist/bundle.js';
import 'leaflet-fa-markers/L.Icon.FontAwesome.js';
import 'leaflet-sidebar/src/L.Control.Sidebar.js';
import 'leaflet.fullscreen/Control.FullScreen.js';
import 'leaflet.locatecontrol/dist/L.Control.Locate.min.js';
import 'leaflet.markercluster/dist/leaflet.markercluster-src.js';


(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })
    }, false);
})();