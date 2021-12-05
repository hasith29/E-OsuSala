# E-OsuSala
created to cater quality pharmaceuticals at an affordable price
Access
Access to GitHub repository:
https://github.com/hasith29/E-OsuSala.git

## Introduction
In the current Sri Lankan context and in even at the past there was not a system to cater to the wider range of the community who seek medicine or have medicinal needs. This wider range is the middle class and the lower class of our society who look for quality medicines at an affordable price. Even though there are physical pharmacies, which try to implement this concept, it has not been fruitful in achieving their goals. Hence, through this online system, I tried to evaluate the products for their quality and price in a shorter period. Then these trusted products after the evaluation process could be distributed via the implemented e-commerce system.

## How to setup
•	Clone the entire repository and add the cloned file/s to the htdocs(if using XAMPP server) or similar folder(if it’s LAMP or WAMP)
•	Next import the database file “pharm_db.sql” to the database(eg: http://localhost/phpmyadmin/ if it’s XAMPP server)
•	Then go to the link: http://localhost/pharm/  after the above configuration
•	You’ll be routed to the login page.
•	You have the option to create users and log in via that account.

## File structure
•	Config folder- All the database configurations included

### Customer
•	Customer/CSS, font, scsss, js, images- these include the styles, dynamic properties, images data tables & related libraries for the front end for the customer. 
•	About.html & contact.html – static pages for customer
•	Other .php files under the customer folder- Includes the main pages for the order handling flow from beginning to end
•	This communicates with the “models folder” in order to make updates/deletions to the database

### Supplier
•	“SupplierViews folder”- includes all the supplier views related PHP logic to handle supplier registration to tender acceptance/rejection
•	This communicates with the “models folder” in order to make updates/deletions to the database.
•	In addition, the “PHPMailer library” is added under the “models folder” to facilitate the mailing functionalities in the system.

### Admin
•	Other .php files directly included in the “views folder” are used to create the admin-related view and his/her functionalities. These functions are available “Mgeneric.php” and connections to this file are built using AJAX(POST captured by “model/ajax.php”).
•	In addition, the PHPMailer library is added under the “models folder” to facilitate the mailing functionalities in the system.

### Database
•	The database file is included as “pharm_db.sql”
