'use strict';

// Class definition
var KTCropperDemo = function () {

	// Private functions
	var initCropperDemo = function () {
		var image = document.getElementById('image');

		// Ensure the image is loaded before initializing Cropper
		if (!image) {
			console.error('Image element not found');
			return;
		}

		// Make sure we initialize only after image is loaded
		if (image.complete) {
			initCropper();
		} else {
			image.onload = function() {
				initCropper();
			};
		}

		function initCropper() {
			var options = {
				crop: function (event) {
					document.getElementById('dataX').value = Math.round(event.detail.x);
					document.getElementById('dataY').value = Math.round(event.detail.y);
					document.getElementById('dataWidth').value = Math.round(event.detail.width);
					document.getElementById('dataHeight').value = Math.round(event.detail.height);
					document.getElementById('dataRotate').value = event.detail.rotate;
					document.getElementById('dataScaleX').value = event.detail.scaleX;
					document.getElementById('dataScaleY').value = event.detail.scaleY;

					var lg = document.getElementById('cropper-preview-lg');
					lg.innerHTML = '';
					lg.appendChild(cropper.getCroppedCanvas({ width: 256, height: 160 }));

					var md = document.getElementById('cropper-preview-md');
					md.innerHTML = '';
					md.appendChild(cropper.getCroppedCanvas({ width: 128, height: 80 }));

					var sm = document.getElementById('cropper-preview-sm');
					sm.innerHTML = '';
					sm.appendChild(cropper.getCroppedCanvas({ width: 64, height: 40 }));

					var xs = document.getElementById('cropper-preview-xs');
					xs.innerHTML = '';
					xs.appendChild(cropper.getCroppedCanvas({ width: 32, height: 20 }));
				},
			};

			// Initialize Cropper
			var cropper = new Cropper(image, options);

			// Handle method buttons
			var buttons = document.getElementById('cropper-buttons');
			var methods = buttons.querySelectorAll('[data-method]');
			methods.forEach(function (button) {
				button.addEventListener('click', function (e) {
					var method = button.getAttribute('data-method');
					var option = button.getAttribute('data-option');
					var option2 = button.getAttribute('data-second-option');

					try {
						option = JSON.parse(option);
					}
					catch (e) {
						// If not valid JSON, keep as is
					}

					var result;
					if (!option2) {
						result = cropper[method](option, option2);
					}
					else if (option) {
						result = cropper[method](option);
					}
					else {
						result = cropper[method]();
					}

					if (method === 'getCroppedCanvas') {
						var modal = document.getElementById('getCroppedCanvasModal');
						var modalBody = modal.querySelector('.modal-body');
						modalBody.innerHTML = '';
						modalBody.appendChild(result);
					}

					var input = document.querySelector('#putData');
					try {
						input.value = JSON.stringify(result);
					}
					catch (e) {
						if (!result) {
							input.value = result;
						}
					}
				});
			});

			// Set aspect ratio option buttons
			var radioOptions = document.getElementById('setAspectRatio').querySelectorAll('[name="aspectRatio"]');
			radioOptions.forEach(function (button) {
				button.addEventListener('click', function (e) {
					cropper.setAspectRatio(parseFloat(e.target.value));
				});
			});

			// Set view mode
			var viewModeOptions = document.getElementById('viewMode').querySelectorAll('[name="viewMode"]');
			viewModeOptions.forEach(function (button) {
				button.addEventListener('click', function (e) {
					cropper.destroy();
					cropper = new Cropper(image, Object.assign({}, options, { viewMode: parseInt(e.target.value) }));
				});
			});

			// Toggle options
			var toggleoptions = document.getElementById('toggleOptionButtons').querySelectorAll('[type="checkbox"]');
			toggleoptions.forEach(function (checkbox) {
				checkbox.addEventListener('click', function (e) {
					var appendOption = {};
					appendOption[e.target.getAttribute('name')] = e.target.checked;
					options = Object.assign({}, options, appendOption);
					cropper.destroy();
					cropper = new Cropper(image, options);
				});
			});

			// Handle image uploads
			var inputImage = document.getElementById('inputImage');
			if (inputImage) {
				inputImage.addEventListener('change', function (e) {
					var files = e.target.files;
					if (files && files.length) {
						var file = files[0];
						// Only process image files
						if (/^image\/\w+/.test(file.type)) {
							var uploadedImageURL = URL.createObjectURL(file);
							// Destroy the old cropper instance
							cropper.destroy();
							// Replace image source
							image.src = uploadedImageURL;
							// Create new cropper instance
							cropper = new Cropper(image, options);
							// Revoke the blob URL after the image has been loaded
							image.onload = function() {
								URL.revokeObjectURL(uploadedImageURL);
							};
						} else {
							window.alert('Please choose an image file.');
						}
					}
				});
			}
		}
	};

	return {
		// public functions
		init: function () {
			initCropperDemo();
		},
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTCropperDemo.init();
});
