<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendo Machine</title>
    <style>
        fieldset {
            width: 500px; 
            padding: 10px;
        }
        .inline {
            display: inline-block;
            margin-right: 0px; 
        }
        .error {
            color: black;
        }
    </style>
</head>
<body>
<?php
// Initialize variables
$purchaseSummary = '';
$totalPrice = 0;
$totalQuantity = 0; // Initialize total quantity
$errorMessage = ''; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected products
    $products = [
        'chkCoke' => ['name' => 'Coke', 'price' => 15],
        'chkSprite' => ['name' => 'Sprite', 'price' => 20],
        'chkRoyal' => ['name' => 'Royal', 'price' => 20],
        'chkPepsi' => ['name' => 'Pepsi', 'price' => 15],
        'chkMountainDew' => ['name' => 'Mountain Dew', 'price' => 20]
    ];

    // Check if at least one product is selected
    $isProductSelected = false;
    foreach ($products as $key => $product) {
        if (isset($_POST[$key])) {
            $isProductSelected = true;
            break;
        }
    }

    if (!$isProductSelected) {
        $errorMessage = 'No Selected Product, Try Again'; 
    } else {
        // Initialize an array to hold order items
        $orderItems = [];
        $size = $_POST['drpdwnsize']; // Get selected size

        // Calculate total price based on selected products
        foreach ($products as $key => $product) {
            if (isset($_POST[$key])) {
                $quantity = intval($_POST['numQuantity']);
                $itemPrice = $product['price'];

                // Adjust price based on size selection
                if ($size === 'UpSize') {
                    $itemPrice += 5; // Add ₱5 for Up Size
                } elseif ($size === 'Jumbo') {
                    $itemPrice += 10; // Add ₱10 for Jumbo
                }

                $itemTotal = $itemPrice * $quantity; // Calculate total for this item

                // Determine singular or plural
                $pieceWord = ($quantity === 1) ? 'piece' : 'pieces';
                $orderItems[] = "{$quantity} {$pieceWord} of {$size} {$product['name']} amounting to ₱$itemTotal"; // Add item to order items

                $totalPrice += $itemTotal;
                $totalQuantity += $quantity; // Add quantity to total
            }
        }

        // Display purchase summary
        $purchaseSummary .= "<ul>";
        foreach ($orderItems as $item) {
            $purchaseSummary .= "<li>$item</li>"; // Create list items
        }
        $purchaseSummary .= "</ul>";
        $purchaseSummary .= "Total Number of Items: $totalQuantity<br>"; // Display total number of items
        $purchaseSummary .= "Total Price: ₱$totalPrice";
    }
}
?>

<h2>Vendo Machine</h2>
<form method="post" action="">
    <fieldset>
        <legend>Products:</legend>
        <input type="checkbox" name="chkCoke" id="chkCoke" value="Coke">
        <label for="chkCoke">Coke - ₱15</label><br>
        <input type="checkbox" name="chkSprite" id="chkSprite" value="Sprite">
        <label for="chkSprite">Sprite - ₱20</label><br>
        <input type="checkbox" name="chkRoyal" id="chkRoyal" value="Royal">
        <label for="chkRoyal">Royal - ₱20</label><br>
        <input type="checkbox" name="chkPepsi" id="chkPepsi" value="Pepsi">
        <label for="chkPepsi">Pepsi - ₱15</label><br>
        <input type="checkbox" name="chkMountainDew" id="chkMountainDew" value="MountainDew">
        <label for="chkMountainDew">Mountain Dew - ₱20</label><br>
    </fieldset>

    <fieldset>
        <legend>Options:</legend>
        <label for="drpdwnsize" class="inline">Size:</label>
        <select name="drpdwnsize" id="drpdwnsize" class="inline">
            <option value="Regular">Regular</option>
            <option value="UpSize">Up Size (add ₱5)</option>
            <option value="Jumbo">Jumbo (add ₱10)</option>
        </select>
        <label for="numQuantity" class="inline">Quantity:</label>
        <input type="number" name="numQuantity" id="numQuantity" min="1" value="1" required class="inline">
        <button type="submit" class="inline">Check Out</button>
    </fieldset>
</form>

<?php

if ($errorMessage) {
    echo "<hr>"; 
    echo "<div class='error'>$errorMessage</div>"; // Display error message
}

if ($purchaseSummary) {
    echo "<hr>"; 
    echo "<h3>Purchase Summary:</h3>";
    echo $purchaseSummary;
}
?>
</body>
</html>
