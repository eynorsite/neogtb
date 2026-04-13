<?php

namespace App\Observers;

use App\Models\PageContent;

class PageContentObserver
{
    public function saved(PageContent $content): void
    {
        PageContent::clearCache($content->page);
    }

    public function deleted(PageContent $content): void
    {
        PageContent::clearCache($content->page);
    }
}
