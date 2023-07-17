<?php get_header(); ?>

	<div class="container my-8 mx-auto">

	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php
			the_content();
			?>
			<script>
				document.addEventListener("DOMContentLoaded", function(event) { 

					jQuery('#billing_phone').on('keypress',function(e){
						setTimeout(() => {
							console.log('phone:',e.currentTarget.value);
							if(e.currentTarget.value[4] !== '9'){
								e.currentTarget.value = '+7 ('
							}
						}, 100);
					})
					jQuery('.woocommerce-billing-fields').find('input').on('change',function(e){
						let curval = e.target.value;
						setTimeout(() => {
							checker(e.target)
						}, 100);
					})
					jQuery('.woocommerce-billing-fields').find('input').on('keydown',function(e){
						setTimeout(() => {
							checker(e.target)
						}, 100);
					}) 
					// addClassNameListener('form.checkout');
				});
				function checker(e){
					// console.log(e.name,e.value);
					// console.log(e);
					// if(e.name === 'billing_first_name'){
					// 	if(e.value.length < 3 ){
					// 		$(e).parents('.woocommerce-input-wrapper').addClass('wrong');
					// 		$(e).parents('.woocommerce-input-wrapper').removeClass('ok');
					// 	} else {
					// 		$(e).parents('.woocommerce-input-wrapper').removeClass('wrong');
					// 		$(e).parents('.woocommerce-input-wrapper').addClass('ok');
					// 	}
					// }
					if(e.name === 'billing_phone') {
						if(isNaN(e.value[17])){
							console.log(e.value);
							$(e).parents('.woocommerce-input-wrapper').addClass('wrong');
							$(e).parents('.woocommerce-input-wrapper').removeClass('ok');
						} else {
							$(e).parents('.woocommerce-input-wrapper').removeClass('wrong');
							$(e).parents('.woocommerce-input-wrapper').addClass('ok');
						}
					}
					// if(e.name === 'billing_email') {
						// if( (e.value[e.value.length-1].match(/[a-z]/i) !== null)
						// 	&& e.value.length > 5
						// 	&& e.value.indexOf('@') != -1
						// 	&& e.value.indexOf('.') != -1
						// 	// && e.value[e.value.length-1] !== '_'
						// 	// && e.value[e.value.length-1] !== '@'
						// 	// && e.value[e.value.length-1] !== '.'
						// 	// && isNaN(e.value[e.value.length-1])
						// ){
						// 	$(e).parents('.woocommerce-input-wrapper').removeClass('wrong').addClass('ok');
						// } else {
						// 	$(e).parents('.woocommerce-input-wrapper').addClass('wrong').removeClass('ok');
						// }
					// }
				}

				// function addClassNameListener(elem) {
				// 	var elem = document.querySelector(elem);
				// 	var lastClassName = elem.className;
				// 	window.setInterval( function() {   
				// 		console.log('ah shit. here we go again',className);
				// 		var className = elem.className;
				// 		if (className !== lastClassName) {
				// 			console.log(lastClassName);
				// 			setWrongClassNames(checkWrongClassNames());
				// 			lastClassName = className;
				// 		}
				// 	},250);
				// }

				// function setWrongClassNames(_arr){
				// 	console.log('SWCN',_arr.length);
				// 	_arr.forEach(element => {
				// 		console.log(element);
				// 		jQuery(element).parents('.woocommerce-input-wrapper').addClass('wrong').removeClass('ok');
				// 	});
				// }

				// function checkWrongClassNames(){
				// 	let arr = [];

				// 	if(document.querySelector('#billing_first_name').value.length < 3){
				// 		arr.push('#billing_first_name');
				// 	}

				// 	if(document.querySelector('#billing_city').value.length < 3){
				// 		arr.push('#billing_city');
				// 	}

				// 	if(document.querySelector('#billing_address_1').value.length < 10){
				// 		arr.push('#billing_address_1');
				// 	}
					
				// 	if(
				// 		isNaN(document.querySelector('#billing_phone').value[15])
				// 		&& document.querySelector('#billing_phone').value[1] !== '9'
				// 	) {
				// 		arr.push('#billing_phone');
				// 	}

				// 	if(
				// 		document.querySelector('#billing_email').value < 1 ||
				// 		(
				// 		(document.querySelector('#billing_email').value[document.querySelector('#billing_email').value.length-1].match(/[a-z]/i) === null)
				// 		// && document.querySelector('#billing_email').value[document.querySelector('#billing_email').value.length-1] === '_'
				// 		&& document.querySelector('#billing_email').value[document.querySelector('#billing_email').value.length-1] === '@'
				// 		&& document.querySelector('#billing_email').value[document.querySelector('#billing_email').value.length-1] === '.'
				// 		&& !isNaN(document.querySelector('#billing_email').value[document.querySelector('#billing_email').value.length-1])
				// 		)
				// 	){
				// 		console.log(' i am here');
				// 		arr.push('#billing_email');
				// 	}
				// 	return arr;
				// }
				


			</script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
			<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>

			<script>
				// $("#billing_first_name").suggestions({
				// 	token: "65d58e1f71cb0d914d348a1e59a2ae774c380e44",
				// 	type: "FIO",
				// 	onSelect: function(suggestion) {
				// 		console.log(suggestion);
				// 		checker(document.querySelector('#billing_first_name'));
				// 	}
				// });
				// $("#billing_email").suggestions({
				// 	token: "65d58e1f71cb0d914d348a1e59a2ae774c380e44",
				// 	type: "EMAIL",
				// 	onSelect: function(suggestion) {
				// 		console.log(suggestion);
				// 		checker(document.querySelector('#billing_email'));
				// 	}
				// });
			</script>
			<style>
				.woocommerce-input-wrapper.wrong,
				.woocommerce-invalid .woocommerce-input-wrapper {
					border-color: red;
				}
				/* .woocommerce-input-wrapper.ok {
					border-color: #1F9E3B;
				} */
				/* .woocommerce-input-wrapper.ok:after {
					background-image: url("data:image/svg+xml,%3Csvg width='14' height='11' viewBox='0 0 14 11' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.08324 10.2491C5.08274 10.2496 5.08192 10.2496 5.08142 10.2491L1.21171 6.29891C0.861873 5.94179 0.861874 5.37047 1.21171 5.01336C1.57178 4.64581 2.1635 4.64569 2.52371 5.01308L5.08324 7.62361L5.08233 7.62454L12.1405 0.419651C12.5006 0.0520623 13.0924 0.0520639 13.4525 0.419653C13.8023 0.776684 13.8023 1.34787 13.4525 1.70492L6.36788 8.93773L5.08324 10.2491Z' fill='%231F9E3B'/%3E%3C/svg%3E%0A");
					content:'';
					position: absolute;
					width: 14px;
					height: 11px;
					right: 16px;
				} */
				.woocommerce-error {
					display: none;
				}
			</style>

		<?php endwhile; ?>

	<?php endif; ?>

	</div>
<?php
get_footer();