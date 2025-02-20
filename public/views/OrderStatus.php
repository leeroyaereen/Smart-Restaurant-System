<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="assets/css/PageStructure.css" />
		<link rel="stylesheet" href="assets/css/OrderStatus.css" />
		<script src="assets/js/config.js.php"></script>
		<script src="assets/js/Utilities.js"></script>
		<script src="assets/js/OrderStatus.js" defer></script>
	</head>
	<body>
		<div id="OrderStatusHeader" class="section Header">
			<div class="HeaderTitle">My Tray</div>
			<div id="CustomerIdContainer">
				<div class="HeaderSubTitle">Customer ID</div>
				<div class="HeaderTitle">
					<?php 
						if(isset($_SESSION["firstName"])){
							echo $_SESSION["firstName"] .':'.$_SESSION["User_ID"]; 
						}else{
							echo "Guest (Not Logged In)";
						}
					?>
				</div>
			</div>
		</div>
		<div id="OrderStatusBody" class="section Body">
			<!-- <div id="OrderProgress">
				<div class="EstimatedTimeContainer">
					<div>Estimated Time</div>
					<div class="EstimatedTime">1hr 12min</div>
				</div>
				<div id="ProgressBarContainer">
					<div id="InProgress" class="OrderStatusDesign">IN PROGRESS</div>
					<div id="ProgressBar">
						<div id="Progress"></div>
					</div>
				</div>
			</div> -->

			<div id="OrderStatusList">
				<div id="OrderStatusListTitle">Your Orders</div>
				<template id="OrderStatusItemTemplate" class="hidden">
					<div id="OrderStatusItem">
						<div id="StatusItemInformation">
							<div id="StatusItemImage">
								<img
									src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
									alt=""
									width="75"
									height="75"
									class="ItemImage"
								/>
							</div>
							<div id="StatusItemDetails">
								<div id="StatusItemTitle">
									<div id="StatusItemName"></div>
									<div id="StatusItemStatus" class="OrderStatusDesign">
										
									</div>
								</div>
								<div id="StatusItemType" class="HeaderSubTitle">
									
								</div>
								<div id="StatusItemFooter" class="ItemFooter">
									<div id="StatusItemQuantity">Qty:1</div>
									<div id="StatusItemPrice" class="ItemPrice">Rs 256</div>
									<div id="StatusItemDuration">
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
								</div>
							</div>
						</div>
						<div id="StatusItemNote">
							Note: Please add extra sauce
						</div>
					</div>
				</template>
			</div>
		</div>
	</body>
</html>
