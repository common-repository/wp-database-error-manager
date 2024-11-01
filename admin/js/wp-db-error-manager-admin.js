(function( $ ) {
	'use strict';

	$(window).load(function() {
		$(".choose-design").click(function() {
			var designImage = $(this).attr("data-template-image");
			var templateId = $(this).attr("data-template-id");

			$("#img-choose-message").attr("src", designImage);
			$("#img-choose-message").attr("data-template-id", templateId);
			$('#a-customise-message').tab('show');
			$("#preview-link").addClass("hide");
			$("#txt_custom_image_url").val("");
			$("#img_custom_image_url").attr("src", "").addClass("hide");

			wpdberrormanager_track({action: "choose_design", details: {templateId: templateId}});
		});

		$("#img_custom_image_url").click(function() {
			initialise_custom_image();
			$('#a-customise-message').tab('show');
			wpdberrormanager_track({action: "custom_image_url"});
		});

		$("#btn-save-changes").click(function() {
			generate('generate_file');
			wpdberrormanager_track({action: "generate_file"});
		});

		$("#btn-generate-preview").click(function() {
			generate('generate_preview');
			wpdberrormanager_track({action: "generate_preview"});
		});

		$("#cmd-retrieve-custom-image").click(function() {
			$("#img_custom_image_url").attr("src", $("#txt_custom_image_url").val()).removeClass("hide");
			initialise_custom_image();
			wpdberrormanager_track({action: "retrieve_custom_image"});
		});

		$("#cmd_login").click(function() {
			displayLoad(".result-container-login");
			var params = {email: $("#txt_email").val(), password: $("#txt_password").val()};
			ajax({action: "login", data: params}, 
				function successCallback(data) {
					displaySuccess(data.message, ".result-container-login");
					$("#login_container").hide();
					setTimeout(function() {
						location.reload();
					}, 2000);
				},
				function errorCallback(data) {
					displayError(data.error, ".result-container-login");
				});
		});

		$("#cmd_logout").click(function() {
			displayLoad(".result-premium-settings");
			logout(
				function(data) {
					displaySuccess(data.message, ".result-premium-settings");
					$("#cmd_save_premium_settings").hide();
					$("#cmd_logout").hide();
					location.reload();
				},
				function() {
					displayError(data.error, ".result-premium-settings");
				});
		});

		$("#cmd_register").click(function() {
			displayLoad(".result-container-register");
			if($("#txt_password_reg").val() != $("#txt_confirm_password_reg").val()) {
				displayError([{code: "", message: "Passwords do not match"}], ".result-container-register");
			} else {
				var params = {email: $("#txt_email_reg").val(), password: $("#txt_password_reg").val()};
				ajax({action: "register", data: params}, 
					function successCallback(data) {
						displaySuccess(data.message, ".result-container-register");
						$("#cmd_register").hide();
					},
					function errorCallback(data) {
						displayError(data.error, ".result-container-register");
					});
			}
			
		});

		$("#cmd_save_premium_settings").click(function() {
			displayLoad(".result-premium-settings");
			var automatedChecks = $("#ch_enable_automated_check").is(":checked") ? true : false;
			var params = {automated_checks: automatedChecks};
			ajax({action: "save_premium_settings", data: params}, 
					function successCallback(data) {
						$(".result-premium-settings").show();
						displaySuccess(data.message, ".result-premium-settings");
						$(".result-premium-settings").fadeOut(2000);
					},
					function errorCallback(data) {
						displayError(data.error, ".result-premium-settings");
					});
		});

		$("#cmd_check_premium").click(function() {
			getActivePlan();
		});

		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			wpdberrormanager_track({action: "tab_selection", details: {tab: e.currentTarget.hash}});
		})


		///////////////////////////////////////////////////
		/////////////////////FUNCTIONS/////////////////////
		///////////////////////////////////////////////////
		function initialise_custom_image() {
			var imageUrl = $("#img_custom_image_url").attr("src");
			$("#img-choose-message").attr("src", imageUrl);
			$("#preview-link").addClass("hide");
		}

		function generate(action) {
			var imageUrl = $("#img-choose-message").attr("src");
			var messageTitle = $("#txt_message_title").val();
			var messageDescription = $("#txt_message_description").val();

			var data = {
				action: action,
				data: {
						imageUrl: imageUrl,
						title: messageTitle,
						description: messageDescription
					}
			};

			ajax(data,
				function successCallback(responseData) {
					$("#preview-link").attr("href", responseData.file_path).removeClass("hide");
					$("#customise-message .wpde-error-container").addClass("hide");
				},
				function errorCallback(responseData) {
					if(action == "generate_file") {
						var errorMessage = responseData.error + "<br />Check the steps defined below to manually create the file.";
						$("#customise-message .wpde-error-container").removeClass("hide").html(errorMessage);
					} else {
						$("#customise-message .wpde-error-container").removeClass("hide").html(responseData.error);
					}

					if(responseData.data && responseData.data.file_contents) {
						$("#txt_generated_file_contents").val(responseData.data.file_contents);
						$(".wpde-generated_file_content_container").removeClass("hide");
					}
				});
		}

		function loadPremiumSettings() {
			ajax({action: "load_premium_settings", data: {}},
				function successCallback(data) {
					if(data && data.automated_check) {
						if(data.automated_check == "active") {
							$('#ch_enable_automated_check').prop('checked', true);
						} else {
							$('#ch_enable_automated_check').prop('checked', false);
						}
					}
				},
				function errorCallback(data) {
					displayError(data.error, ".result-premium-settings");
				});
		}

		function loadDefaultTab() {
			if($("#redirect_tab").val() && $("#redirect_tab").val().length > 0) {
				if($("#redirect_tab").val() == "premium") {
					$('#main-tabs a:last').tab('show');
				}
			}
		}

		function logout(successCallback, errorCallback) {
			ajax({action: "logout", data: {}}, 
				function(data) {
					successCallback(data);
				},
				function(data) {
					errorCallback(data);
				});
		}

		function getActivePlan() {
			displayLoad("#premium_settings_results", "Loading Plan Details");
			ajax({action: "get_active_plan", data: {}},
				function successCallback(data) {
					if(data && data.activePlan) {
						if(data.activePlan != "") {
							$("#premium_settings_container").removeClass("hide");
							$("#premium_settings_warning").addClass("hide");
							$("#premium_settings_results").addClass("hide");
						} else {
							$("#premium_settings_container").addClass("hide");
							$("#premium_settings_warning").removeClass("hide");
							$("#premium_settings_results").addClass("hide");
						}
					} else {
						$("#premium_settings_container").addClass("hide");
						$("#premium_settings_warning").removeClass("hide");
						$("#premium_settings_results").addClass("hide");
					}
				},
				function errorCallback(data) {
					displayError(data.error, "#premium_settings_results");
				});
		}

		function init() {
			loadPremiumSettings();
			loadDefaultTab();

			if($("#get_premium_plan").val() == "yes") {
				getActivePlan();
			}
		}



		///////////////////GENERIC FUNCTIONS///////////////////
		function displayError(errorArray, container) {
			var sessionExpired = false;
			var errorString = "<div class='alert alert-danger wpde-alert-con'>";

			if(errorArray) {
				if(errorArray.length > 1) {
					errorString += "<p>The following errors occurred:</p>";
					errorString += "<ul>";

					for(var i=0;i<errorArray.length;i++) {
						errorString += "<li>" + errorArray[i].message + "</li>";
						sessionExpired = checkSessionExpired(errorArray[i].code, container);
					}

					errorString += "</ul>";
				} else {
					errorString += errorArray[0].message;
					sessionExpired = checkSessionExpired(errorArray[0].code, container);
				}
			} else {
				errorString += "Could not connect to service. There seems to be a problem with our servers. Please try again in a few minutes.";
			}

			errorString += "</div>";

			if(!sessionExpired) {
				$(container).html(errorString).removeClass("hide");
			}
		}

		function checkSessionExpired(errorCode, container) {
			if(errorCode == 1006) {
				var errorString = "<div class='alert alert-danger wpde-alert-con'>";
				errorString += "Your session has expired. You need to login again.";
				errorString += "&nbsp;&nbsp;";
				errorString += "<button class='btn btn-primary' onclick=\"location.reload(true);\">Login</button>";
				errorString += "</div>";

				$(container).html(errorString).removeClass("hide");
				logout(function(){}, function(){});

				return true;
			}

			return false;
		}

		function displaySuccess(message, container) {
			var successString = "<div class='alert alert-success wpde-alert-con'>";
			successString += message;
			successString += "</div>";
			$(container).html(successString).removeClass("hide");
		}

		function displayLoad(container, loadingMessage) {
			if(loadingMessage) {
				$(container).html("<img src='../wp-content/plugins/wp-database-error-manager/assets/icons/ajax-loader.gif' /> " + loadingMessage).removeClass("hide").show();
			} else {
				$(container).html("<img src='../wp-content/plugins/wp-database-error-manager/assets/icons/ajax-loader.gif' />").removeClass("hide").show();
			}
		}

		function wpdberrormanager_track(data) {
			ajax({action: "user_track", data},
				function successCallback(data) {
				},
				function errorCallback(data) {
				});
		}

		function ajax(data, successCallback, errorCallback) {
			jQuery.post(ajaxurl, data, function(response) {

				try{
					response = JSON.parse(response);
				} catch(e) {
					response = {error: [{code: 9999, message: "Could not connect to the server"}]};
				}
				
				if(response) {
					if(response.error) {
						errorCallback(response);
					} else {
						successCallback(response.data);
					}
				} else {
					errorCallback(response);
				}
			});
		}

		init();


		/////////////////////////////////////////////
		///DEBUG FUNCTIONS
		function debug() {
			// debugRegister();
		}

		function debugRegister() {
			$("#txt_email_reg").val("suyash@codevigor.com");
			$("#txt_password_reg").val("test-test");
			$("#txt_confirm_password_reg").val("test-test");

			$("#txt_email").val("suyash@codevigor.com");
			$("#txt_password").val("test-test");

			$('#main-tabs a:last').tab('show');
		}

		debug();//debug

		///END OF DEBUG FUNCTIONS
		/////////////////////////////////////////////
	});

})( jQuery );
