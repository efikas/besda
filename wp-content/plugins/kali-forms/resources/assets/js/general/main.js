import './main.scss';

jQuery(document).ready(() => {
	const extensionsReload = document.getElementById('kali-extensions-reload');
	if (extensionsReload !== null) {
		extensionsReload.addEventListener('click', event => reloadExtensionsAction(event));
	}
	jQuery('.kaliform-shortcode-formgroup').on('click', 'button', e => {
		let input = jQuery(e.target).parents('.kaliform-shortcode-formgroup').find('input');
		input.select();
		document.execCommand('copy');
		document.getSelection().removeAllRanges();
		input.blur();
	});

	jQuery('.kaliforms-notice').on('click', '.notice-dismiss', e => {
		let args = {
			id: jQuery(e.target).parents('.kaliforms-notice').data('unique-id'),
			userId: userSettings.uid,
			nonce: KaliFormsGeneralObject.ajax_nonce,
		}

		jQuery.ajax({
			type: 'POST',
			data: { action: 'kaliforms_dismiss_notice', args: args },
			dataType: 'json',
			url: ajaxurl,
		});
	});
});

/**
 * Reload extensions
 */
const reloadExtensionsAction = () => {
	event.preventDefault();
	const anchor = event.target;
	// Start it
	anchor.classList.add('updating-message');
	anchor.setAttribute('disabled', 'disabled');
	let data = "action=kaliforms_reload_api_extensions&nonce=" + KaliFormsGeneralObject.ajax_nonce;
	const xmlHttp = new XMLHttpRequest();
	xmlHttp.open('POST', ajaxurl, true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	xmlHttp.send(data);
	xmlHttp.onreadystatechange = () => {
		if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
			anchor.classList.remove('updating-message');
			anchor.removeAttribute('disabled');
			var res = JSON.parse(xmlHttp.response);
			if (res.status === 'ok') {
				location.reload();
			}

		}
	}
}

