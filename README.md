# Project Name

This README provides instructions for installing and running the [Real-Time Automatic CrowdSourcing] project. The project utilizes various technologies and dependencies outlined below.

The `report.pdf` file represents details about the target of this web application, the approach followed, the database architecture, along with visual demonstrations of the main parts of the application.

## Installation

### Batch Files
Batch files are provided to streamline the installation and execution process without the need for manual commands.

### Dependencies
- **MySQL**: Version 8.0.16 for Win64 on x86_64 (MySQL Community Server - GPL)
- **Laravel Framework**: Version 6.9.0

### Scripts
Certain scripts in the project utilize the `mysql` command with the username "root" to create users with their privileges. These scripts prompt for the root password during execution. These scripts are essential for running the application, as each user is granted access to a specific part of the database.

## Prerequisites
- Ensure that `php` command is defined in the system PATH environmental variable to execute the application.
- Laravel framework must be installed prior to running the application.

