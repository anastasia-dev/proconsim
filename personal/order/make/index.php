<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?><?$APPLICATION->IncludeComponent(
	"proc:sale.order.ajax", 
	".default", 
	array(
		"ACTION_VARIABLE" => "soa-action",
		"ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_3" => "-",
		"ALLOW_APPEND_ORDER" => "Y",
		"ALLOW_AUTO_REGISTER" => "Y",
		"ALLOW_NEW_PROFILE" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"BASKET_POSITION" => "before",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"DELIVERIES_PER_PAGE" => "9",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"DISABLE_BASKET_REDIRECT" => "N",
		"MESS_AUTH_BLOCK_NAME" => "Авторизация",
		"MESS_BACK" => "Назад",
		"MESS_BASKET_BLOCK_NAME" => "Товары в заказе",
		"MESS_BUYER_BLOCK_NAME" => "Покупатель",
		"MESS_DELIVERY_BLOCK_NAME" => "Доставка",
		"MESS_EDIT" => "изменить",
		"MESS_FURTHER" => "Далее",
		"MESS_NAV_BACK" => "Назад",
		"MESS_NAV_FORWARD" => "Вперед",
		"MESS_ORDER" => "Оформить заказ",
		"MESS_PAYMENT_BLOCK_NAME" => "Оплата",
		"MESS_PERIOD" => "Срок доставки",
		"MESS_PRICE" => "Стоимость",
		"MESS_REGION_BLOCK_NAME" => "Тип плательщика: юридическое лицо",
		"MESS_REG_BLOCK_NAME" => "Регистрация",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PAY_FROM_ACCOUNT" => "N",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"PICKUP_MAP_TYPE" => "yandex",
		"PRODUCT_COLUMNS_HIDDEN" => array(
		),
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
		),
		"PROPS_FADE_LIST_2" => array(
		),
		"SEND_NEW_USER_NOTIFY" => "Y",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"SET_TITLE" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"SHOW_COUPONS_BASKET" => "N",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "N",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SHOW_MAP_IN_PROPS" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SHOW_ORDER_BUTTON" => "always",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "N",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "N",
		"SHOW_PICKUP_MAP" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_VAT_PRICE" => "Y",
		"SKIP_USELESS_BLOCK" => "Y",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"TEMPLATE_THEME" => "blue",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PRELOAD" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_YM_GOALS" => "Y",
		"YM_GOALS_COUNTER" => "7158430",
		"YM_GOALS_INITIALIZE" => "BX-order-init",
		"YM_GOALS_EDIT_REGION" => "BX-region-edit",
		"YM_GOALS_EDIT_DELIVERY" => "BX-delivery-edit",
		"YM_GOALS_EDIT_PICKUP" => "BX-pickUp-edit",
		"YM_GOALS_EDIT_PAY_SYSTEM" => "BX-paySystem-edit",
		"YM_GOALS_EDIT_PROPERTIES" => "BX-properties-edit",
		"YM_GOALS_EDIT_BASKET" => "BX-basket-edit",
		"YM_GOALS_NEXT_REGION" => "BX-region-next",
		"YM_GOALS_NEXT_DELIVERY" => "BX-delivery-next",
		"YM_GOALS_NEXT_PICKUP" => "BX-pickUp-next",
		"YM_GOALS_NEXT_PAY_SYSTEM" => "BX-paySystem-next",
		"YM_GOALS_NEXT_PROPERTIES" => "BX-properties-next",
		"YM_GOALS_NEXT_BASKET" => "BX-basket-next",
		"YM_GOALS_SAVE_ORDER" => "BX-order-save"
	),
	false
);?><br>
<script type="text/javascript">
	window.addEventListener('load', function() {
		$('.bx-soa-more-btn .pull-right').on('click', function() {
			if ($('#bx-soa-delivery').length > 0) {
				if ($('#bx-soa-delivery').hasClass('bx-selected')) {
					$('.bx-soa-more-btn .pull-right').on('click', function() {
						ingEvents.dataLayerPush('dataLayer', {'event': 'order'});
					});
				}
			}
		});
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>