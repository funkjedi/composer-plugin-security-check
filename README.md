# Composer - Security Check Plugin

Plugin for Composer to check if your application uses dependencies with known security vulnerabilities.
Performs a securty check on your project's depenencies using the SensioLabs Security Checker.

The SensioLabs Security Checker is a command line tool that checks if your
application uses dependencies with known security vulnerabilities. It uses the
[SensioLabs Security Check Web service](http://security.sensiolabs.org) and the
[Security Advisories Database](https://github.com/FriendsOfPHP/security-advisories).

## Installation

    $ composer require funkjedi/composer-plugin-security-check --dev

## Usage

    $ composer check-security
