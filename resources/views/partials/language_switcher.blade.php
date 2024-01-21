<style>
.btn_lang { padding: 5px 10px; }
</style>

@foreach(config('app.available_locales') as $locale => $language)
    <a class="btn_lang h-16 w-16 bg-red-50 dark:bg-red-800/20 p-1 items-center justify-center rounded" href="{{ url("language/".$language) }}">{{ $locale }}</a>
@endforeach