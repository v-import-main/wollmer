<?php
$order = wc_get_order( $order_id );
if (! $order ) exit();
	// echo '<pre>';
	// print_r($order->get_data());
	// print_r($order->get_shipping_method());
	// print_r($order->get_items());
	// echo '</pre>';
?>

<div class="flex flex-wrap">
	<div class="md:w-2/3 grid gap-4">
		<section class="grid gap-4">
			<div class="border rounded-xl p-4 grid gap-2">
					<div class="border border-[#1F9E3B] rounded py-1 px-4 border-forest-green grid grid-cols-1a gap-2 items-center relative">
						<h2 class="text-xl font-semibold">Заказ <?= $order->get_order_number()?> принят</h2>
						<svg class="absolute right-3" width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.75121 10.2491C4.75071 10.2496 4.74989 10.2496 4.74939 10.2491L0.879681 6.29891C0.529842 5.94179 0.529842 5.37047 0.879682 5.01336C1.23975 4.64581 1.83146 4.64569 2.19168 5.01308L4.75121 7.62361L4.7503 7.62454L11.8084 0.419651C12.1685 0.0520623 12.7604 0.0520639 13.1205 0.419653C13.4702 0.776684 13.4703 1.34787 13.1205 1.70492L6.03584 8.93773L4.75121 10.2491Z" fill="#1F9E3B"/>
						</svg>
					</div>
					<div class="grid gap-2">
						<p class="text-base font-medium">
							Ожидайте звонка специалиста для подтверждения заказа. <br>
						</p>
						<p class="text-base font-medium">
							Режим работы в будние дни: 10:00-19:00 <br>
							По выходным: 11:00-18:00
						</p>
						<p class="text-base font-medium">
							Заказ, поступивший в нерабочее время, обрабатывается на следующий день.
						</p>
					</div>
			</div>
		</section>

		<section class="grid gap-4">
			<div class="border rounded-xl p-4 grid gap-2">
				<h2 class="text-xl font-semibold">Состав заказа</h2>
				<div class="grid grid-cols-a1 gap-x-8 gap-y-2">
				<?php foreach ($order->get_items() as $item) { ?>
					<h3 class="text-base font-medium sm:w-48">Артикул:</h3>
					<p class="text-base font-medium"><?= $item->get_product()->get_sku(); ?></p>
					<h3 class="text-base font-medium sm:w-48">Наименование:</h3>
					<p class="text-base font-medium"><?= $item->get_name(); ?></p>
					<h3 class="text-base font-medium sm:w-48">Количество:</h3>
					<p class="text-base font-medium mb-4"><?= $item->get_quantity(); ?> шт</p>
					<?php } ?>
				</div>
			</div>
			<div class="border rounded-xl p-4 grid gap-2">
				<h2 class="text-xl font-semibold">Доставка</h2>
					<div class="grid grid-cols-a1 gap-x-8 gap-y-2">
						<h3 class="text-base font-medium sm:w-48">Имя и фамилия:</h3>
						<p class="text-base font-medium"><?= $order->get_data()['billing']['first_name']; ?></p>
						<h3 class="text-base font-medium sm:w-48">Мобильный телефон:</h3>
						<p class="text-base font-medium"><?= $order->get_data()['billing']['phone']; ?></p>
						<h3 class="text-base font-medium sm:w-48">Электронная почта:</h3>
						<p class="text-base font-medium"><?= $order->get_data()['billing']['email']; ?></p>
						<h3 class="text-base font-medium sm:w-48">Способ доставки:</h3>
						<p class="text-base font-medium"><?= $order->get_shipping_method()?></p>
						<h3 class="text-base font-medium sm:w-48">Комментарий:</h3>
						<p class="text-base font-medium"><?= $order->get_data()['billing']['order_comments']; ?></p>
						<!-- <h3 class="text-base font-medium sm:w-48">Страна</h3> -->
						<!-- <p class="text-base font-medium">Россия</p> -->
						<!-- <h3 class="text-base font-medium sm:w-48">Город:</h3> -->
						<!-- <p class="text-base font-medium"><?= $order->get_data()['billing']['city'];?></p> -->
						<!-- <h3 class="text-base font-medium sm:w-48">Адрес:</h3> -->
						<!-- <p class="text-base font-medium"><?= $order->get_data()['billing']['address_1']; ?></p> -->
					</div>
				</div>
				<div class="border rounded-xl p-4 grid gap-2">
				<h2 class="text-xl font-semibold">Оплата</h2>
				<div class="grid grid-cols-a1 gap-x-8 gap-y-2">
					<h3 class="text-base font-medium sm:w-48">Способ оплаты:</h3>
					<p class="text-base font-medium"><?= $order->get_payment_method_title(); ?></p>
					<!-- <h3 class="text-base font-medium sm:w-48">Статус оплаты:</h3>  -->
					<!-- <p class="text-base font-medium"><?= $order->get_date_paid() ? 'Оплачен' : 'Не оплачен';?></p>  -->
				</div>
			</div>
		</section>
		<p class="text-center mb-12 mt-8">
			<a href="/" class="btn">
					<span class="px-8">На главную</span>
			</a>
		</p>

		<style>
			.woocommerce-notice,
			.woocommerce-order-overview,
			.woocommerce-order-details,
			.woocommerce-customer-details {
				display: none;
			}
		</style>

	</div>
	
	<div class="md:w-1/3 thank_sidebar">
		<div class="thank_wrap">
			<h2><span>Итого</span> <span><?= $order->get_total(false); ?> ₽</span></h2>
			<div class="w-full mb-6">
				<div class="flex-line">
					<div>Товары</div>
					<div><?= $order->get_subtotal(false); ?> ₽</div>
				</div>
				<div class="flex-line">
					<div>Доставка</div>
					<div><?= $order->get_shipping_total(); ?> ₽</div>
				</div>
			</div>
		</div>
	</div>
</div>
