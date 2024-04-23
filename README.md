# Startup Capital Management System

Startup Capital Management System is a dynamic web application designed to facilitate the management of capital participation requests from startup founders seeking funding for their projects, as well as participation requests from venture capitalists. The system allows startup founders to submit participation requests for the financing of their projects in the form of shares, with the hope of selling them to venture capitalists. Venture capitalists, on the other hand, can browse the list of projects and potentially purchase shares in projects that interest them, thereby becoming shareholders.

## Project Overview

The system involves two main actors:

1. **Startup Founder**: Responsible for registering and submitting information about their company, adding projects for funding, and managing project details and participants.
   
2. **Venture Capitalist**: Responsible for registering, browsing projects for investment opportunities, purchasing shares in projects, and managing their investments.

## System Features

### Startup Founder:

- **Registration**: Register by providing name, surname, national ID number (8 digits), email, company name, company address, business registration number (1 uppercase letter followed by 10 digits), and a profile picture. Choose a username and password (at least 8 characters, ending with either '$' or '#').
  
- **Authentication**: Log in using the chosen username and password.

- **Profile Management**: Edit profile information.

- **Project Management**:
  - Add projects for funding, including title, detailed description, number of shares to sell, and share value.
  - View and edit project details, including remaining shares, amount collected, and actions sold.
  - Delete projects with no shares sold.

### Venture Capitalist:

- **Registration**: Register by providing name, surname, email, national ID number (8 digits), and choosing a username and password (at least 8 characters, ending with either '$' or '#').

- **Authentication**: Log in using the chosen username and password.

- **Project Exploration**:
  - Browse all projects or search for specific projects using keywords in the project descriptions.

- **Investment**:
  - View project details, including title, description, remaining shares, and share price.
  - Purchase shares in projects.

- **Investment Management**:
  - View a list of projects in which they have invested.
  - Display the number of shares purchased in each project and the total investment amount for each project.

## Technologies Used

- **Frontend**:
  - HTML
  - CSS
  - JavaScript (with input validation)
  - Bootstrap
  
- **Backend**:
  - PHP
  
- **Database**:
  - MySQL
 
   ## some screenshots
- **Home page**:
![Capture d'écran 2024-04-02 203727](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/9e112aad-e4a8-4098-9deb-2d679c4d6c16)
![Capture d'écran 2024-04-02 203901](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/ffc39483-d68f-4299-820f-1b2001879686)
![Capture d'écran 2024-04-02 213537](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/d4dca57c-a95c-4fd7-9a93-dab66f15aa1b)
- **sign in**:
![Capture d'écran 2024-04-02 204222](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/a41a10ed-201e-492a-8e5e-2cedd15ff293)
- **sign up**:
![Capture d'écran 2024-04-02 204133](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/1887d29c-76e0-46eb-b819-c7dedace5459)
- **startuper dashboard**:
![Capture d'écran 2024-04-02 204423](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/505ff4d5-ceae-42c3-aa52-8d9bfed5fb10)
- **add  a project**:
![Capture d'écran 2024-04-03 231951](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/c0f27950-078f-4531-99cf-c2c847876668)
- **capital participation dashboboard**:
![Capture d'écran 2024-04-03 232809](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/bd112064-6f3c-4ee4-988e-c82c178cc95e)
- **edit  a project**:
![Capture d'écran 2024-04-03 232457](https://github.com/SoumayaRomdhani/dynamic-web-application_startup_capital_management/assets/157825319/d3c44d9a-d260-4f34-8a44-0f8781beaf1b)

## Getting Started

To run the system locally, follow these steps:

1. Clone this repository to your local machine.
2. Set up a local web server with PHP support.
3. Import the provided MySQL database schema.
4. Configure the database connection in the PHP files.
5. Access the system via the web browser.

## Contributing

Contributions to improve and enhance the system are welcome. Please fork this repository, make your changes, and submit a pull request.


