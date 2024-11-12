<?php
require '../PHP/DatabaseUtilities.php';
//initializing as an array
$foodItems = [];
$foodCategories = [];

function FetchMenuContent(){
	//importing the variable from the global scope
	global $foodItems,$foodCategories;

	$conn = DatabaseUtility::GetRestaurantConnectionWithName('ACHS Canteen');
	if(!$conn){
		echo "<script>alert('Error connecting to the database')</script>";
		return false;
	}

	// $sql = "SELECT
	// 		FoodItem.FoodItem_ID,
	// 		FoodItem.FoodName, 
	// 		FoodItem.FoodType, 
	// 		FoodItem.FoodRating, 
	// 		FoodItem.FoodPreparationTime,
	// 		FoodItem.FoodReview, 
	// 		FoodItem.FoodDescription, 
	// 		FoodItem.FoodImage, 
	// 		FoodItem.FoodPrice, 
	// 		FoodItem.FoodAvailability, 
	// 		FoodItem.TotalOrders,
	// 		FoodCategory.Category_ID, 
	// 		FoodCategory.CategoryName
	// 	FROM
	// 		FoodItems
	// 	JOIN
	// 		FoodCategory ON FoodItems.Category_ID = FoodCategory.Category_ID;
	// ";

	$sqlFoodItems = "SELECT * FROM FoodItems";
	$sqlFoodCategories = "SELECT * FROM FoodCategory";
	$resFoodItems = $conn->query($sqlFoodItems);
	$resFoodCategories = $conn->query($sqlFoodCategories);

	//incase the query doesnt work
	if(!$resFoodItems){
		echo "<script>alert('Error Fetching the food item data')</script>";
		return false;
	}
	if(!$resFoodCategories){
		echo "<script>alert('Error Fetching the food category data')</script>";
		return false;
	}
	//incase there are no datas available
	if(!$resFoodItems->num_rows>0){
		echo "<script>alert('No Food item data in the database')</script>";
		return false;
	}
	if(!$resFoodCategories->num_rows>0){
		echo "<script>alert('No Food Category data in the database')</script>";
		return false;
	}


	// Fetching all food items
	while ($item = mysqli_fetch_assoc($resFoodItems)) {
		$foodItem = new FoodItem();
		$foodItem->FoodItem_ID = $item['FoodItem_ID'];
		$foodItem->FoodName = $item['FoodName'];
		$foodItem->FoodType = $item['FoodType'];
		$foodItem->FoodCategory = $item['Category_ID'];
		$foodItem->FoodRating = $item['FoodRating'];
		$foodItem->FoodPreparationTime = $item['FoodPreparationTime'];
		$foodItem->FoodReview = $item['FoodReview'];
		$foodItem->FoodDescription = $item['FoodDescription'];
		$foodItem->FoodImage = $item['FoodImage'];
		$foodItem->FoodPrice = $item['FoodPrice'];
		$foodItem->FoodAvailability = $item['FoodAvailability'];
		$foodItem->TotalOrders = $item['TotalOrders'];

		$foodItems[] = $foodItem;
	}

	// Fetching all food categories
	while ($category = mysqli_fetch_assoc($resFoodCategories)) {
		$foodCategories[$category['Category_ID']] = $category['CategoryName'];
	}

	return true;
}

function DeployFoodCategory(){
    global $foodCategories;
	echo "<div id='foodCategoryList'>";
    foreach ($foodCategories as $categoryId => $categoryName) {
        echo "<div class='foodCategory' id='$categoryId'>$categoryName</div>";
    }
	echo "</div>";
}


$res = FetchMenuContent();
if(!$res){
	echo "<script>alert('Error Fetching menu data')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="../CSS/PageStructure.css" />
		<link rel="stylesheet" href="../CSS/ContentMenu.css" />
	</head>
	<body>
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
			<div id="MenuItem">
				<div id="MenuItemImage">
					<img
						src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
						alt=""
						width="95"
						height="95"
						class="ItemImage"
					/>
					<div>
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
					</div>
				</div>
				<div id="MenuItemDetails">
					<div id="MenuItemTitle">
						<div id="MenuItemName">Fried Momo</div>
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
							<span>4.5</span>
						</div>
					</div>
					<div id="MenuItemSubCategory">Chicken</div>
					<div id="MenuItemPrice" class="ItemPrice">Rs 1299</div>
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
							<span>15 mins</span>
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
							<span>01</span>
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
			<div id="MenuItem">
				<div id="MenuItemImage">
					<img
						src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
						alt=""
						width="95"
						height="95"
						class="ItemImage"
					/>
					<div>
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
					</div>
				</div>
				<div id="MenuItemDetails">
					<div id="MenuItemTitle">
						<div id="MenuItemName">Fried Momo</div>
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
							<span>4.5</span>
						</div>
					</div>
					<div id="MenuItemSubCategory">Chicken</div>
					<div id="MenuItemPrice" class="ItemPrice">Rs 1299</div>
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
							<span>15 mins</span>
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
							<span>01</span>
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
			<div id="MenuItem">
				<div id="MenuItemImage">
					<img
						src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
						alt=""
						width="95"
						height="95"
						class="ItemImage"
					/>
					<div>
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
					</div>
				</div>
				<div id="MenuItemDetails">
					<div id="MenuItemTitle">
						<div id="MenuItemName">Fried Momo</div>
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
							<span>4.5</span>
						</div>
					</div>
					<div id="MenuItemSubCategory">Chicken</div>
					<div id="MenuItemPrice" class="ItemPrice">Rs 1299</div>
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
							<span>15 mins</span>
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
							<span>01</span>
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
			<div id="MenuItem">
				<div id="MenuItemImage">
					<img
						src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
						alt=""
						width="95"
						height="95"
						class="ItemImage"
					/>
					<div>
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
					</div>
				</div>
				<div id="MenuItemDetails">
					<div id="MenuItemTitle">
						<div id="MenuItemName">Fried Momo</div>
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
							<span>4.5</span>
						</div>
					</div>
					<div id="MenuItemSubCategory">Chicken</div>
					<div id="MenuItemPrice" class="ItemPrice">Rs 1299</div>
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
							<span>15 mins</span>
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
							<span>01</span>
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
			<div id="MenuItem">
				<div id="MenuItemImage">
					<img
						src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
						alt=""
						width="95"
						height="95"
						class="ItemImage"
					/>
					<div>
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
					</div>
				</div>
				<div id="MenuItemDetails">
					<div id="MenuItemTitle">
						<div id="MenuItemName">Fried Momo</div>
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
							<span>4.5</span>
						</div>
					</div>
					<div id="MenuItemSubCategory">Chicken</div>
					<div id="MenuItemPrice" class="ItemPrice">Rs 1299</div>
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
							<span>15 mins</span>
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
							<span>01</span>
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
