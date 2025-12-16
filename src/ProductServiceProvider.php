<?php

namespace Visio\Product;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ProductServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('product')
            ->hasConfigFile()
            ->hasMigrations([
                'create_ideas_table',
                'create_idea_comments_table',
            ]);
    }
}
