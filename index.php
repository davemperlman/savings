<?php
// Sets the default time zone
date_default_timezone_set('America/New_York');
$days = array('Monday', 'Tuesday', 'Wedesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$parsed_date_input = date('z', strtotime("$_GET[day] jan" . date('Y'))) + 1;

// Determines if current year is a leap year, and then determines the number of remaining days selected in the current year
if ( date('L') == true ) {
	$days_remain = floor((366 - $parsed_date_input)/7);
} else {
	$days_remain = floor((365 - $parsed_date_input)/7);
}

// Loops through remaining days, checks if the odd (every other week) box is checked and then filters through the data accordingly
for ($i = 1; $i <= $days_remain ; $i++) { 
	if ( isset($_GET['odd']) ) {
		if ($i % 2 == 0 ) {
			$money += $i;
		}
	} else {
		$money += $i;
	}
}

// Applies the multiplier to the money factor
isset($_GET['multiplier']) ? $money = $money * $_GET['multiplier'] : $money = $money;
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="_css/style.css">
		<title>Weekly Savings Project</title>
	</head>
	<body>
		<h1>This is Week <?php echo date('W'); ?> of the Current Year.</h1>
		<p>This is a variation on a popular savings challenge shared by many on social media. The challenege, which achieved popularity sometime during the past couple years, is straightforward - you put money into your savings account each week equal to the current week number of the year. Week 1 you put 1 dollar away while week 52 you'd put 52 dollars away.</p>
		<p>In my variation of this project, you can adjust for which day of the week you'd like to start saving on. This is important because 6 of the 7 days of the week only have 51 occurences, not 52, which affects the final outcome slightly. This variation also includes provisions for accounting for the leap year, which can also impact the final outcome. I've also included an input that will change your weekly contribution to biweekly.</p>
		<form method="get">
			<label for="day">Contribution Day</label>
			<select name="day" id="day">
				<?php foreach ($days as $day => $value): ?>
					<option value="<?php
						preg_match('/\w../', $value, $matches); echo strtolower($matches[0]); ?>" <?php echo $_GET['day'] == strtolower($matches[0]) ? "selected='selected'" : ''; ?>>
						<?php echo $value; ?>
					</option>
				<?php endforeach ?>
			</select>
				<div id="daytips" class="tooltips">
					<p>Select the day of the week you're likely to set the money aside - pay day, day you happen to run to the bank, etc. The day you choose will determine how many weeks you'll be setting aside money for.</p>
				</div>
			<label for="multiplier">Contribution Multiplier</label>
			<input min="1" id="multiplier" name="multiplier" type="number" value='<?php echo $_GET['multiplier']  ?>'>
				<div id="tips" class="tooltips">
					<p>In this field, you can choose to change the amount of money contributed in multiples if you wish to contribute more.</p>
				</div>
			<input type="checkbox" id="odd" name="odd" <?php echo $_GET['odd'] == on ? "checked='checked'" : ''; ?>>
			<label for="odd" id="checkbox-label">
				Biweekly
				<div>&#10004</div>
			</label>
			<input type="submit">
		</form>
		<table>
			<?php for( $i = 1; $i <= $days_remain; $i++): ?>
				<?php if ( $_GET['odd'] == 'on' ): ?>
					<?php if ($i % 2 == 0): ?>
						<tr>
							<td>
								Week <?php echo $i; ?>
							</td>
							<td>
								$<?php echo $i * $_GET['multiplier']; ?>
							</td>
						</tr>
					<?php endif ?>
				<?php else: ?>
				<tr>
					<td>
						Week <?php echo $i; ?>
					</td>
					<td>
						$<?php echo $i * $_GET['multiplier']; ?>
					</td>
				</tr>
			<?php endif ?>
			<?php endfor; ?>
			<tr>
				<th id="total-title">Total</th>
				<td id="total"><?php echo "$" . $money; ?></td>
			</tr>
		</table>
	</body>
</html>