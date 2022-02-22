let userAgentIs = {
	android: function() {
		return navigator.userAgent.match(/Android/i) ? 'https://play.google.com/store/apps/details?id=com.asta.t_shirtapp' : false;
	},
	ios: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? 'https://itunes.apple.com/mx/app/ph-ra/id1360061103?mt=8' : false;
	},
};

if (redirectTo = userAgentIs.ios() || userAgentIs.android()) {
	window.location = redirectTo;
}