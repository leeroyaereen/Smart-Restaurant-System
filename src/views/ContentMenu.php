<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="../CSS/PageStructure.css" />
		<link rel="stylesheet" href="../CSS/ContentMenu.css" />
	</head>

		<div id="MenuHeader" class="section Header">
			<div id="MenuHeaderTitle" class="HeaderTitle">Menu</div>
			<div id="MenuHeaderTable" class="HeaderSubTitle">Customer Name: Ram Nepali</div>
			<div id="searchBoxContainer">
				<form action="">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="#545F71"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="icon icon-tabler icons-tabler-outline icon-tabler-search"
					>
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
						<path d="M21 21l-6 -6" />
					</svg>
					<input type="text" name="" id="" />
				</form>
				<i class="fa fa-search"></i>
			</div>
			<!-- <div id="foodCategoryList">
				<div id="foodCategory">Momo</div>
				<div id="foodCategory">Snacks</div>
				<div id="foodCategory">Lunch</div>
				<div id="foodCategory">Cold drink</div>
				<div id="foodCategory">Combo 1</div>
			</div> -->
			
			<?php
			DeployFoodCategory();
			?>
			
		</div>
		<div id="MenuItemList" class="section Body">
			<?php
				DeployFoodItems();
			?>
		</div>
		<div id="OrderOverview" class="section Footer">
			<div id="OrderDetails">
				<div id="OrderCostBlock">Total: <span id="OrderCost">Rs 10132</span></div>
				<div id="OrderTimeBlock">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="icon icon-tabler icons-tabler-outline icon-tabler-clock"
					>
					
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
						<path d="M12 7v5l3 3" />
					</svg>
					<span id="OrderTime">30 min</span>
				</div>
			</div>
			<div id="OrderButton" class="DefaultOrderButton">
				<button>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="#ffffff"
						class="icon icon-tabler icons-tabler-filled icon-tabler-circle-plus"
					>
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<path
							d="M4.929 4.929a10 10 0 1 1 14.141 14.141a10 10 0 0 1 -14.14 -14.14zm8.071 4.071a1 1 0 1 0 -2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0 -2h-2v-2z"
						/>
					</svg>
					<span>ORDER NOW</span>
				</button>
			</div>
		</div>
	</body>
</html>
