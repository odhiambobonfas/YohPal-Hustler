# YohPal-Hustler
Welcome to the YohPal App repository! This project aims to provide a fully functional HUSTLER application built with Flutter, Google's UI toolkit for crafting beautiful, natively compiled applications for mobile, web, and desktop from a single codebase.

## Feature-First Folder Structure

### Bindings

- Folder that holds all the app bindings
### Assets

- Has the - css js and images icons - 

### Pages

- Holds all the main Pages fot the app

### Partials

- Holds all the partial code to be imported and/or included in the main files

### Data

- ad connections

### Features

- This section will include all the functions and features for the app and api integrations

### Localization

- This is to facilitate integration with other languages

### Utils

- Here we have the: 

1. Constraints:contains all the colors, sizes, enums, texts and api_constraints
2. Device: Everything related to device functions
3. Formatters: all the formats for the apps e.g. phone number formats, email formats etc
4. Helpers:  This will contain all helper functions for the app
5. Http: Used to add http
6. local_storage: code for all storage
7. logging: all logs for the system
8. Theme: App dark and light theme
9. Validators: this includes validators for the email, password etc

## Commit Types

1. init: initialization
     - Example: init: initializing app
  
2. feat: A new feature for the user.
   - Example: feat: add social media login option
  
3. fix: A bug fix or correction.
   - Example: fix: correct faulty function logic for login

4. docs: Documentation updates.
   - Example: docs: update API endpoint details in README

5. style: Code style changes (formatting, missing semicolons, etc.) that do not affect functionality.
   - Example: style: apply consistent indentation across files

6. refactor: Code changes that neither fix a bug nor add a feature, such as code restructuring.
   - Example: refactor: improve readability of authentication module

7. test: Adding or modifying tests.
   - Example: test: add unit tests for user authentication

8. chore: Routine tasks such as dependency updates, build tasks, or maintenance tasks.
   - Example: chore: update dependency packages

9. perf: Code changes that improve performance.
   - Example: perf: optimize database queries in user service

10. build: Changes that affect the build system or external dependencies (e.g., Maven, Gradle, npm).
    - Example: build: configure webpack for production environment

11. ci: Changes to CI configuration files and scripts (e.g., GitLab CI, Jenkins, Travis).
    - Example: ci: update pipeline to include linting step

12. revert: Revert a previous commit.
    - Example: revert: revert "feat: add social media login option"

13. merge: Merging branches.
    - Example: merge: merge branch feature/authentication into main
  
14. DOC: Adding Document (.jpg, .png, .pdf ec).
    - Example: docs: adding documents.

15. static: UI pages
    - Example: adding pages to improve the app UI


## How to Run the Hustler Web App Project

### Requirements

* PHP 8.1 or newer
* Optional: Composer (for automatic class loading)
* Optional: Node.js + npm (for asset bundling)
* Local server setup (XAMPP, MAMP, or PHP built-in server)

### 1. Clone the Repository

```bash
git clone https://github.com/byteforge254/Yohpal-Hustler.git
cd Yohpal-Market/src
```

### 2. Configure the Environment

* Open `utils/config/` and update your `app.php` and other config files as needed (e.g., paths, environment, database).
* Set `PUBLIC_PATH` correctly.

### 3. Set Up Autoloading (Choose One)

#### Option 1: Manual Autoloading (No Composer)

If you prefer not to use Composer:

* Do **not** install or run Composer.
* Extract the following asset bundles manually inside the `assets/` folder:

  * `assets/bootstrap/` → from `bootstrap.zip`
  * `assets/vendor_modules/` → from `vendor_modules.zip`
  * `assets/build/` → from `build.zip`

Classes will autoload via the custom PHP autoloader.

#### Option 2: Composer Autoloading (Recommended for PHP Developers)

If you choose to use Composer:

```bash
composer install
composer dump-autoload
```

This installs dependencies and ensures classes autoload automatically. 

### 4. (Optional) Build JavaScript & CSS Assets

If you're using asset bundling with Webpack:

```bash
npm install
npm run build
```

> This compiles and bundles your frontend assets (JS/CSS) into the `assets/build/` directory.

### 5. Run the Application

#### Option 1: Using XAMPP or MAMP

* Move the `src/` folder into your `htdocs/` directory.
* Visit:
  `http://localhost/src`

#### Option 2: Using PHP's Built-In Server

```bash
php -S localhost:8000 -t src
```

Then open [http://localhost:8000](http://localhost:8000) in your browser. 