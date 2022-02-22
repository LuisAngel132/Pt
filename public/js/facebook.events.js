const facebook = {
	events: {
		defaultParameters: {
			via: platform.description,
			url: window.location.href,
			at: new Date().toLocaleString('es-MX', {timeZone: 'America/Monterrey'})
		},
		userAuthenticated: function(user){
			fbq('trackCustom', 'UserAuthenticated', Object.assign(user, this.defaultParameters));
		},
		userRegistered: function(user){
			fbq('trackCustom', 'UserRegistered', Object.assign(user, this.defaultParameters));
		},
		viewContent: function (content) {
			fbq('track', 'ViewContent', Object.assign(content, this.defaultParameters));
		},
		arDesignViewed: function (design) {
			fbq('trackCustom', 'ARDesignViewed', Object.assign(design, this.defaultParameters));
		}
	}
};