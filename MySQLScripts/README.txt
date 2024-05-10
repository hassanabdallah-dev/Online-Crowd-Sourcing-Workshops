### Application Setup Instructions

This guide provides detailed instructions for setting up the application environment.

#### 1. Sql Scripts Execution

Executing only SQL scripts is not sufficient for running the application.

#### 2. Database Setup Script

The `1create_db.cmd` script executes SQL scripts and runs database seeds containing preferences, users, and their roles.

#### 3. Application Requirements

- The application can run without users, but preferences are mandatory.

#### IMPORTANT:

- **Execution Order**:
  1. Execute `1create_db.cmd` before `create_users.cmd`.
- **Setup Shortcut**:
  - Instead of executing individual scripts, you can run `setup.cmd` in the project directory, which performs the same actions.

