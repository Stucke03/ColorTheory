<!-- Modern-looking design with your company name and logo.
A welcome message explaining what the site is about.
Navigation links to all other pages on the site.-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ColorTheory homepage</title>
    <meta name="authors" content="Nathan Stucke, Morgan Mitchell">
    <meta name="description" content="A homepage for the ColorTheory website">
    <meta name="keywords" content="Webpage, HTML5, Nathan Stucke, Morgan Mitchell, ColorTheory, CS312, Web Development, Colorado State University">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src=assets/nav-logo.png width="500">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="color.php">Color Coordinates</a>
    </header>
    <hr>
    <main>
        <style>
            .square-outer {
            height: 50vh;
            width: 120vh;
            background-color: white;
            bottom: 0;
            position: fixed;
            }
            .square-middle-out {
            background-color: #EB8258;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            height: 100%;
            width: 98%;
            }
            .square-middle-in {
            background-color: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            height: 100%;
            width: 90%;
            }

            .oval-outer {
            height: 500px;
            width: 120vh;
            background-color: white;
            position: fixed;
            border-radius: 50%;
            bottom: 18%;
            }
            .oval-middle-out {
            height: 95%;
            width: 98%;
            background-color: #EB8258;
            position: absolute;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            }
            .oval-middle-in {
            height: 95%;
            width: 98%%;
            background-color: white;
            position: absolute;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            }
        </style>
        <div class="oval-outer">
            <div class="oval-middle-out">
                <div class="oval-middle-in"></div>
            </div>
        </div>
        <div class="square-outer">
            <div class="square-middle-out">
                <div class="square-middle-in"></div>
            </div>
        </div>
        
    </main>
</body>

</html>