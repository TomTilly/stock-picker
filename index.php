<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Stock Picker in PHP</title>
        <link href="styles/main.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
		<form method="GET" action="index.php">
			<h1>Stock Picker</h1>
			<p>Specify a list of stock prices, one for each hypothetical day. This stock picker will calculate the best day to buy and the best day to sell. Format your entry as follows: "3, 8, 23, 1, 2, &#91;etc&hellip;&#93;" Each price corresponds with a day, and is separated from the next day by a comma.</p>
			<div>
				<label for="stock_input">Stocks: </label><input type="text" id="stock_input" maxlength="60" />
			</div>
			<div class="center_content">
				<button>Submit</button>
			</div>
		</form>
		<div>
			<?php
				
			?>
		</div>
        <footer>
            &copy; 2015 Tom Tillistrand
        </footer>
        <script src="scripts/main-script.js" type="text/javascript"></script>
    </body>
</html>