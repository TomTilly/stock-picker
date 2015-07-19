<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Stock Picker in PHP</title>
        <link href="styles/main.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
		<form method="POST" action="index.php">
			<h1>Stock Picker</h1>
			<p>Specify a list of stock prices, one for each hypothetical day. This stock picker will calculate the best day to buy and the best day to sell. Format your entry as a comma separated list of numbers. For exampe: "3, 8, 23, 1, 2, &#91;etc&hellip;&#93;" Each price corresponds with a day, and is separated from the next day by a comma.</p>
			<div>
				<label for="stock_input">Stocks: </label><input type="text" name="stock_input" id="stock_input" maxlength="60" />
			</div>
			<div class="center_content">
				<button>Submit</button>
			</div>
		</form>
		<div>
			<?php
				if($_SERVER['REQUEST_METHOD'] === 'POST'){			// If form has been submitted
					if(empty($_POST['stock_input'])){				// Check if text input is empty
						echo "<p>Input was blank. Please enter a list of comma separated values</p>";
					} else {			// If text input is not empty
						$stock_input = trim($_POST['stock_input']);		// Remove white space from input
						$stock_input = str_replace(' ', '', $stock_input);		// Remove any spaces from input
						$stock_input = str_replace(',0',',',$stock_input);		// Remove any unnecessary 0s following commas
						$regular_expression = '/^\d+(?:,\d+)*,?$/';			// A regular expression to match the correct input, which is [number][comma][number][comma]etc...
						if(preg_match($regular_expression, $stock_input)){	// Check if input follows correct format
							$stock_input = explode(",", $stock_input);		// Turn user input into an array
							if(count($stock_input) < 2 || $stock_input[1] === ''){	// Check if user input only one number (also catches if a user inputs a number and one comma, which results in an array with two elements, one of which is empty)
								echo "<p>Please enter more than one value</p>";
							} else {		// User has input enough elements, calculate the best day to buy and the best day to sell
								// Print out a table of all the data the user entered
								echo "<table><tr><th>Day</th><th>Price</th></tr>";
								foreach($stock_input as $key => $value){
									$key += 1;
									$value = number_format($value);
									echo "<tr><td>Day $key</td><td>\$$value</td></tr>";
								}
								echo "</table>";
								/* The following code cycles through each element in the array,
								** and compares it against every element that follows it.
								** If the element that follows it is greater, 
								** the difference is calculated (this represents
								** the profit that can be made by buying on the originating
								** element's day, and selling on the succeeding element's
								** day). If the difference is greater
								** than the largest difference found thus far in the loop, this is
								** the best day to buy and sell.
								** $greatest_difference is used to kep track of the greatest
								** difference in the elements. The keys of the corresponding elements
								** are assigned to the $best_day_to_buy_key and
								** $best_day_to_sell_key variables.
								*/
								for($i = 0; $i < count($stock_input); $i++){	// Cycle through each index in the array
									for($j = $i + 1; $j < count($stock_input); $j++){	// Cycle through each succeeding element in the array
										if($stock_input[$i] < $stock_input[$j]){	// If the value of succeeding element is greater than starting element, a profit can be made
											$difference = $stock_input[$j] - $stock_input[$i];		// Calculate the difference (profit) between the two elements
											if(isset($greatest_difference)){		// If a difference has already been found previously
												if($difference > $greatest_difference){			// If the current difference is greater than the greatest difference found, this is the new greatest difference
													$greatest_difference = $difference;			// Record new greatest difference
													$best_day_to_buy_key = $i;					// Record best day to buy key
													$best_day_to_sell_key = $j;					// Record best day to sell key
												}
											} else {		// If a difference has not already been found
												$greatest_difference = $difference;		// Make the current difference the greatest difference for future elements to compare against
												$best_day_to_buy_key = $i;				// Record best day to buy key
												$best_day_to_sell_key = $j;				// Record best day to sell key
											}
										}
									}
								}
								if (empty($greatest_difference)){			// If none of the succeeding elements were greater than prior elements, there is no way to profit and $greatest_difference is empty
									echo "<p>There is no way to profit from this stock.";
								} else {		// If a profit can be turned
								$best_day_to_buy = $best_day_to_buy_key + 1;	// Add one to the $best_day_to_buy_key to start counting the days at 1 (rather than 0)
								$best_day_to_sell = $best_day_to_sell_key + 1;	// Add one to the $best_day_to_sell_key to start counting the days at 1 (rather than 0)
								$stock_input[$best_day_to_buy_key] = number_format($stock_input[$best_day_to_buy_key]);		// Format the price for the best day to buy
								$stock_input[$best_day_to_sell_key] = number_format($stock_input[$best_day_to_sell_key]);	// Format the price for the best day to sell
								$greatest_difference = number_format($greatest_difference);		// Format the profit to be turned
								// Output the best day to buy and sell, along with the corresponding buy and sell prices, and the profit to be turned.
								echo "The best day to buy is on day $best_day_to_buy, when the value is \$$stock_input[$best_day_to_buy_key]. The best day to sell is on day $best_day_to_sell, when the  value is \$$stock_input[$best_day_to_sell_key]. Your profit would be \$$greatest_difference.";
								}
							}
						} else {  // If the user did not format their input correctly
						echo "<p>Format was incorrect. Please enter a comma separated list of integers, such as \"3, 4, 12, 8, 30, etc... \".</p>";
						}
					}
				}
			?>
		</div>
        <footer>
            &copy; 2015 Tom Tillistrand
        </footer>
        <script src="scripts/main-script.js" type="text/javascript"></script>
    </body>
</html>