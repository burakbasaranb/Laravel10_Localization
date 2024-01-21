# Laravel10 Localization Example

## Introduction

Your Laravel 10 Localization example provides a template for developers to easily implement multi-language support in their applications. This is achieved through two different approaches: URL-based language selection and session-based language storage.

## Install Laravel

```bash
    composer create-project laravel/laravel Laravel10_Lacalization --prefer-dist
```
### Start Laravel
```bash
    php artisan serve
```

## Common Configuration

In your Laravel 10 Localization example, you likely have common configurations for creating and managing language files. Laravel simplifies the process of localization by organizing language files within the resources/lang directory. The structure typically involves subdirectories for each language, such as en for English and es for Spanish. Within these directories, developers can create PHP or JSON files containing key-value pairs representing translations for different language strings used throughout the application.

To create a new language file, developers often utilize the artisan command-line tool, provided by Laravel. The command php artisan make:lang or a similar variant helps in generating the necessary directory structure and initial files. Once the language files are created, developers can easily manage translations by populating the files with translations for each supported language. Laravel's intuitive syntax and conventions make it straightforward to maintain and update these language files as the application evolves.

By incorporating these common configurations, your template promotes a standardized and organized approach to managing language files, enabling developers to efficiently handle translations and maintain a clean codebase for multi-language support in Laravel applications.

```
```

## 1. Way: URL-Based Language Selection

In the first method, you've opted for URL-based language selection. This means that the language variable is passed as a parameter in the URL, such as http://127.0.0.1:8000/en. This approach is user-friendly and allows users to easily switch between languages by modifying the URL.

To implement this, you've likely used Laravel's routing system to capture the language variable from the URL and set the application locale accordingly. This ensures that all subsequent translations and language-related features are applied based on the selected language.

## Code Configuration


