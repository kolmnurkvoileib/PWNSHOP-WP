<?php get_header(); ?>
<div class="page-content">

    <div class="contact-page">

        <div class="contact-page__section">

            <div class="contact-page__section-item">

                <h2>Контакты</h2>

                <?= do_shortcode('[contact-form-7 id="6" title="Kontakt"]'); ?>

            </div>

            <div class="contact-page__section-item">

                <h2>по телефону 24/7</h2>
                <a href="tel:+372 5014769"><span class="tke-icon tke-icon-phone"></span>+372 5014769</a>

                <h2>Офис открыт</h2>
                <p class="contact-info"><span class="tke-icon tke-icon-clock"></span>Понедельник - Пятница 9:00 - 17:00</p>

                <h2>ОБЩИЙ КОНТАКТ</h2>
                <a href="https://www.google.com/maps?q=+C.+R.+Jakobsoni+6,+10128+Tallinn,+Estonia" target="_blank"><span class="tke-icon tke-icon-location"></span>Якобсони, 6, Таллине</a>
                <a href="tel:+372 5014769"><span class="tke-icon tke-icon-phone"></span>+372 5014769</a>
                <a href="mailto:kellapandimaja@tkepandimaja.ee"><span class="tke-icon tke-icon-email"></span>kellapandimaja@tkepandimaja.ee</a>
                <a href="https://api.whatsapp.com/send?phone=3725014769"><span class="tke-icon tke-icon-whatsapp"></span>Whatsapp: +372 5014769</a>
                <a href="viber://add?number=3725014769"><span class="tke-icon tke-icon-viber"></span>Viber: +372 5014769</a>

                <br>
                <strong>добавить номер телефона</strong>
                <a href="tel:+372 58250366"><span class="tke-icon tke-icon-phone"></span>+372 58250366</a>

            </div>

        </div>

        <div class="contact-page__section">
            <div id="map"></div>
            <script>
                function initMap() {
                    var Jakobsoni = {
                        lat: 59.432121,
                        lng: 24.769788
                    };

                    var stylers = [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#bdbdbd"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dadada"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#c9c9c9"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  }
];

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,
                        center: Jakobsoni,
                        disableDefaultUI: true,
                        styles: stylers
                    });
                    var marker = new google.maps.Marker({
                        position: Jakobsoni,
                        map: map
                    });
                }
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYE0YUnJt4PoyF2ndW8bhNTCx3JY21TKc&callback=initMap"></script>
        </div>

    </div>

</div>

</div>
</div>
<?php get_footer(); ?>