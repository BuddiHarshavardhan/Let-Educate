<?php 

include('./constant/check.php');
require_once('./constant/connect.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">

<div id="main-wrapper">
    <div class="header">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                <b><img src="./assets/uploadImage/Logo/logo.jpg" alt="homepage" class="dark-logo" style="width:230px;height:90px;border-radius: 10px solid;"/></b>
            </a>
        </div>
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-collapse">
                <ul class="navbar-nav mt-md-0 ml-auto">
                    <li class="nav-item">
                       
                    </li>
                    <li class="nav-item dropdown">
                        <!-- Dropdown with Profile Image and Logout Option -->
<a class="nav-link dropdown-toggle text-muted" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <b>WELCOME</b>
    <img src="./assets/uploadImage/Profile/young-woman-avatar-facial-features-stylish-userpic-flat-cartoon-design-elegant-lady-blue-jacket-close-up-portrait-80474088.jpg" alt="user" class="profile-pic" />
</a>

<div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
    <a class="dropdown-item" href="./constant/logout.php">
        <i class="fa fa-power-off"></i> Logout
    </a>
</div>

                        <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                            <ul class="dropdown-user">
                                <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                                    <!-- <li><a href="#"><i class="fa fa-key"></i> Changed Password</a></li> -->
                                    <!-- <li><a href="#"><i class="fa fa-user"></i> Add user</a></li> -->
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        function fetchCustomerBirthdays() {
            fetch('fetch-birthday.php')  // Fetch from your PHP script
                .then(response => response.json())
                .then(data => {
                    const alertsContainer = document.getElementById('alerts');
                    alertsContainer.innerHTML = ''; // Clear existing alerts

                    const today = new Date();
                    const todayString = today.toISOString().slice(0, 10);

                    let hasAlert = false;
                    data.forEach(person => {
                        const dob = new Date(person.dob);
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        const formattedDob = dob.toLocaleDateString(undefined, options);

                        const alert = document.createElement('div');
                        alert.className = 'alert alert-info';

                        // Prepare the WhatsApp message
                        const whatsappMessage = `Happy Birthday, ${person.name}! 🎉`;
                        
                        // Make sure the phone number is in the correct format
                        const phoneNumber = person.phone.replace(/\D/g, ''); // Remove non-numeric characters
                        const whatsappLink = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(whatsappMessage)}`;

                        alert.innerHTML = `
    <span class="material-symbols-outlined">cake</span>
    <div class="message">Today is ${person.name}'s birthday.</div>
    <a href="${whatsappLink}" target="_blank" class="whatsapp-link">
        <i class="fa-brands fa-whatsapp" style="color: green; font-size: 24px;"></i>
    </a>
`;

                        alertsContainer.appendChild(alert);

                        hasAlert = true;
                    });

                    if (hasAlert) {
                        alertsContainer.classList.add('show');
                    } else {
                        alertsContainer.classList.remove('show');
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        fetchCustomerBirthdays();
        setInterval(fetchCustomerBirthdays, 3600000); // Refresh every hour

        const notificationBar = document.getElementById('notification-bar');
        const alertsContainer = document.getElementById('alerts');

        notificationBar.addEventListener('click', () => {
            alertsContainer.classList.toggle('show');
        });
    });
</script>
<head>
    <!-- Other head content -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    /* Header styles */
.header {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Ensures space between logo and right-side items */
    position: relative;
    padding: 10px;
}

/* Logo styles */
.navbar-header {
    flex: 1; /* Makes the logo container take up as much space as needed */
}

/* Notification icon styles */
.notification-bar {
    position: relative;
    cursor: pointer;
    padding:10px;
    margin-right: 40px;
    display: flex;
    align-items: center;
    color:blue;
}

/* Other right-side elements styles */
.navbar-collapse {
    display: flex;
    align-items: center;
}

/* Make sure to align the profile and notification icons to the right */
.navbar-nav.my-lg-0 {
    margin-left: auto;
}

.material-symbols-outlined {
    font-size: 24px;
}

/* Alerts container styles */
.alerts-container {
    display: none;
    position: absolute;
    top: 40px;
    right: 0;
    width: 350px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.alerts-container.show {
    display: inline;
}

.alert {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.alert:last-child {
    border-bottom: none;
}

.alert-info {
    color: #0056b3;
}

.alert-info .material-symbols-outlined {
    font-size: 20px;
    margin-right: 10px;
}

.message {
    display: inline-block;
}
.whatsapp-link i {
    margin-left: 10px;
    vertical-align: middle;
}
.whatsapp-link i {
    margin-left: 10px;
    vertical-align: middle;
}

</style>