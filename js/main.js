$(document).ready(function() {

	$('input[name=phone]').mask('7(999)-999-99-99');

	$('.month td.free_cell').on('click', function() {
		$('.month td.free_cell').removeClass('chosen_cell');
		$(this).toggleClass('chosen_cell');
	});

	$('#booking_submit').on('click', function() {
		var date_booking = false;
		$('.month td').each(function(index, element) {
			if ($(element).hasClass('chosen_cell')) {
				date_booking = $(element).attr('data-date_booking');
			}
		});

		if (!date_booking) {
			alert('Не выбрана дата для бронирования!');
			return;
		}

		var phone = $('input[name=phone]').val();
			if (phone.length < 11) {
				$('input[name=phone]').addClass('phone_error'); 
				alert('Вы неправльно указалали номер!');
				return;
			}
			var confirm_ = confirm("Забронировать на "+date_booking+" (тел.номер: '"+phone+"') ?");
			if (confirm_) {
				$.ajax({
	              url: "index.php", // куда отправляем
	              type: "post", // метод передачи
	              dataType: "json", // тип передачи данных
	              async: false,
	              data: { // что отправляем
	                  "date_booking": date_booking,
	                  "phone": phone
	              },
	              success: function(data){
	              	if (data) {
		              	var obj_ = $('.chosen_cell');
		              	obj_.removeClass('free_cell');
		              	obj_.removeClass('chosen_cell');
		              	obj_.addClass('booking_cell');
		              	$('input[name=phone]').val('');
		              	alert('Бронирование даты выполнено успешно!');
	              	} else {
	              		alert('Не удалось забронировать дату!');
	              	}
	              	$('input[name=phone]').removeClass('phone_error'); 
	              }
	          	});
			}
	});

});