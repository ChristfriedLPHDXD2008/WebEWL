var changed, saving;

$(function () {
	console.log("openingTime JS loading");
	changed = [];
	saving = false;
});

function editTime(d) {
	var timeModal	= $("#modalTime"),
		selector	= $('#' + d);
	timeModal.find("#modalTitle").html("Geöffnet am " + selector.data("day"));
	timeModal.find("#inpHour").val(selector.html().split(":")[0].replace(/\s/g,''));
	timeModal.find("#inpMin").val(selector.html().split(":")[1].replace(/\s/g,''));
	timeModal.find("#inpHour").parent().removeClass("has-error");
	timeModal.find("#inpMin").parent().removeClass("has-error");
	timeModal.find("#btnSaveTime").attr("onclick", "saveTime('" + d + "');");
	timeModal.modal("show");
}
function saveTime(d) {
	if (d === 0) return;

	var timeModal	= $("#modalTime"),
		selector	= $('#' + d),
		hour		= timeModal.find("#inpHour").val(),
		min			= timeModal.find("#inpMin").val(),
		combi		= hour + ":" + min;

	if (!validateInput()) return;

	timeModal.modal('hide');
	selector.html(combi);

	if (combi !== selector.data("before")) {
		pushChange(d);
		selector.addClass("changed");
	} else {
		revokeChange(d);
		selector.removeClass("changed");
	}

	var slice = d.slice(0, -1),
		both = $('#' + slice + '1, #' + slice + '2');

	if ($('#' + slice + '1').html() === $('#' + slice + '2').html())
		both.addClass("closed");
	else
		both.removeClass("closed");
}
function setZero(dn1, dn2) {
	var selectors = $('#' + dn1 + ', #' + dn2);
	selectors.html("0:00");
	selectors.addClass("changed");
	selectors.addClass("closed");
	pushChange(dn1);
	pushChange(dn2);
}
function submitChanges() {
	if (saving) return;
	saving = true;

	var times = {};
	$.each(changed, function (i, v) {
		times[v] = $('#' + v).html();
	});
	if ($.isEmptyObject(times)) return;

	var json = JSON.stringify(times, null);
	console.log("starting ajax post");
	console.log(json);
	$.ajax({
		url: "/handler/openingTimes.handler.php",
		contentType: "application/json; charset=utf-8",
		type: "POST",
		data: json,
		dataType: "json",
		success: function (data) {
			console.log(data);
			submitSuccessHandler(data);
			saving = false;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			if (xhr.status === 200)
				console.log(ajaxOptions);
			else {
				console.log(xhr.status);
				console.log(thrownError);
			}
			saving = false;
		}
	});
	console.log("ajax passed");
}
function submitSuccessHandler(data) {
	if ("error" in data) {
		setMessage(data["error"]);
		return;
	}
	if ("success" in data) {
		$("td.time a.changed").each(function () {
			$(this).removeClass("changed");
			var before = $(this).html();
			$(this).data("before", before);
		});
		setMessage(data["success"]);
		changed = [];
	}
}
function setMessage(msg) {
	var status = $("#status");
	status.html("<span>" + msg + "</span>");
}
function pushChange(d) {
	if ($.inArray(d, changed) >= 0) return;
	changed.push(d);
}
function revokeChange(d) {
	var found = $.inArray(d, changed);
	if (found >= 0) changed.splice(found, 1);
}
function validateInput() {
	var timeModal	= $("#modalTime"),
		hour		= timeModal.find("#inpHour").val(),
		min			= timeModal.find("#inpMin").val(),
		valid		= true;

	if (!$.isNumeric(hour) || !hour.length > 0 || hour < 0 || hour > 24) {
		timeModal.find("#inpHour").parent().addClass("has-error");
		valid = false;
	} else timeModal.find("#inpHour").parent().removeClass("has-error");

	if (!$.isNumeric(min) || min.length !== 2 || min < 0 || min > 60) {
		timeModal.find("#inpMin").parent().addClass("has-error");
		valid = false;
	} else timeModal.find("#inpMin").parent().removeClass("has-error");

	return valid;
}

$(function () {
	console.log("openingTimes JS executed");
});