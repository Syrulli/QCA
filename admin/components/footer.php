        <footer class="py-4 bg-light mt-auto postion">
            <div class="container-fluid px-4">
                <div class="small text-center">
                    <div class="text-muted">&copy; Quezon City Academy | All rights reserved.</div>
                </div>
            </div>
        </footer>

        <script src="lib/js/minified.js" crossorigin="anonymous"></script>
        <script src="lib/js/scripts.js"></script>
        <script src="lib/js/function.js"></script>
        <script src="lib/js/fontawesome.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
        <script>
            function fetchNotifications() {
                fetch('fetch_notifications.php')
                    .then(response => response.json())
                    .then(data => {
                        let notificationDropdown = document.getElementById("notificationDropdown");
                        let notificationCount = document.getElementById("notificationCount");

                        notificationDropdown.innerHTML = "";
                        if (data.length > 0) {
                            notificationCount.textContent = data.length; 
                            data.forEach(notification => {
                                let listItem = document.createElement("li");
                                listItem.innerHTML = `<small"><a class="dropdown-item">
                    <span> ${notification.student_name}</span> from  <span>${notification.section}</span> borrowed <span>${notification.item_name}.</span>
                    </a></small>`;
                                notificationDropdown.appendChild(listItem);
                            });
                        } else {
                            notificationCount.textContent = "";
                            notificationDropdown.innerHTML = `<li><a class="dropdown-item">No new notifications</a></li>`;
                        }
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }

            setInterval(fetchNotifications, 5000);
            fetchNotifications();
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth'
                });
                calendar.render();
            });
        </script>


        <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById('password');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            }
        </script>
        <script>
            <?php
            if (isset($_SESSION['message'])) {
            ?>
                alertify.set('notifier', 'position', 'bottom-right');
                alertify.success('<?= $_SESSION['message']; ?>');
            <?php
                unset($_SESSION['message']);
            }
            ?>
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if (isset($_SESSION['message'])): ?>
                    alertify.success("<?php echo $_SESSION['message']; ?>");
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    alertify.error("<?php echo $_SESSION['error_message']; ?>");
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
            });
        </script>
        </body>

        </html>