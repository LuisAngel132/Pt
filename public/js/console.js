'use strict';

let environment = document.currentScript.getAttribute('data-environment') || 'local';

if (environment.trim() == 'production') {
	window.console = {
		debug: $.noop,
		dir: $.noop,
		info: $.noop,
		log: $.noop,
		warn: $.noop,
	};
}