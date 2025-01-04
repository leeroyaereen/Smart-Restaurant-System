<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="assets/css/PageStructure.css" />
		<link rel="stylesheet" href="assets/css/Dashboard.css" />
		<script src="assets/js/config.js.php"></script>
		<script src="assets/js/Utilities.js"></script>
	</head>
	<body>
		<div id="AdminDashboardHeader" class="section Header HeaderTitle">
			<span>Admin</span>
			<span>Dashboard</span>
		</div>
		<div class="section Body">
			<div id="AdminDashboardBody">
				<div id="AdminDashboardToggler">
					<div id="FoodItemToggle" class="active">Food Items</div>
					<div id="FoodCategoryToggle" class="">Food Category</div>
				</div>
				<div id="FoodItemSection" class="section-2">
					<div id="AddFoodItemSection">
						<div class="AdminDashboardTitle" id="AddFoodItemSectionTitle">
							Add Food Item
						</div>
						<form id="AddFoodItemForm">
							<input
								type="text"
								name="FoodName"
								id="FoodName"
								placeholder="Name"
							/>
							<select
								name="FoodCategory"
								id="FoodCategory"
								placeholder="Category"
							>
								<optgroup>
									<option selected>Choose a Category</option>
								</optgroup>
							</select>

							<textarea
								name="FoodDescription"
								id="FoodDescription"
								placeholder="Description"
							></textarea>

							<label for="FoodImage" id="FoodImageContainer">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									width="48"
									height="48"
									viewBox="0 0 24 24"
									fill="none"
									stroke="#fdba74"
									stroke-width="1.5"
									stroke-linecap="round"
									stroke-linejoin="round"
									class="icon icon-tabler icons-tabler-outline icon-tabler-camera"
								>
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path
										d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2"
									/>
									<path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
								</svg>
								<input type="file" name="FoodImage" id="FoodImage" />
							</label>

							<input
								type="number"
								name="FoodPrice"
								id="FoodPrice"
								placeholder="Price"
							/>

							<input
								type="number"
								name="FoodPreparationTime"
								id="FoodPreparationTime"
								placeholder="Preparation Time"
							/>
							<div id="FormBtnGrp">
								<button id="CreateFoodItem" type="submit">Add Item</button>
								<button id="CancelFoodItem" type="reset">Cancel</button>
							</div>
						</form>
						<div id="DashboardFoodItemsList">
							<template
								id="DashboardFoodCategoryTemplate"
								class="hidden-template"
							>
								<div id="DashboardFoodCategory">
									<div id="DasgboardFoodCategoryTitle">Momo</div>
									<div id="DashboardFoodCategoryItems">
										<template
											id="DashboardItemTemplate"
											class="hidden-template"
										>
											<div id="DashboardItem">
												<div id="DashboardItemImage">
													<img
														src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
														alt=""
														width="80"
														height="80"
														class="ItemImage"
													/>
												</div>
												<div id="DashboardItemDetails">
													<div id="DashboardItemTitle">
														<div id="DashboardItemName">Fried Momo</div>
														<div>
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
																class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"
															>
																<path
																	stroke="none"
																	d="M0 0h24v24H0z"
																	fill="none"
																/>
																<path
																	d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"
																/>
																<path d="M12 9h.01" />
																<path d="M11 12h1v4h1" />
															</svg>
														</div>
													</div>
													<div
														id="DashboardItemSubCategory"
														class="HeaderSubTitle"
													></div>
													<div id="DashboardItemFooter" class="ItemFooter">
														<div id="DashboardItemPrice" class="ItemPrice">
															<span></span>
														</div>
														<div
															id="DashboardItemQuantity"
															class="ItemQuantity"
														>
															<svg
																xmlns="http://www.w3.org/2000/svg"
																width="40"
																height="40"
																viewBox="0 0 24 24"
																fill="none"
																stroke="#FE724C"
																stroke-width="1"
																stroke-linecap="round"
																stroke-linejoin="round"
																class="icon icon-tabler icons-tabler-outline icon-tabler-circle-minus"
															>
																<path
																	stroke="none"
																	d="M0 0h24v24H0z"
																	fill="none"
																/>
																<path
																	d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"
																/>
																<path d="M9 12l6 0" />
															</svg>
															<span>00</span>
															<svg
																xmlns="http://www.w3.org/2000/svg"
																width="40"
																height="40"
																viewBox="0 0 24 24"
																fill="#FE724C"
																class="icon icon-tabler icons-tabler-filled icon-tabler-circle-plus"
															>
																<path
																	stroke="none"
																	d="M0 0h24v24H0z"
																	fill="none"
																/>
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
								</div>
							</template>
						</div>
					</div>
					<div id="EditFoodItemSection">
						<div class="AdminDashboardTitle" id="EditFoodItemSectionTitle">
							Edit Food Item
						</div>
						<div></div>
						<div id="EditFoodItemSectionItems">
							<div id="EditFoodItemCategoryContainer">
							<template id="EditFoodItemTemplate" class="hidden">
								<div id="EditFoodItem">
									<div id="EditFoodItemImage">
										<img src="https://imgs.search.brave.com/Vc_LT_XtikkAbIBPyfReLh-bKN4ZBGo6kAigj8UxNlI/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9lMS5w/eGZ1ZWwuY29tL2Rl/c2t0b3Atd2FsbHBh/cGVyLzMyNS8zNjgv/ZGVza3RvcC13YWxs/cGFwZXItcGl6emEt/bWFyZ2hlcml0YS5q/cGc" alt="" class="ItemImage"/>
									</div>
									<div id="EditFoodItemTitle">Margeritta Pizza</div>
									<div id="EditFoodItemType">Non Veg</div>
									<div id="EditFoodItemDescription">Classic pizza with tomato sauce, mozzarella, and basil</div>
									<b id="EditFoodItemPrice">Price: <span>Rs 12.99</span></b>
									<div id="EditFoodItemPreparationTime">Prep Time: <span>10 mins</span></div>
									<div id="EditFoodItemBtnGrp">
										<button id="EditFoodItemButton">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen w-4 h-4 mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
											Edit
										</button>
										<button id="DeleteFoodItemButton">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4 mr-2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
											Delete
										</button>
									</div>
							</template>
							</div>
						</div>
					</div>
				</div>
				<div id="FoodCategorySection" class="section-2 hidden"></div>
			</div>
		</div>
		<script src="assets/js/Dashboard.js"></script>
	</body>
</html>
