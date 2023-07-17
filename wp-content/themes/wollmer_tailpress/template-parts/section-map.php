<script src="https://api-maps.yandex.ru/2.1/?apikey=927a70a9-1768-4f55-bd6a-c2255bf68c98&lang=ru_RU" type="text/javascript"></script>
<div id="section-map">
  <h1 class="headline">Наши сервисные центры</h1>
  <div class="taglist">
    <?php
      $areas = [
        [
          'id' => '1',
          'name' => 'Санкт-Петербург',
          'lat' => '59.938955',
          'long' => '30.315644',
          'zoom' => '11',
        ],
        [
          'id' => '2',
          'name' => 'Москва',
          'lat' => '55.755864',
          'long' => '37.617698',
          'zoom' => '10',
        ],
        [
          'id' => '3',
          'name' => 'Регионы России',
          'lat' => '55.230766',
          'long' => '54.190826',
          'zoom' => '3',
        ],
        [
          'id' => '4',
          'name' => 'Казахстан',
          'lat' => '49.213729',
          'long' => '73.394297',
          'zoom' => '5',
        ],
      ];
      $services = carbon_get_post_meta($post->ID,'sc');

    ?>
    <?php foreach ($areas as $key=>$area){ ?>
      <button
        class="tag <?= $key === 0 ? 'selected' : ''; ?>" 
        data-area="<?=$area['id'];?>"
        data-long="<?= $area['long'];?>"
        data-lat="<?= $area['lat'];?>"
        onclick="zoom_map(<?=$area['zoom'];?>);center_map(this);show_city('<?= $area['id'];?>');"
        >
        <?= $area['name']; ?>
      </button>
    <?php } ?>
  </div>
  <div class="map-wrapper">
    <div class="map-list">
      <div class="service-list show_1">
      <div class="search-input">
        <input type="text">
        <button></button>
      </div>
        <?php foreach($services as $key=>$service) { ?>
          <div class="service-item <?= $key === 0 ? 'selected' : ''; ?> area_<?= $service['area_id'];?>"
            data-service="service_<?= $service['id'];?>"
            id="service_<?= $service['id'];?>"
            data-long="<?= $service['longitude'];?>"
            data-lat="<?= $service['latitude'];?>"
            onclick="center_map(this)"
          >
            <p class="headline"><?= $service['name'];?></p>
            <p><?= $service['address'];?></p>
            <p class="lite"><?= $service['schedule'];?></p>
            <p><?= $service['phone'];?></p>
          </div>
        <?php } ?>
      </div>
    </div>
    <div id="map" data-zoom="12" data-long="<?= $services[0]['longitude'];?>" data-lat="<?= $services[0]['latitude'];?>">
    </div>
  </div>
</div>
<script>
  let map = document.getElementById('map');
  let zoom = map.getAttribute('data-zoom');
  let long = map.getAttribute('data-long');
  let lat = map.getAttribute('data-lat');
  let i;

  var myMap;


  function center_map(e) {
    console.log('here',$(e).data());
    $(e).addClass('selected').siblings().removeClass('selected');
    myMap.setCenter([$(e).data('lat'),$(e).data('long')]);
  }

  function zoom_map(zoom) {
    myMap.setZoom(zoom);
  }

  function show_city(areaid) {
    document.querySelector('.service-list').className = 'service-list';
    document.querySelector('.service-list').classList.add('show_'+areaid);
  }

  var services = document.getElementsByClassName('service-item');
  console.log(services);
  ymaps.ready(init);


  

  function init() {
    myMap = new ymaps.Map('map', {
      center: [lat, long],
      zoom: zoom
    });
    
    myMap.geoObjects.events.add('click', function (e) {
      // e.stopPropagation();
      let el = $('#'+e.get('objectId'));

      console.log('elId',e.get('objectId'));


      var divWindow = $('.map-list').offset().top;
      var clickedLink = el.offset().top;
      toScroll = clickedLink - divWindow - 20; 

      el.addClass('selected').siblings().removeClass('selected');
      $('.map-list').animate({ scrollTop: toScroll }, 900);
    });
    

    var objects = [];
    for ( i = 0; i < services.length; i++ ) {

      objects.push({
          type: 'Feature',
          id: services[i].getAttribute('data-service'),
          geometry: {
              type: 'Point',
              coordinates: [services[i].getAttribute('data-lat'),services[i].getAttribute('data-long')]
          },
          options: {
            iconLayout: 'default#image',
            iconImageHref: '/wp-content/themes/wollmer_tailpress/resources/img/point.png',
            iconImageSize: [30, 39],
          },
          properties: {
          }
      });


      // myMap.geoObjects.add(
      //   new ymaps.Placemark(
      //     [services[i].getAttribute('data-lat'),
      //     services[i].getAttribute('data-long')],
      //     {
      //       objectId: services[i].getAttribute('data-service'),
      //     },
      //     {
      //       iconLayout: 'default#image',
      //       iconImageHref: '/wp-content/themes/wollmer_tailpress/resources/img/point.png',
      //       iconImageSize: [30, 39],
      //   })
      // );
    }
    var objectManager = new ymaps.ObjectManager();
    objectManager.add(objects);
    myMap.geoObjects.add(objectManager);
  }
</script>