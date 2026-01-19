# 🧠 COVID-19 Tracker and Hospital Management System
The COVID-19 Tracker and Hospital Management System is a comprehensive web application designed to track COVID-19 cases, manage hospital data, and provide a user-friendly interface for administrators, doctors, and users. The system fetches COVID-19 data from an external API, displays it on the page, and allows users to view hospital information, available tests, and vaccines. The application also features a login system, user authentication, and session management.

## 🚀 Features
* Fetches COVID-19 data from an external API and displays it on the page
* Allows users to view hospital information, available tests, and vaccines
* Features a login system, user authentication, and session management
* Provides a dashboard for hospital doctors to update vaccine quantities and view relevant information
* Offers a dashboard for administrators to add hospitals, export reports, and view relevant information
* Includes interactive tables and bar charts to visualize data
* Supports user-friendly navigation and flow

## 🛠️ Tech Stack
* Frontend: HTML, CSS, JavaScript, Bootstrap, Font Awesome
* Backend: PHP, MySQL
* Database: MySQL
* APIs: COVID-19 API
* Libraries: Chart.js, jQuery, DataTables
* Tools: cURL, mysqli

## 📦 Installation
To install the application, follow these steps:
1. Clone the repository using `git clone`
2. Create a database and import the schema from `setup.sql`
3. Configure the database connection settings in `config.php`
4. Install the required libraries and dependencies
5. Run the application using a web server such as Apache or Nginx

## 💻 Usage
1. Open the application in a web browser
2. Login as an administrator, doctor, or user
3. View hospital information, available tests, and vaccines
4. Update vaccine quantities and view relevant information as a hospital doctor
5. Add hospitals, export reports, and view relevant information as an administrator

## 📂 Project Structure
```markdown
.
├── assets
│   ├── js
│   │   ├── global.js
│   │   └── dash.js
│   └── css
│       └── style.css
├── config
│   └── config.php
├── hospitals
│   └── index.php
├── management
│   ├── hospitals
│   │   └── doctor
│   │       └── index.php
│   └── admin
│       └── index.php
├── setup
│   └── setup.sql
├── user
│   └── login
│       └── index.php
├── index.php
└── README.md
```

## 📸 Screenshots

## 🤝 Contributing
To contribute to the project, please fork the repository, make changes, and submit a pull request.

## 📝 License
The project is licensed under the MIT License.

## 📬 Contact
For any questions or concerns, please contact us at [support@example.com](mailto:support@example.com).

## 💖 Thanks Message
We would like to thank all the contributors and users of the COVID-19 Tracker and Hospital Management System. This is written by [readme.ai](https://readme-generator-phi.vercel.app/).
