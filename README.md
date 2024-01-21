# Laravel10 Localization Example

## Introduction

Your Laravel 10 Localization example provides a template for developers to easily implement multi-language support in their applications. This is achieved through two different approaches: URL-based language selection and session-based language storage.

- Install Laravel

```bash
    composer create-project laravel/laravel Laravel10_Lacalization --prefer-dist
```
- Start Laravel
```bash
    php artisan serve
```

## Common Configuration

In your Laravel 10 Localization example, you likely have common configurations for creating and managing language files. Laravel simplifies the process of localization by organizing language files within the resources/lang directory. The structure typically involves subdirectories for each language, such as en for English and es for Spanish. Within these directories, developers can create PHP or JSON files containing key-value pairs representing translations for different language strings used throughout the application.

To create a new language file, developers often utilize the artisan command-line tool, provided by Laravel. The command php artisan make:lang or a similar variant helps in generating the necessary directory structure and initial files. Once the language files are created, developers can easily manage translations by populating the files with translations for each supported language. Laravel's intuitive syntax and conventions make it straightforward to maintain and update these language files as the application evolves.

By incorporating these common configurations, your template promotes a standardized and organized approach to managing language files, enabling developers to efficiently handle translations and maintain a clean codebase for multi-language support in Laravel applications.

### Step 1: Publish Language Files

In Laravel, the application skeleton doesn't include the lang directory by default. To customize Laravel's language files, you can publish them using the following command:	

```
    php artisan lang:publish
```

This command generates default PHP language files. However, for this example, we'll use JSON files.

#### Create JSON Language Files Manually

Create the following JSON language files manually in the lang directory:

- lang\en.json
- lang\tr.json
- lang\fr.json
- lang\es.json
- lang\de.json
- lang\it.json
- lang\pt.json
- lang\ru.json
- lang\cn.json

#### JSON Model:

The structure of each JSON file should follow a model like this:

```json
{
    "Welcome to our website!": "DE: Willkommen auf unserer Website!",
    "Laravel Localization Demo": "DE: Laravel Lokalisierungs-Demo"
} 
```

Feel free to replace the example translations with your own content. Each JSON file corresponds to a specific language and contains key-value pairs for the translated strings. The keys represent the original English strings, and the values are their respective translations in the specified language.

By following these steps, you'll have a solid foundation for customizing and managing language files in your Laravel application. Adjust the translations in the JSON files to suit your project's requirements and add more languages as needed.

### Step 2: Add Available Locales

To specify the available locales for your Laravel application, follow these steps:

- Open the config/app.php file.
- Locate the available_locales section and add the following lines:

```
/*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | List all locales that your application works with
    |
    */
    'available_locales' => [
        'English' => 'en',
        'Türkçe' => 'tr',
        'French' => 'fr',
        'Español' => 'es',
        'Deutsch' => 'de',
        'Italiano' => 'it',
        'Português' => 'pt',
        'Русский' => 'ru',
        '中文（中国' => 'cn',
    ],
```

This configuration allows you to define a mapping between the human-readable names of languages (e.g., 'English', 'Türkçe') and their corresponding locale codes (e.g., 'en', 'tr'). These locales represent the languages your application will support.

Ensure that you've accurately listed all the locales your application will work with. This step is crucial for Laravel to know which language files to load based on the user's preferences.

By completing this step, you've established the available locales for your Laravel application, paving the way for seamless multilingual support. Adjust the list as needed to match the specific languages your application will cater to.

### Step 3: Change Default Language

To set the default language for your Laravel application, follow these steps:

- Open the config/app.php file.
- Locate the 'locale' parameter and change its value to your desired default language code. For example:

```
    'locale' => 'en',
```

Replace 'en' with the desired default language code from the available locales you defined in the previous step.

Setting the default language ensures that when a user visits your application for the first time or when their preferred language is not available, the application will display content in the default language.

By completing this step, you've configured the default language for your Laravel application. Adjust the default language code as needed based on the language preferences of your target audience.

## 1. Way: URL-Based Language Selection

For the first method, you've chosen URL-based language selection, allowing users to specify the language through the URL parameter, such as http://127.0.0.1:8000/en. This approach provides a user-friendly way to switch between languages by simply modifying the URL.

#### Implementation

You likely implemented this by utilizing Laravel's powerful routing system to capture the language variable from the URL and dynamically set the application locale. This ensures that the application serves content in the language specified in the URL, affecting translations and other language-related features.

#### Route Configuration

In your `routes/web.php` file, you've added the following route configuration:

```php

/*
 * 1. Way
 * This route is get the current locale in the url
 * http://127.0.0.1:8000/tr
 *
 */
Route::get('/{locale?}', function ($locale = null) {
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
    }
    
    return view('welcome');
});
```

This route captures the optional `{locale}` parameter from the URL and checks if it's a valid language code from the available locales configured earlier. If a valid language code is found, it sets the application locale accordingly using `app()->setLocale($locale)`.

By implementing URL-based language selection in this manner, you've enhanced the user experience by providing a straightforward method for users to navigate and switch between languages seamlessly.

## 2. Way: Session-Based Language Selection

For the session-based language selection approach, you likely have code that checks the session for the presence of a language variable. If found, the application sets the locale accordingly. If not, it might default to a predefined language or the system's default.

The code for this method involves interactions with Laravel's session management, utilizing functions like `session()->get()` to retrieve the stored language preference and `session()->put()` to store the selected language.

### Step 1: Create Middleware to Control Locale with Session

Begin by creating a middleware to manage the session-based language selection. Run the following command to generate the middleware:

```
php artisan make:middleware Localization
```

This command creates a new middleware class named Localization in the app/Http/Middleware directory such as `app/Http/Middleware/Localization.php`.

### Step 2: Implement Middleware Logic

Open the newly created middleware file, `app/Http/Middleware/Localization.php`, and implement the logic to control the locale based on the session:

```
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    
    /**
     * Middleware for handling localization of incoming requests.
     *
     * This middleware is responsible for handling the localization of incoming requests.
     * It sets the locale of the application based on the user's preferred language.
     *
     * @param  \Illuminate\Http\Request $request The incoming request.
     * @param  \Closure                 $next    The next middleware.
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
    
        return $next($request);
    }
}
```

This middleware checks the session for a stored `locale` value. If found and it's a valid language code, it sets the application locale `using App::setLocale($locale)`.

### Step 3: Register Middleware

To enable the session-based language management middleware, add the `\App\Http\Middleware\Localization::class` line into the `web` array in the `app\Http\Kernel.php` file. This ensures that the middleware is applied to web requests.

Open the `app\Http\Kernel.php` file and modify the `web` middleware group as follows:
```
protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\Localization::class, // Added for localization Session
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
```
By adding `\App\Http\Middleware\Localization::class` to the `web` middleware group, you ensure that the localization middleware is applied to web routes. This middleware will now manage the application locale based on the session, providing a seamless language experience for users. Adjust the configuration as needed to fit the requirements of your multilingual Laravel application.

### Step 4: Create Language Switcher

To allow users to switch between languages easily, create a language switcher in the `resources\views\partials\language_switcher.blade.php` file. This file will contain the HTML and Blade directives needed for the language switcher.

Create or update the `resources\views\partials\language_switcher.blade.php` file with the following content:

```
<style>
.btn_lang { padding: 5px 10px; }
</style>

@foreach(config('app.available_locales') as $locale => $language)
    <a class="btn_lang h-16 w-16 bg-red-50 dark:bg-red-800/20 p-1 items-center justify-center rounded" href="{{ url("language/".$language) }}">{{ $locale }}</a>
@endforeach
```

This code generates a set of language buttons, each representing a different language. The buttons are styled with a basic design, but you can customize the styles as needed for your application.

The `url("language/".$language)` generates the URLs for changing the language based on the language codes defined in your application. Users can click on these buttons to switch between languages.

Include this partial view wherever you want the language switcher to appear in your application.

With this step, you've implemented a language switcher that allows users to easily switch between available languages using the specified URLs. Adjust the styling and placement of the language switcher based on your application's design requirements.

### Step 6: Control Language Session

In this step, you're implementing a route to handle changing the language based on user preferences and storing the selected language in the session.

Update your `routes\web.php` file to include the following route configuration:

```
/**
 * 2. Way
 * This route is used for changing the language
 * Keep in Session the selected language
 */
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
```

This route is responsible for handling requests to change the language. When a user visits a URL like `language/de`, it sets the application locale to the specified language (`app()->setLocale($locale)`) and stores the selected language in the session (`session()->put('locale', $locale)`). After that, the user is redirected back to the previous page (`return redirect()->back()`).

With this route, you've created a mechanism for users to change the language by visiting URLs like `language/de`, and the selected language is maintained in the session for a consistent language experience across the application. Adjust this route as needed to fit the requirements of your multilingual Laravel application.

### Step 7: Install Switcher to Page

To integrate the language switcher into your page, follow these steps in the `resources\views\welcome.blade.php` file:

- Add the `@include('partials/language_switcher')` directive where you want the language switcher to appear.
- Update the relevant code in your page, incorporating the language switcher.

Here's an example of how the relevant part of your `resources\views\welcome.blade.php` file might look:

```
<div class="flex justify-center mt-16">
    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Laravel Localization Demo') }}</h2>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                @include('partials/language_switcher')
            </p>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            session()->get('locale') : <b> {{ session()->get('locale') }} </b>
            </p>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {{ __('Welcome to our website!') }}
            </p>
        </div>
    </div>
</div>
```

In this example, the `@include('partials/language_switcher')` directive is placed where you want the language switcher to appear within your page. This allows users to easily switch between languages directly from the page.

Make sure to customize the styling and layout to fit the design of your application. With these steps, you've successfully integrated the language switcher into your Laravel application's welcome page. Users can now change the language directly from the page, and the selected language is stored in the session for a consistent experience.

### Step 8: Manage the Language Text

To manage language text in your Laravel application, utilize the `__('key')` syntax in your Blade views. This allows you to retrieve translated text based on the provided key from your language files.

For example, in your Blade views:

```
{{ __('Welcome to our website!') }}
```
Here, `__('Welcome to our website!')` serves as a placeholder for the actual translation of the text based on the selected language.

Ensure that you have corresponding translations in your language files (e.g., `lang/en.json`, `lang/tr.json`, etc.):

```json
{
    "Welcome to our website!": "DE: Willkommen auf unserer Website!",
    // ... other translations
}
```

By using the `__('key')` function, Laravel will automatically fetch the translation for the specified key based on the current locale.

Make sure to replace `Welcome to our website!` with the keys used in your language files.

This approach provides a convenient way to manage and display language-specific text throughout your application, ensuring a smooth and localized user experience.
