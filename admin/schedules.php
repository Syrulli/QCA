<?php
$title = "Dashboard - Schedules a Class";
include('../middleware/admin_middleware.php');
include('components/header.php');
include('components/modal.php');
?>

<section>
    <div class="container-fluid px-4 mt-4 mb-5" id="schedule_table">
        <div class="row">
            <h4 class="float-start">Schedule a <span>class</span></h4>
            <hr>
            <div class="col-lg-12">
                <div id="calendar" width="800" height="300"></div>
            </div>
        </div>
    </div>
</section>

<?php include('components/footer.php'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split('T')[0];

        document.getElementById("editScheduleDate").setAttribute("min", today);

        function updateDateTimeMin() {
            var selectedDate = document.getElementById("editScheduleDate").value;
            var startTime = document.getElementById("editScheduleStart");
            var endTime = document.getElementById("editScheduleEnd");

            var now = new Date();
            var currentDateTime = now.toISOString().slice(0, 16); 

            if (selectedDate === today) {
                startTime.setAttribute("min", currentDateTime);
            } else {
                startTime.removeAttribute("min");
            }

            startTime.addEventListener("change", function() {
                endTime.setAttribute("min", startTime.value);
            });
        }

        document.getElementById("editScheduleDate").addEventListener("change", updateDateTimeMin);
    });
</script>

<script>
    $(document).ready(function() {
        var now = new Date();
        var today = now.toISOString().split('T')[0];

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: "06:00:00",
            slotMaxTime: "19:00:00",
            allDaySlot: false,
            editable: false,
            selectable: true,
            eventOverlap: false,
            selectOverlap: false,
            aspectRatio: 1.8,
            height: 'auto',
            selectMirror: true,
            events: "fetch_schedules.php",

            validRange: {
                start: now
            },

            selectAllow: function(selectInfo) {
                return new Date(selectInfo.start) >= now;
            },

            eventDidMount: function(info) {
                $(info.el).tooltip({
                    title: "Teacher: " + info.event.extendedProps.name,
                    placement: "top",
                    trigger: "hover",
                    container: "body"
                });
            },

            select: function(info) {
                $('#scheduleStart').val(info.startStr);
                $('#scheduleEnd').val(info.endStr);
                $('#scheduleDate').val(info.startStr.split("T")[0]);
                $('#addScheduleModal').modal('show');
            },

            eventDrop: function(info) {
                updateEvent(info);
            },

            eventResize: function(info) {
                updateEvent(info);
            },

            eventClick: function(info) {
                $.ajax({
                    type: "POST",
                    url: "get_sched.php",
                    data: {
                        id: info.event.id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#editScheduleId').val(response.data.id);
                            $('#editScheduleTitle').val(response.data.title);
                            $('#editScheduleSection').val(response.data.section);
                            $('#editScheduleSubject').val(response.data.subject);
                            $('#editScheduleDate').val(response.data.date);
                            $('#editScheduleStart').val(response.data.start);
                            $('#editScheduleEnd').val(response.data.end);
                            $('#editScheduleModal').modal('show');
                        } else {
                            alertify.error(response.message || "Unauthorized access!");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alertify.error("Something went wrong while fetching data.");
                    }
                });
            }
        });

        calendar.render();

        $('#saveScheduleBtn').click(function() {
            var title = $('#scheduleTitle').val();
            var section = $('#scheduleSection').val();
            var subject = $('#scheduleSubject').val();
            var date = $('#scheduleDate').val();
            var start = $('#scheduleStart').val();
            var end = $('#scheduleEnd').val();
            var user_id = document.getElementById('auth_user') ? document.getElementById('auth_user').value : null;

            if (!user_id) {
                alertify.error("User ID not found!");
                return;
            }

            if (title && section && subject) {
                $.ajax({
                    url: "code.php",
                    type: "POST",
                    data: {
                        action: "add_schedule",
                        title: title,
                        section: section,
                        subject: subject,
                        date: date,
                        start: start,
                        end: end,
                        user_id: user_id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#addScheduleModal').modal('hide');
                            calendar.refetchEvents();
                            alertify.success(response.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            alertify.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alertify.error("Failed to add schedule.");
                    }
                });
            } else {
                alertify.error("All fields are required!");
            }
        });

        function updateEvent(info) {
            var event = info.event;
            $.ajax({
                url: "code.php",
                type: "POST",
                data: {
                    action: "update_schedule",
                    id: event.id,
                    start: event.start.toISOString(),
                    end: event.end ? event.end.toISOString() : null
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alertify.success(response.message);
                    } else {
                        alertify.error(response.message);
                        info.revert();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alertify.error("Failed to update event.");
                    info.revert();
                }
            });
        }
    });
</script>

<script>
    $(document).on('click', '#deleteScheduleBtn', function(e) {
        e.preventDefault();
        var schedTableId = $('#editScheduleId').val();

        if (!schedTableId) {
            swal('Error!', 'No schedule selected', 'error');
            return;
        }

        swal({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this schedule!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'code.php',
                    data: {
                        delete_schedule: true,
                        id: schedTableId,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            swal('Success!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            swal('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        swal('Error!', 'Something went wrong with the request', 'error');
                    },
                });
            }
        });
    });
</script>