<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package   Bonus_Calculator
 * @subpackage Bonus_Calculator/public/partials
 */

$wagerTypeText = $bonusData["wagerType"] === "bonusOnly" ? $bonus_only : $bonus_deposit;
?>

<div class="bc-container">
	<div class="bc-bonus-calculator">
		<div>
			<label for="bc-deposit"><?php echo esc_html( $deposit_amount ); ?></label>
			<input type="number" id="bc-deposit" min="0" step="1">
		</div>
		<div>
			<label for="bc-bonusAmount"><?php echo esc_html( $bonus_amount ); ?></label>
			<div class="bc-result" id="bc-bonusAmount">0</div>
		</div>
		<div>
			<label for="bc-bankroll"><?php echo esc_html( $bankroll ); ?></label>
			<div class="bc-result" id="bc-bankroll">0</div>
		</div>
	</div>
	<div id="bc-wagerMessage"></div>
	<a id="bc-ctaButton" href="<?php echo esc_html( $bonusData["ctaLink"] ); ?>" class="bc-cta-button" rel="nofollow"
		target="_blank"><?php echo esc_html( $cta_text ); ?></a>
	<div class="bc-details-box" id="bc-bonusDetails">
		<p><?php echo esc_html( $percentage ); ?>: <?php echo esc_html( $bonusData["percentage"] ); ?></p>
		<p><?php echo esc_html( $wager ); ?>: <?php echo esc_html( $bonusData["wager"] ); ?>x +
			<?php echo esc_html( $wagerTypeText ); ?>
		</p>
		<p><?php echo esc_html( $min_deposit ); ?>: <?php echo esc_html( $bonusData["minDeposit"] ); ?>€</p>
		<p><?php echo esc_html( $min_odd ); ?>: $<?php echo esc_html( $bonusData["minOdd"] ); ?></p>
		<p><?php echo esc_html( $max_bonus ); ?>: <?php echo esc_html( $bonusData["maxBonus"] ); ?>€</p>
	</div>
</div>


<script>
	const bonusData = <?php echo json_encode( $bonusData ); ?>;

	const bonusMessage = (wagerAmount) => `<?php echo $bonus_message ?>`.replace('{wageramount}', wagerAmount.toFixed(2));
	const bonusErrorMessage = (amountNeeded) => `<?php echo $bonus_error_message ?>`.replace('{amountneeded}', amountNeeded.toFixed(2));

	function calculate() {
		const depositField = document.getElementById('bc-deposit');
		const deposit = parseFloat(depositField.value);
		const bonusPercentage = parseFloat(bonusData.percentage) / 100;
		const wagerMultiplier = parseFloat(bonusData.wager);
		const wagerType = bonusData.wagerType;
		const minDeposit = parseFloat(bonusData.minDeposit);
		const minOdd = parseFloat(bonusData.minOdd);
		const maxBonus = parseFloat(bonusData.maxBonus);

		if (isNaN(deposit) || deposit < 0) {
			alert("Please fill in a valid deposit amount.");
			return;
		}

		let bonus = 0;
		let bankroll = deposit;
		let wagerAmount = 0;

		if (deposit < minDeposit) {
			const amountNeeded = minDeposit - deposit;
			document.getElementById('bc-wagerMessage').innerHTML = `<span class="bc-error">${() => bonusErrorMessage(amountNeeded)}</span>`;
		} else {
			bonus = deposit * bonusPercentage;
			if (bonus > maxBonus) {
				bonus = maxBonus;
			}
			bankroll += bonus;
			wagerAmount = wagerType === "bonusOnly" ? bonus * wagerMultiplier : (deposit + bonus) * wagerMultiplier;
			document.getElementById('bc-wagerMessage').innerHTML = bonusMessage(wagerAmount);
		}

		document.getElementById('bc-bonusAmount').innerHTML = `€${bonus.toFixed(2)}`;
		document.getElementById('bc-bankroll').innerHTML = `€${bankroll.toFixed(2)}`;

		const ctaButton = document.getElementById('bc-ctaButton');
		ctaButton.classList.add('bc-pulse');

		setTimeout(() => ctaButton.classList.remove('bc-pulse'), 1000);
	}

	document.getElementById('bc-deposit').addEventListener('input', calculate);
	document.getElementById('bc-deposit').value = bonusData.minDeposit;

	calculate();
</script>