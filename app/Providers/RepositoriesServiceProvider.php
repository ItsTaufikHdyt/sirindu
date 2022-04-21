<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app->bind(
        //     AboutRepositoryInterface::class,
        //     AboutRepository::class,
        //     EducationRepositoryInterface::class,
        //     EducationRepository::class,
        //     ExperienceRepositoryInterface::class,
        //     ExperienceRepository::class,
        //     TagsRepositoryInterface::class,
        //     TagsRepository::class,
        //     SkillsRepositoryInterface::class,
        //     SkillsRepository::class,
        //     PortfolioRepositoryInterface::class,
        //     PortfolioRepository::class,
        // );
    }
}
