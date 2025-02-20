<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="assets/css/PageStructure.css" />
		<link rel="stylesheet" href="assets/css/ContentMenu.css" />
		<script src="assets/js/config.js.php"></script>
        <script src="assets/js/Universal.js" defer></script>
		<script src="assets/js/ContentMenu.js" defer></script>
		<script src="assets/js/Utilities.js"></script>
	</head>

	<body>
		<div id="MenuHeader" class="section Header">
			<div id="MenuHeaderTitle" class="HeaderTitle">Menu</div>
			<div id="MenuHeaderTable" class="HeaderSubTitle">
				<?php 
					if(isset($_SESSION["firstName"])){
						echo "Welcome ".$_SESSION["firstName"]; 
					}else{
						echo "Welcome Guest";
					}
				?>
			</div>
			<!-- <div id="searchBoxContainer">
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
			</div> -->
			<div id="foodCategoryList">
				<div id="foodCategory" class="selectedCategory">All</div>
				<template id="foodCategoryTemplate" class="hidden-template">
					<div id="foodCategory" class=""></div>
				</template>
			</div>
		</div>
		<div id="MenuItemList" class="section Body">
			<template class="hidden-template" id="MenuItemTemplate">
				<div id="MenuItem">
					<div id="MenuItemImage">
						<img
							src="/Smart-Restaurant-System/public/assets/images/Fried CChowmei27"
							alt=""
							width="95"
							height="95"
							class="ItemImage"
						/>
						<div id="descriptionContainer" class="tooltipContainer">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none"
								stroke="#FE724C"
								stroke-width="2"
								stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"
							>
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
								<path d="M12 9h.01" />
								<path d="M11 12h1v4h1" />
							</svg>
							<span>More info</span>
							<div id="descriptionTooltip" class="tooltip">asd</div>
						</div>
					</div>
					<div id="MenuItemDetails">
						<div id="MenuItemTitle">
							<div id="MenuItemName">Chicken Momo</div>
							<div id="MenuItemRating">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									width="16"
									height="16"
									viewBox="0 0 24 24"
									fill="#FFE607"
									class="icon icon-tabler icons-tabler-filled icon-tabler-star"
								>
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path
										d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z"
									/>
								</svg>
								<span>3.4</span>
							</div>
						</div>
						<div id="MenuItemSubCategory">Fried</div>
						<div id="MenuItemPrice" class="ItemPrice">Rs <span>220</span></div>
						<div id="MenuItemFooter" class="ItemFooter">
							<div id="MenuItemDuration">
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
								<span>10 mins</span>
							</div>
							<div id="MenuItemQuantity" class="ItemQuantity">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									width="45"
									height="45"
									viewBox="0 0 24 24"
									fill="none"
									stroke="#FE724C"
									stroke-width="1"
									stroke-linecap="round"
									stroke-linejoin="round"
									class="icon icon-tabler icons-tabler-outline icon-tabler-circle-minus"
								>
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
									<path d="M9 12l6 0" />
								</svg>
								<span>00</span>
								<svg
									xmlns="http://www.w3.org/2000/svg"
									width="45"
									height="45"
									viewBox="0 0 24 24"
									fill="#FE724C"
									class="icon icon-tabler icons-tabler-filled icon-tabler-circle-plus"
								>
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path
										d="M4.929 4.929a10 10 0 1 1 14.141 14.141a10 10 0 0 1 -14.14 -14.14zm8.071 4.071a1 1 0 1 0 -2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0 -2h-2v-2z"
									/>
								</svg>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>
		<div id="OrderOverview" class="section Footer">
			<div id="OrderDetails">
				<div id="OrderCostBlock">
					Total: <span id="OrderCost">Rs 0</span>
				</div>
				<!-- <div id="OrderTimeBlock">
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
				</div> -->
			</div>
			<div id="OrderButton" class="DefaultOrderButton" style="background-color: green;">
				<button style="background-color:green;">
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
