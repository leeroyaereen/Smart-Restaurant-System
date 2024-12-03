<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Document</title>
		<link rel="stylesheet" href="assets/css/PageStructure.css" />
		<link rel="stylesheet" href="assets/css/TrayItem.css" />
        <script src="assets/js/config.js.php"></script>
        <script src="assets/js/Universal.js" defer></script>
        <script src="assets/js/MyTrayItems.js" defer></script>
        <script src="assets/js/Utilities.js"></script>
	</head>
	<body>
		<div id="TrayItemsHeader" class="section Header">
			<div id="TrayItemsTitle" class="HeaderTitle">My Tray</div>
			<div id="TrayItemsTable" class="HeaderSubTitle">Table Number: 12</div>
		</div>

		<div id="TrayItemsList" class="section Body">
            <template id="TrayCategoryTemplate" class="hidden-template">
                <div id="TrayCategory">
                    <div id="TrayCategoryTitle">Momo</div>
                    <div id="TrayCategoryItems">
                        <template id="TrayItemTemplate" class="hidden-template">
                            <div id="TrayItem" class="ItemContainer">
                                <div id="TrayItemInformation">
                                    <div id="TrayItemImage">
                                        <label id="TrayItemCheckBox">
                                            <div id="CheckBoxIcon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fe724c" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            </div>
                                            <input type="checkbox" hidden/>
                                        </label>
                                        <img
                                            src="https://t4.ftcdn.net/jpg/06/49/25/27/360_F_649252736_LK6ign50vHZicrNR6Fe2mSpmPDNupx6Y.jpg"
                                            alt=""
                                            width="80"
                                            height="80"
                                            class="ItemImage"
                                        />
                                    </div>
                                    <div id="TrayItemDetails">
                                        <div id="TrayItemTitle">
                                            <div id="TrayItemName">Fried Momo</div>
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
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                    <path d="M12 9h.01" />
                                                    <path d="M11 12h1v4h1" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div id="TrayItemSubCategory" class="HeaderSubTitle"></div>
                                        <div id="TrayItemFooter" class="ItemFooter">
                                            <div id="TrayItemPrice" class="ItemPrice"><span></span></div>
                                            <div id="TrayItemQuantity" class="ItemQuantity">
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
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
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
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M4.929 4.929a10 10 0 1 1 14.141 14.141a10 10 0 0 1 -14.14 -14.14zm8.071 4.071a1 1 0 1 0 -2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0 -2h-2v-2z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="TrayItemNote">
                                    <div id="TrayItemNoteIcon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#545F71" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 7l6 0" />
                                            <path d="M9 11l6 0" />
                                            <path d="M9 15l4 0" />
                                        </svg>
                                    </div>
                                    <textarea name="" id="TrayItemNoteInput" rows="1" placeholder="Add Note..."></textarea>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
		</div>

        <div id="TrayItemsFooterContainer">
            <div id="OrderPricingDetails">
                <div id="SubTotal" class="PricingDetailBlock">
                    <span>Sub Total:</span>
                    <span>Rs <span id="subTotalValue">0</span></span>
                </div>
                <div id="Discount" class="PricingDetailBlock">
                    <span>Discount:</span>
                    <span>Rs <span id="discountValue">0</span></span>
                </div>
                <div id="Total" class="PricingDetailBlock">
                    <span>Total:</span>
                    <span>Rs <span id="totalValue">0</span></span>
                </div>
            </div>
            <div id="OrderConfirmation" class="section Footer">
                <div class="EstimatedTimeContainer">
                    <div>Estimated Time:</div>
                    <div class="EstimatedTime">1hr 2min</div>
                </div>
                <div id="ConfirmationButton" class="DefaultOrderButton">
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
                        <span>CONFIRM</span>
                    </button>
                </div>
            </div>
        </div>
	</body>
</html>
