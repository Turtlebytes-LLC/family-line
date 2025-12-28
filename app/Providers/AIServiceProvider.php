<?php

namespace App\Providers;

use App\Contracts\AI\TimelineParserInterface;
use App\Services\AI\ClaudeTimelineParser;
use App\Services\AI\LocalTimelineParser;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TimelineParserInterface::class, function ($app) {
            // Use Claude if API key is configured, otherwise fallback to local parser
            $apiKey = config('services.anthropic.api_key');

            if (!empty($apiKey)) {
                return new ClaudeTimelineParser();
            }

            return new LocalTimelineParser();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
