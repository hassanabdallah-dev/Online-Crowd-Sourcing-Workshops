### Project Setup and Execution Guide

This guide provides instructions for setting up the project environment and running the server.

#### 1. First Run Setup

- **Database Setup**: 
  - Execute the provided database setup scripts to initialize the databases.
  
- **Account Creation**:
  - The following accounts will be inserted along with their respective roles:
    - admin@admin.com
    - monitor@monitor.com
    - p1@p1.com
    - p2@p2.com
    - p3@p3.com
    - p4@p4.com
    - p5@p5.com
    - p6@p6.com
    - p7@p7.com
    - p8@p8.com
    - p9@p9.com
    - p10@p10.com
  - All accounts will have the password: 12345678.

- **Preferences for Admin**:
  - Insert preferences for the admin user.

#### 2. Running the Server

Execute the `ServerRun` script to start the server.

#### 3. SessionBox Extension for Chrome

For running multiple sessions in the same browser with multiple tabs, install the SessionBox extension for Chrome.  
[SessionBox Extension Link](https://chrome.google.com/webstore/detail/sessionbox-free-multi-log/megbklhjamjbcafknkgmokldgolkdfig?hl=en)

#### Notes:

- **Application URL**: 127.0.0.1:8000
- **Database Name**: "crowdcrowd"
- If batch scripts are not preferred, manually create a database named "crowdcrowd" and execute the following commands:
  - Navigate to the "CrowdSourcing" directory.
  - Run `php artisan migrate:refresh` to refresh migrations.
  - Run `php artisan serve` to start the server.
- **Admin Preferences**:
  - Enabling Accounts Email Verification will send emails to current accounts for activation.
  - Turning off this preference will verify all accounts automatically. It is off by default.
- **Security Message from Chrome**:
  - A security message may appear in Chrome due to the database seeds method used for account creation, which differs from normal registration processes.
