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
				if($_SERVER['REQUEST_METHOD'] === 'POST')	// Form submitted
				{			
					
					
					// Input cleaning and validation
					$valid_input_flag = 1;
					if(empty($_POST['stock_input']))
					{
						echo "<p>Input was blank. Please enter a list of comma separated values</p>";
						$valid_input_flag = 0;
					}
					else
					{
						$stock_input = trim($_POST['stock_input']);
						$stock_input = str_replace(' ', '', $stock_input);
						$stock_input = str_replace(',0',',',$stock_input);
						$regular_expression = '/^\d+(?:,\d+)*,?$/';			// Pattern matching [number][comma][number][comma]etc...
						if(preg_match($regular_expression, $stock_input))	// Check for correct format
						{	
							$stock_input = explode(",", $stock_input);
							if(count($stock_input) < 2 || $stock_input[1] === '')		// Ensures more than one valid element
							{	
								echo "<p>Please enter more than one value</p>";
								$valid_input_flag = 0;
							}
						}
						else	// Format incorrect
						{  
							echo "<p>Format was incorrect. Please enter a comma separated list of integers, such as \"3, 4, 12, 8, 30, etc... \".</p>";
							$valid_input_flag = 0;
						}		
					}
					
					
					if ($valid_input_flag)	
					{
					
						
						// Print out a table of all the data the user entered
						echo "<table><tr><th>Day</th><th>Price</th></tr>";
						foreach($stock_input as $key => $value)
						{
							$key += 1;
							$value = number_format($value);
							echo "<tr><td>Day $key</td><td>\$$value</td></tr>";
						}
						echo "</table>";
								
								
						// Iterate through every pairing of days and find greatest difference
						$greatest_difference = 0;
						for($i = 0; $i < count($stock_input); $i++)
						{
							for($j = $i + 1; $j < count($stock_input); $j++)
							{
								$difference = $stock_input[$j] - $stock_input[$i];
								if($difference > $greatest_difference)
								{			
									$greatest_difference = $difference;
									$best_day_to_buy_key = $i;
									$best_day_to_sell_key = $j;
								}
							}
						}
								
								
						// Output
						if (!$greatest_difference)	// No profit can be made
						{
							echo "<p>There is no way to profit from this stock.";
						}
						else		// Profit can be made
						{							
							$best_day_to_buy = $best_day_to_buy_key + 1;
							$best_day_to_sell = $best_day_to_sell_key + 1;
							$stock_input[$best_day_to_buy_key] = number_format($stock_input[$best_day_to_buy_key]);
							$stock_input[$best_day_to_sell_key] = number_format($stock_input[$best_day_to_sell_key]);
							$greatest_difference = number_format($greatest_difference);
							echo "<p>The best day to buy is on day $best_day_to_buy, when the value is \$$stock_input[$best_day_to_buy_key]. 
							The best day to sell is on day $best_day_to_sell, when the  value is \$$stock_input[$best_day_to_sell_key]. 
							Your profit would be \$$greatest_difference.</p>";
						}
					}
				}
			?>
		</div>
        <footer>
            &copy; 2015 Tom Tillistrand
        </footer>
    </body>
</html>