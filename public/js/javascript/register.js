$(document).ready(function(){
	openPay();
});

function openPay() {
	OpenPay.setId('mjclxkjzw1n2fu5oo1le');
	OpenPay.setApiKey('pk_b4db52de68ba42d09e28ef3d6cab143e');
	OpenPay.setSandboxMode(true);
	var deviceSessionId = OpenPay.deviceData.setup("form-register", "device_session_id");
}