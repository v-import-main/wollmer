<div class="fields-group fields-shipping" id="delivery">
  <p class="fields-group-headline">Способ получения</p>
  <div class="tabs_toggler">
    <a class="tag selected" onclick="toggle_ship('curier')">Курьером</a>
    <a class="tag" onclick="toggle_ship('cdek')">Пункт выдачи</a>
  </div>

  <div class="tabs">
    <div id="curier">
      <?= $field1; ?>
    </div>
    <div style="display:none" id="cdek">
      <div>
        <!-- <p>Дата и время доставки согласовывается с менеджером при подтверждении заказа. Доставка осуществляется курьерскими службами Dalli service и СДЭК</p> -->
        <!-- p class="price">+ 400 ₽</p -->
      </div>
    </div>
  </div>
  <div class="fields-wrapper">