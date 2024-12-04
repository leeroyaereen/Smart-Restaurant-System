<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="assets/css/PageStructure.css" />
		<link rel="stylesheet" href="assets/css/AdminDashboard.css" />
		<script src="assets/js/config.js.php"></script>
		<script src="assets/js/Utilities.js"></script>
		
	</head>
	<body>
		<div id="AdminDashboardHeader" class="section Header HeaderTitle">
			<span>Admin</span>
			<span>Dashboard</span>
		</div>
		<div class="section Body">
			<div>
				<div>
					<div></div>
					<div></div>
				</div>
				<div>
					<div>
						<div class="HeaderTitle">Add Food Item</div>
						<form id="AddFoodItemForm">
							<input type="text" name="FoodName" id="FoodName" placeholder="Name" />
							<select name="FoodCategory" id="FoodCategory" placeholder="Category">
								<optgroup>
									<option selected>Choose a Category</option>
								</optgroup>
							</select>
							<input type="number" name="FoodPreparationTime" id="FoodPreparationTime" placeholder="Preparation Time" />
							<input type="number" name="FoodPrice" id="FoodPrice" placeholder="Price"/>
							<input type="description" name="FoodDescription" id="FoodDescription" placeholder="Description"/>
							<div>
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
										<template id="DashboardItemTemplate" class="hidden-template">
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
														<div id="DashboardItemQuantity" class="ItemQuantity">
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

					<div></div>
				</div>
			</div>
		</div>
		<script defer>
			const form = document.querySelector("#AddFoodItemForm");

			window.onload = fillCategories;

			async function fillCategories(){
				const categoriesData = await fetchDataGet("/api/getFoodCategories");
				console.log(categoriesData);
				
				if (!categoriesData.success){
					alert("couldn't fetch categories");
					return;
				}

				const categories = document.querySelector('select');
				Object.entries(categoriesData.foodCategories).forEach(([id, category]) => {
					const option = document.createElement('option');
					option.value = id;
					option.innerText = category;
					categories.append(option)
			});
			}

	
			
			form.addEventListener("submit", (e) => {
				e.preventDefault();
				const formData = {
					foodName: form.querySelector("#FoodName").value,
					foodCategory: form.querySelector("#FoodCategory").value,
					foodPreparationTime: form.querySelector("#FoodPreparationTime").value,
					foodPrice: form.querySelector("#FoodPrice").value,
					foodDescription: form.querySelector("#FoodDescription").value,
				}
				fetch(`${BASE_PATH}/api/addFoodItem`, {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-Requested-With": "XMLHttpRequest",
					},
					body: JSON.stringify(formData),
				})
					.then((response) => {
						response.json();
						
					})
					.then((data) => {
						window.location.href = "menu";
						if (data.success) {
							alert("Food item added successfully");
						} else {
							alert("Failed to add food item");
						}
					})
					.catch((error) => {
						console.error("Error:", error);
					});
			});
		</script>
	</body>
</html>
