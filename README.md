# Attendance Management System (AMS)

## Overview

The Attendance Management System (AMS) is a web-based application designed to streamline and automate the process of tracking and managing attendance for University of Bolton. The system aims to provide an efficient and user-friendly solution for recording, monitoring, and analyzing attendance data.

## Features

- **User Authentication:** Secure login for administrators, teachers, and students.
- **Attendance Tracking:** Real-time recording of attendance for students in various classes or sessions.
- **Reporting and Analytics:** Generate attendance reports and analytics for informed decision-making.
- **Notifications:** Automated alerts and notifications to keep stakeholders informed about attendance-related events.
- **Role-Based Access Control:** Control access levels for different users based on their roles and responsibilities.
- **Data Backup and Recovery:** Robust data management with backup and recovery procedures to prevent data loss.

## Getting Started

### Prerequisites

Ensure you have the latest version of xampp and composer installed and have visual stud

### Installation

1. Clone the repository: `git clone https://github.com/imerkmark/Attendance-Management-System.git`
2. Save the project folder in the htdocs folder in the xampp folder 
3. Open the command line from the xampp control panel and run the command : `cd Attendance-Management_System C:\xampp\htdocs\Attendance-Management-System`
4. And then run the command : `composer require phpoffice/phpspreadsheet` 
5. Configure the database connection and the smtp server as specified in the Configuration section below.
6. Run the application: from your code editor
7. Access the application in your web browser: `http://localhost:8000/Attendance-Manangement-System/index.php`

## Configuration

To set up the SMTP server:
1. go to xampp/sendmail/sendmail.ini file and clear all text from it and add
    `[sendmail]
    smtp_server=smtp.gmail.com
    smtp_port=587
    error_logfile=error.log
    debug_logfile=debug.log
    auth_username=md.zaidd31@gmail.com
    auth_password=hmol xlyt flfg mues
    force_sender=md.zaidd31@gmail.com`
   where you can replace the force_sender and auth username with your gmail ID.
   and auth_password is the password generated in the two factor authentication setting section of your google account. 
   
2. Copy the path to the sendmail.exe from the xampp//sendmail folder.
3. Go to the php.ini config file and paste the above path after : `sendmail_path`  
4. Add the below texts under the `[mail function]` section of the php.ini
   `SMTP=smtp.gmail.com
    https://php.net/smtp-port
    smtp_port=587`
  and
  `https://php.net/sendmail-from
   sendmail_from = md.zaidd31@gmail.com`
   where you can replace md.zaidd31@gmail.com with your email address.
   
6. Uncomment `extension=openssl` under the extensions section of the php.ini file

To setup the database
1. Go to the php.ini file and
     increase `post_max_size` to 160M
     increase `upload_max_filsize` to 160M
     increase `max_execution_time` to 12000
     increase `mwmory_limit` to 1024M
2. Save the file and start the Apache and MySQL
3. Go to phpMyAdmin
4. Click on user accounts
5. Create a user account with the details
     username: `zaid`
     HostName: `localhost`
     password: `1234`
grant all privelleges and add the user
6. Create a database called `attendance`
7. Import thesql file named `database` located in the project file 

## Usage

1. **Login:** Use valid credentials to access the system.
2. **Attendance Recording:** Teachers can mark attendance for their classes.
3. **Reporting:** Generate attendance reports for specific time periods, classes, or students.
4. **Notifications:** Configure and receive notifications for critical attendance events.
5. **User Management:** Admins can manage user accounts and access permissions.


## License

This project is licensed under the [MIT License](LICENSE.md).


## Contact

For support or inquiries, contact md.zaidd31@gmail.com
