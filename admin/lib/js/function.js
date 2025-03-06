$(document).on('click', '.delete_item_btn', function (e) {
  e.preventDefault();
  var TaggedToolId = $(this).attr('value');
  swal({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type: 'POST',
        url: 'code.php',
        data: {
          delete_item_btn: true,
          tbl_item_id: TaggedToolId,
        },
        success: function (response) {
          if (response == 200) {
            swal('Success!', 'Item Deleted Successfully!', 'success');
            $('#all_item_table').load(location.href + ' #all_item_table');
          } else if (response == 404) {
            swal('Error!', 'Tagged tool not found', 'error');
          } else {
            swal('Error!', 'Something went wrong', 'error');
          }
        },
      });
    }
  });
});

$(document).on('click', '.approve_item_btn', function (e) {
  e.preventDefault();
  var approveItemId = $(this).data('id');

  swal({
    title: 'Approve Item?',
    text: 'Are you sure you want to approve this returned item?',
    icon: 'info',
    buttons: true,
    dangerMode: false,
  }).then((willApprove) => {
    if (willApprove) {
      $.ajax({
        type: 'POST',
        url: 'return_item.php',
        data: { id: approveItemId, action: 'approve' },
        dataType: 'json',
        success: function (response) {
          if (response.status === 'success') {
            swal('Success!', response.message, 'success').then(() => {
              setTimeout(() => {
                location.reload();
              }, 2000);
            });
          } else {
            swal('Error!', response.message, 'error');
          }
        },
        error: function () {
          swal('Error!', 'Something went wrong. Please try again.', 'error');
        },
      });
    }
  });
});

/*==================== FUNC FOR BORROWING PROCESS ====================*/
$(document).ready(function () {
  function validateForm(formId) {
    var isValid = true;

    $(
      formId +
        ' input[required]:visible, ' +
        formId +
        ' select[required]:visible'
    ).each(function () {
      var value = $(this).val().trim();
      $(this).removeClass('is-invalid');

      if ($(this).attr('id') === 'student_name') {
        var lettersPattern = /^[A-Za-z\s]+$/;
        if (!lettersPattern.test(value)) {
          isValid = false;
          alertify.error('Please enter full name.');
          $(this).addClass('is-invalid');
        }
      }

      if ($(this).attr('id') === 'section' && value === 'Select Section') {
        isValid = false;
        alertify.error('Please select your section.');
        $(this).addClass('is-invalid');
      }

      if (
        $(this).attr('id') === 'borrowed_date' ||
        $(this).attr('id') === 'return_date'
      ) {
        if (value === '') {
          isValid = false;
          alertify.error('Please select a valid date.');
          $(this).addClass('is-invalid');
        } else {
          var selectedDate = new Date(value);
          var today = new Date();
          today.setHours(0, 0, 0, 0);

          if (selectedDate < today) {
            isValid = false;
            alertify.error(
              'Past dates are not allowed. Please select a future date.'
            );
            $(this).addClass('is-invalid');
          }

          var dayOfWeek = selectedDate.getDay();
          if (dayOfWeek === 0 || dayOfWeek === 6) {
            isValid = false;
            alertify.error(
              'Weekends are not allowed. Please select a weekday.'
            );
            $(this).addClass('is-invalid');
          }
        }
      }

      if ($(this).attr('id') === 'qty') {
        var stock = parseInt($('#stock').val()) || 0;
        var quantity = parseInt(value) || 0;

        if (isNaN(quantity) || quantity <= 0 || quantity > stock) {
          isValid = false;
          alertify.error('Please enter a valid quantity (1 to ' + stock + ').');
          $(this).addClass('is-invalid');
        }
      }
    });

    return isValid;
  }

  function setMinDate() {
    var today = new Date().toISOString().split('T')[0];
    $('#borrowed_date, #return_date').attr('min', today);
  }

  $('#borrowed_date, #return_date').on('change', function () {
    var selectedDate = new Date($(this).val());
    var dayOfWeek = selectedDate.getDay();
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
      alertify.error('Past dates are not allowed.');
      $(this).val('');
    } else if (dayOfWeek === 0 || dayOfWeek === 6) {
      alertify.error('Weekends are not allowed. Please select a weekday.');
      $(this).val('');
    }
  });

  $('#item').change(function () {
    var selectedStock = $(this).find(':selected').data('stock') || 0;
    $('#stock').val(selectedStock);
  });

  $('#btn_borrow').click(function () {
    if (validateForm('#borrowForm')) {
      var formData = $('#borrowForm').serialize();

      $.ajax({
        type: 'POST',
        url: 'functions/process_borrow.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            alertify.success(response.message);
          } else {
            alertify.error(response.message);
          }
          $('#borrowForm')[0].reset();
          setMinDate();
          setTimeout(function () {
            location.reload();
          }, 3000);
        },
        error: function () {
          alertify.error('Error occurred while processing the request.');
        },
      });
    }
  });

  $('#student_name, #section, #borrowed_date, #return_date, #item, #qty').on(
    'input change',
    function () {
      $(this).removeClass('is-invalid');
    }
  );

  setMinDate();
});
