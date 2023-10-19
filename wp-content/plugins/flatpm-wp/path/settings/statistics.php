<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function getRandIntArray( $n, $min = 100, $max = 500 ){
	$range = range( $min, $max );
	shuffle( $range );
	return array_slice( $range, 0, $n );
}

function getLastNDays( $days, $format = 'd.m' ){
	$d = date('d');
	$m = date('m');
	$y = date('Y');
	$dateArray = array();
	for( $i = 0; $i <= $days - 1; $i++ ){
		$dateArray[] = date( $format, mktime( 0, 0, 0, $m, ( $d - $i ), $y ) );
	}
	return array_reverse( $dateArray );
}
?>
<main class="row">
	<div class="container col s12">
		<h1>Статистика показов и кликов</h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<div class="main col s12 white">
		<div class="top-controls row" style="padding-top:0">
			<div class="input-field col">
				<select name="period" id="period">
					<option value="" disabled selected>Выберите</option>
					<option value="week">Неделя</option>
					<option value="1month">Месяц</option>
					<option value="3month">Три месяца</option>
					<option value="other">Свой период</option>
				</select>
				<label>Период:</label>
			</div>

			<div class="date-from input-field col">
				<input type="text" class="datepicker" id="date-from" name="date-from" disabled>
				<label for="date-from">Начиная с:</label>
			</div>
			<div class="date-to input-field col">
				<input type="text" class="datepicker" id="date-to" name="date-to" disabled>
				<label for="date-to">Заканчивая до:</label>
			</div>

			<div class="input-field col">
				<button class="btn waves-effect waves-light">Применить</button>
			</div>
		</div>

		<div class="row">
			<div class="statistics-chart">
				<?php
				$days = 7;
				$labels = htmlspecialchars( json_encode( getLastNDays( $days ) ), ENT_QUOTES, 'UTF-8' );

				$values = [
					[
						'label' => 'Label #1',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #2',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #3',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #4',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #5',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #6',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #7',
						'values' => getRandIntArray( $days ),
					],
					[
						'label' => 'Label #8',
						'values' => getRandIntArray( $days ),
					],
				];
				?>
				<canvas
					data-values="<?php echo htmlspecialchars( json_encode( $values ), ENT_QUOTES, 'UTF-8' ); ?>"
					data-labels="<?php echo $labels; ?>"
				></canvas>
			</div>
		</div>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>