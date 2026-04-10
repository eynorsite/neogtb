<?php

namespace App\View\Composers;

use Illuminate\View\View;

class BreadcrumbComposer
{
    public function compose(View $view): void
    {
        $breadcrumbs = $this->buildBreadcrumbs();
        $view->with('breadcrumbs', $breadcrumbs);
    }

    private function buildBreadcrumbs(): array
    {
        $segments = request()->segments();
        $crumbs = [['name' => 'Accueil', 'url' => url('/')]];

        if (empty($segments)) {
            return $crumbs;
        }

        $labels = config('breadcrumbs.labels', []);
        $path = '';

        foreach ($segments as $segment) {
            $path .= '/' . $segment;
            $crumbs[] = [
                'name' => $labels[$segment] ?? ucfirst(str_replace('-', ' ', $segment)),
                'url'  => url($path),
            ];
        }

        return $crumbs;
    }
}
