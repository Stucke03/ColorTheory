// 4.1 - Input form 
/* Rows and Columns: One number that sets both the number of rows and columns. Must be between 1 and 26.
Number of Colors: How many colors to show. Must be between 1 and 10.
A submit button that generates the tables below. */

//4.2 Input Validation
/* If Rows and Columns is less than 1 or more than 26, show an error message on the page.
If the number of Colors is less than 1 or more than 10, show a separate error message on the page.
Both inputs are validated separately. You can show up to 2 error messages at the same time.
Do NOT use a browser alert() popup. The error must show on the page itself.
If both inputs are valid, generate the two tables below. */

//4.3 Top Table: Color List 
/* 
This table shows the colors the user has selected. Here are the rules:

The table has 2 columns and as many rows as the number of colors the user entered.
The left column is 20% of the table width. It contains a dropdown menu for each color.
The right column is 80% of the table width. You can use this for the color name or a color preview.
The table spans most of the width of the page.
There is no header row on this table.
Each dropdown must contain these 10 color options in this order:

Red, Orange, Yellow, Green, Blue, Purple, Grey, Brown, Black, Teal
Dropdown rules:

Each dropdown must start with a different color selected. No two dropdowns can show the same color at the same time.
If a user changes a dropdown to a color that is already selected in another dropdown, revert that dropdown back to its previous value automatically.
Show the user a gentle message on the page (not a pop-up) telling them the color is already in use.
*/

//4.4 Bottom Table: Coordinate Grid
/* This is a grid table that looks like a spreadsheet. Here are the rules:

The table size is (n+1) rows by (n+1) columns, where n is the number the user entered. For example, if you enter 3, your table will be 4 rows by 4 columns. If you enter 26, your table will be 27 rows by 27 columns. The extra row and column are for the letter and number labels.
The table is always square. All cells must have equal height and width.
The upper leftmost cell is empty.
The remaining cells across the top row are labeled with capital letters in alphabetical order, starting with A and going to Z. The maximum size is 26, so the last possible column label is Z.
The cells in the leftmost column are numbered starting in the second row with 1 and numbering each row consecutively going down.
All other cells in the grid are empty. */

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
</body>

</html>