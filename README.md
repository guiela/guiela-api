# Guiela UI

This is the API source code for Guiela, an Open source project built on [Laravel](https://laravel.com/) framework for automated bank reconciliations. This is a two part application that totally separates the business logic from the user interface, an idea implemented to enable the Developer Circle team participate solely on the code base they are familiar with without having to deal with alien code.

## Project setup

### Requirement
- Laravel Please visit [laravel.com](https://laravel.com/docs/6.x) for more information on Laravel Framework requirements.
- PHP >= 7.2.0
- Composer

### Installation

Clone the repository to your local machine and from the root directory of the application run the following command:

```
composer install
```

This will take a few seconds to install all the dependencies required to run the application.

**Note that development environments vary, so if there is an error during this process please go through the error output messages to learn the cause of the problem, knowing the problem will help your research on how to fix it.**

## Configuration
After installation, create a .env file in the root directory then copy and paste the contents of .env.example to it.

### Start server

Start the development server by running the following:

```
php artisan serve
```
Now check for the port on the command line terminal to know where our application is available, e.g. `http://localhost:8000/` and visit it via the browser.

## Contributing

## Issue Reporting Guidelines
- The issue list of this repo is exclusively for bug reports and feature requests. Non-conforming issues will be closed immediately.

- Try to search for your issue, it may have already been answered or even fixed in the development branch.

- Check if the issue is reproducible with the latest stable version of Vue. If you are using a pre-release, please indicate the specific version you are using.

- It is required that you clearly describe the steps necessary to reproduce the issue you are running into.

- For bugs that involves build setups, you can create a reproduction repository with steps in the README.

- If your issue is resolved but still open, don’t hesitate to close it. In case you found a solution by yourself, it could be helpful to explain how you fixed it.

### Pull Request Guidelines
- The master branch is basically just a snapshot of the latest stable release. All development should be done in dedicated branches. Do not submit PRs against the master branch.

- Checkout a topic branch from the relevant branch, e.g. dev, and merge back against that branch.

- Work in the src folder and DO NOT checkin dist in the commits.

- It's OK to have multiple small commits as you work on the PR - we will let GitHub automatically squash it before merging.

- Make sure npm test passes. (see development setup)

- If adding new feature:

- - Add accompanying test case.
- - Provide convincing reason to add this feature. Ideally you should open a suggestion issue first and have it greenlighted before working on it.
- If fixing a bug:

- - Provide detailed description of the bug in the PR. Live demo preferred.
- - Add appropriate test coverage if applicable.

## License

The Guiela is open-sourced software licensed under the MIT license.

## Usage 

Usage documentation will be available via a Wiki soon.

## License

The Guiela is open-sourced software licensed under the MIT license.