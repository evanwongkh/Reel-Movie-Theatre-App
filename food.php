<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "movietheatre";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$AccID = $_SESSION['AccID'];

if (isset($_POST['submit'])) {
    $name = $_POST['food'];
    $quantity = $_POST['quantity'];
    $price = $quantity * 10;

    // Insert order into database
    $sql = "INSERT INTO food (AccID, name, price) VALUES ('$AccID', '$name', '$price')";

    if (mysqli_query($conn, $sql)) {
        $message = "Order placed successfully.";
    } else {
        $error = "Error placing order: " . mysqli_error($conn);
    }
}

if (isset($_POST['cancel'])) {
    $OrderNumber = $_POST['OrderNumber'];

    // Delete order from database
    $sql = "DELETE FROM food WHERE OrderNumber=$OrderNumber";
    mysqli_query($conn, $sql);
}

$sql = "SELECT * FROM food WHERE AccID = '$AccID' ";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <title>Food Menu</title>
</head>

<style>
    
	html {
		margin: 0;
		padding: 0;
	}

    :root{
        font-family: 'Quicksand', sans-serif;
        font-size: 20px;
    }

    body{
        color: white;
		margin: 0;
		padding: 0;
		width: 100vw;
    	height: 100vh;
    	background-image: linear-gradient(135deg, rgba(20, 20, 20, 1) 0%, rgba(40, 40, 40, 1) 40%, rgba(20, 20, 20, 1) 80%);
		overflow-x: hidden;

    }

	body::-webkit-scrollbar{
		width: 1rem;
	}

	body::-webkit-scrollbar-thumb{
		background: #911fff;
	}

	body::-webkit-scrollbar-track{
		background: #fffbff;
	}

    .unique{
		justify-content: center;
		align-items: center;
		margin-left: 6rem;
		padding-top: 0.1vh;
		text-decoration: none;
    }

	.menu{
		width: 5rem;
		height: 100vh;
		position: fixed;
		background-color: #1e003f;
		transition: 0.2s ease;
		z-index: 1;
	}

	.menuBar{
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding: 0;
		margin: 0;
		height: 100%;
		list-style: none;
	}

	.menuButton{
		width: 100%;
	}

	.menuButton:last-child{
		margin-top: auto;
	}

	.menuText{
		display: flex;
		align-items: center;
		height: 4.5rem;
		color: #fff;
		text-decoration: none;
		transition: 0.2s;
		width: 100%;
	}

	.menuText2{
		display: flex;
		align-items: center;
		height: 6rem;
		justify-content: center;
		color: #fff;
		text-decoration: none;
		transition: 0.3s;
		
	}

	.menuText2:hover{
		background: #df93ff;
		color: white;
		text-shadow: 0 0 10px #5b0e91;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
		width: 100%;
	}

	.menuText:hover{
		background: #b8b6b9;
		color: black;
		width: 100%;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
	}

	.menuLinkText{
		display: none;
		margin-left: 0.5rem;
	}

	.menuText svg{
		min-width: 2.9rem;
		min-height: 2.9rem;
		margin-left: 1rem;
	}

	.menu:hover{
		width: 14rem;
	}

	.menu:hover .menuLinkText{
		display: block;
	}

	path {
		fill: #911fff;
	}

	.title{
		font-weight: bold;
		margin-bottom: 1rem;
		text-align: center;
		justify-content: center;
		background: #15002c;
		color: black;
		font-size: 50px;
		letter-spacing: 10px;
		width: 100%;
	}
</style>

<body>

<div class="cursorGlow"></div>
	<nav class="menu">
		<ul class ="menuBar">
			<li class="title">
				<a href="dashboard.php" class="menuText2">
				<span class="menuLinkText">REEL</span>
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="150pt" height="150pt" version="1.1" viewBox="0 0 700 550">
					<path xmlns="http://www.w3.org/2000/svg" d="m474.04 274.4-120.12-108.86c-2.2695-2.0117-5.6836-2.0117-7.9531 0l-120.01 108.86c-2.2656 1.4297-3.2031 4.2656-2.2344 6.7617 0.96875 2.5 3.5742 3.9609 6.2109 3.4883h22.398v106.4c0.03125 3.2578 2.6797 5.8828 5.9375 5.8828h51.91c1.5352 0 3.0039-0.62891 4.0625-1.7383 1.0586-1.1133 1.6133-2.6094 1.5391-4.1445v-67.758c-0.019531-1.6289 0.64062-3.1953 1.8164-4.3203 1.1797-1.125 2.7734-1.7109 4.3984-1.6172h56.281c1.5664 0 3.0703 0.62891 4.1758 1.7422s1.7188 2.625 1.7031 4.1953v67.703c-0.078125 1.5312 0.48047 3.0312 1.5391 4.1406 1.0586 1.1133 2.5273 1.7422 4.0625 1.7383h52.078c1.5352 0.003906 3.0039-0.625 4.0625-1.7383 1.0586-1.1094 1.6133-2.6094 1.5391-4.1406v-106.4h22.398c2.6484 0.57031 5.3281-0.83594 6.3633-3.3398 1.0312-2.5078 0.12109-5.3945-2.1641-6.8555z"/>

				</svg>
				</a>

			</li>
			<li class="menuButton">
				<a href="mytickets.php" class="menuText">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32pt" height="32pt" version="1.1" viewBox="0 0 700 550">
					<path xmlns="http://www.w3.org/2000/svg" d="m618.62 142.62v-22.75h-537.25v22.75c8.75 0 15.75 7.875 15.75 16.625s-7 16.625-15.75 16.625v27.125c8.75 0 15.75 7.875 15.75 16.625s-7 16.625-15.75 16.625v27.125c8.75 0 15.75 7.875 15.75 16.625s-7 16.625-15.75 16.625v27.125c8.75 0 15.75 7.875 15.75 16.625s-7 16.625-15.75 16.625v27.125c8.75 0 15.75 7.875 15.75 16.625s-7 16.625-15.75 16.625v22.75h536.38v-22.75c-8.75 0-15.75-7.875-15.75-16.625s7-16.625 15.75-16.625v-27.125c-8.75 0-15.75-7.875-15.75-16.625s7-16.625 15.75-16.625v-27.125c-8.75 0-15.75-7.875-15.75-16.625s7-16.625 15.75-16.625v-27.125c-8.75 0-15.75-7.875-15.75-16.625s7-16.625 15.75-16.625v-27.125c-8.75 0-15.75-7.875-15.75-16.625s7-15.75 16.625-16.625zm-76.125 232.75c0 16.625-14 30.625-30.625 30.625h-323.75c-16.625 0-30.625-14-30.625-30.625v-190.75c0-16.625 14-30.625 30.625-30.625h323.75c16.625 0 30.625 14 30.625 30.625z"/>
					<path xmlns="http://www.w3.org/2000/svg" d="m511.88 172.38h-323.75c-7 0-12.25 5.25-12.25 12.25v189.88c0 7 5.25 12.25 12.25 12.25h323.75c7 0 12.25-5.25 12.25-12.25v-189.88c0-6.125-5.25-12.25-12.25-12.25z"/>
				</svg>
					<span class="menuLinkText">Tickets</span>
				
				</a>
			</li>
			<li class="menuButton">
				<a href="food.php" class="menuText">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32pt" height="32pt" version="1.1" viewBox="0 0 700 550">
					<path xmlns="http://www.w3.org/2000/svg" d="m579.18 156.28-93.43 101.39c-0.11719 0.11719-0.24609 0.23047-0.375 0.34766-15.602 15.371-35.918 23.051-56.246 23.051-12.125 0-24.258-2.7344-35.387-8.2031l-80.078 80.078 5.8906 5.8906-144.52 144.52c-5.8477 5.8477-13.281 9.1328-20.922 9.8672-1.0938 0.10547-2.1914 0.15625-3.293 0.15625-0.54297 0-1.0938-0.011718-1.6367-0.039062-3.2812-0.15625-6.5469-0.78516-9.6836-1.8828-0.51953-0.17969-1.043-0.37891-1.5586-0.58984-4.1172-1.6758-7.9805-4.1758-11.324-7.5195s-5.8477-7.2031-7.5195-11.324c-0.20703-0.50781-0.41016-1.0312-0.58984-1.5586-1.0977-3.1367-1.7266-6.3945-1.8828-9.6836-0.078125-1.6406-0.039063-3.2891 0.11719-4.9219 0.72656-7.6328 4.0195-15.07 9.8672-20.922l144.51-144.51 5.8906 5.8906 80.078-80.078c-14.711-29.949-9.6367-67.16 15.27-92.074l0.035156 0.035156 101.35-93.367c3.125-3.125 6.6289-4.2227 9.6602-4.2227 2.9961 0 5.5312 1.0703 6.7773 2.3125l-106.51 106.51 0.011719 0.011719 106.5-106.5c2.4961 2.4961 4.3008 10.227-1.9023 16.438l-93.371 101.31 22.941 22.941 101.32-93.367c3.125-3.125 6.6289-4.2227 9.6602-4.2188 2.9961 0 5.5312 1.0703 6.7773 2.3125l-106.5 106.51 0.011719 0.011718 106.51-106.51c2.4961 2.4961 4.3008 10.227-1.9023 16.438l-93.375 101.32 22.977 22.977 101.32-93.363c3.125-3.125 6.6289-4.2227 9.6602-4.2188 2.9961 0 5.5312 1.0703 6.7773 2.3125l-106.51 106.51 0.011719 0.011719 106.51-106.51c2.4961 2.4922 4.3047 10.223-1.9062 16.43zm-163.96 154.17-5.8984 5.8984-16.277-16.277-36.617 36.617 16.273 16.273-5.8906 5.8906 144.51 144.51c13.367 13.367 35.039 13.363 48.406 0 13.367-13.367 13.363-35.039 0-48.406zm-138.44-20.371 53.145-53.145-16.289-16.289-104.12-104.11c-10.668-10.668-41.137-33.93-54.168-22.16-0.003906 0.003906-0.015624 0.015625-0.015624 0.015625-22.77 22.832 8.125 90.68 69.02 151.57 17.309 17.316 35.184 32.195 52.426 44.113z"/>
				</svg>
					<span class="menuLinkText"> Food</span>
				</a>
			</li>

			<li class="menuButton">
				<a href="#" class="menuText">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32pt" height="32pt" version="1.1" viewBox="0 0 700 750">
					<path xmlns="http://www.w3.org/2000/svg" d="m350 248.52c-68.652 0-124.31 55.625-124.31 124.29 0 68.641 55.652 124.29 124.31 124.29 68.641 0 124.29-55.652 124.29-124.29 0.015625-68.664-55.641-124.29-124.29-124.29zm44.906 193.41-44.906-23.602-44.922 23.602 8.5859-50.027-36.348-35.414 50.227-7.293 22.457-45.508 22.453 45.492 50.227 7.293-36.348 35.414z"/>
				</svg>
					<span class="menuLinkText"> Promotions</span>
				</a>
			</li>

			<li class="menuButton">
				<a href="logout.php" class="menuText">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32pt" height="32pt" version="1.1" viewBox="0 0 700 550">
					<path xmlns="http://www.w3.org/2000/svg" d="m490 140c0 77.32-62.68 140-140 140s-140-62.68-140-140 62.68-140 140-140 140 62.68 140 140"/>
					<path xmlns="http://www.w3.org/2000/svg" d="m451.85 281.93c-29.652 21.477-65.328 33.039-101.94 33.039-36.613 0-72.289-11.562-101.94-33.039-52.422 20.512-97.445 56.344-129.19 102.83-31.75 46.484-48.75 101.46-48.785 157.75 0 4.6406 1.8438 9.0938 5.125 12.375s7.7344 5.125 12.375 5.125h525c4.6406 0 9.0938-1.8438 12.375-5.125s5.125-7.7344 5.125-12.375c-0.050781-56.312-17.074-111.3-48.855-157.79-31.781-46.484-76.84-82.309-129.29-102.79z"/>
				</svg>
					<span class="menuLinkText">Logout</span>
				
				</a>
			</li>
		</ul>
	</nav>

    <div class="unique">

	<div class="regText">
		Welcome, <?php echo $_SESSION['username']; ?>! Book your movie and showtime today!
	</div>
    <h3>Food Menu</h3>
    <?php if (isset($message)) echo "<p style='color:green'>$message</p>" ?>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>" ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="food">Food Item:</label>
        <select name="food" id="food" required>
            <option value="">--Select--</option>
            <option value="Burger">Burger</option>
            <option value="Pizza">Pizza</option>
            <option value="Fries">Fries</option>
            <option value="Salad">Salad</option>
        </select>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required>
        <br>
        <input type="submit" name="submit" value="Order">
    </form>

    <h3>Ordered Food</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Food Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['OrderNumber']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Price']; ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="OrderNumber" value="<?php echo $row['OrderNumber']; ?>">
                            <input type="submit" name="cancel" value="Cancel">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
            </div>

</body>

</html>