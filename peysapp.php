<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>Peys App</title>
    <style>
        img {
            border: 2px solid black; /* Default border color */
            width: 5.08cm; 
            height: 5.08cm; 
        }
    </style>
</head>
<body>
    <h1>Peys App</h1>
    <form action="">
        <label for="selectphosize">Select Photo Size:</label>
        <input type="range" name="selectphosize" id="selectphosize" min="10" max="100" value="60" oninput="updateImageSize(this.value)"><br>

        <label for="pickclr">Pick a Color:</label>
        <input type="color" name="pickclr" id="pickclr"><br>

        <button type="button" onclick="process()">Process</button><br><br>
        <img id="kai" src="kai.jpg" alt=""> 
    </form>

    <script>
        

        // Update the image size based on the range value
        function updateImageSize(size) {
            currentSize = size / 10; 
        }

        // Store the selected color
        document.getElementById('pickclr').addEventListener('input', function() {
            selectedColor = this.value; 
        });

        //click process button
        function process() {
            const image = document.getElementById('kai');
            image.style.width = currentSize + 'cm'; // Update the image width
            image.style.height = currentSize + 'cm'; // Update the image height
            image.style.borderColor = selectedColor; // Update the border color
        }
    </script>
</body>
</html>
