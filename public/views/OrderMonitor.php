<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="assets/css/PageStructure.css" />
		<link rel="stylesheet" href="assets/css/OrderMonitor.css" />
		<script src="assets/js/config.js.php"></script>
		<script src="assets/js/Utilities.js"></script>
		<script src="assets/js/OrderMonitor.js" defer></script>
		<title>Document</title>
	</head>
	<body>
		<div id="OrderMonitorHeader" class="Header section">
			<div class="HeaderTitle">Order Monitor</div>
			<div class="HeaderSubTitle">Today's Revenue</div>
			<div id="DayRevenue" class="ItemPrice">Rs 12113</div>
		</div>
		<div id="OrderMonitorBody" class="Body section">
			<template id="OrderItemTemplate" class="hidden">
				<div id="OrderItem">
					<div id="OrderItemHeader">
						<div id="OrderItemName">Chicken Momo - Steamed</div>
						<div id="OrderItemPrice">Rs 234</div>
					</div>
					<div id="OrderItemMid">
						<div id="OrderItemQuantity">Qty: 2</div>
						<div id="OrderItemStatus" class="OrderStatusDesign">InQueue</div>
					</div>
					<div id="OrderItemFooter">
						<div id="OrderItemNote">Add extra Cheese</div>
						<select id="OrderItemStatusDropdown">
							<option selected disabled>Change Status</option>
							<option value="InQueue">InQueue</option>
							<option value="Preparing">Preparing</option>
							<option value="Ready">Ready</option>
							<option value="Served">Served</option>
							<option value="Closed">Closed</option>
							<option value="Cancelled">Cancelled</option>
						</select>
					</div>
				</div>
			</template>
			<template id="OrderContainerTemplate" class="hidden">
				<div id="OrderContainer">
					<div id="OrderDetails">
						<div>
							<span id="OrderNumber">Order 1</span>
							<span id="OrderTime">12:31</span>
						</div>
						<div>
							<span id="OrderCID">CID:124123</span>
							<!-- <span>|</span>
							<span id="OrderTable">Table: 12</span>
							<span id="OrderCollapse">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									class="icon icon-tabler icon-tabler-chevron-up"
									width="24"
									height="24"
									viewBox="0 0 24 24"
									stroke-width="2"
									stroke="#545F71"
									fill="none"
									stroke-linecap="round"
									stroke-linejoin="round"
								>
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M6 15l6 -6l6 6" />
								</svg>
							</span> -->
						</div>
					</div>
					<div id="OrderItemsList">
					</div>
				</div>
			</template>
		</div>
		<div id="OrderStatusFooter" class="Footer section">
			<div id="ActiveOrders">
				<div id="ActiveOrdersTitle">Active Orders:</div>
				<div id="ActiveOrdersCount">12</div>
			</div>
		</div>
	</body>
</html>
