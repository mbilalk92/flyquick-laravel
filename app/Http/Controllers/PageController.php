<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::with('activeSections')->where('slug', '/')->firstOrFail();
        return $this->renderPage($page);
    }

    public function show(Request $request, string $slug)
    {
        // Normalise: strip trailing slash, lowercase
        $slug = rtrim(strtolower($slug), '/');

        $page = Page::with('activeSections')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$page) {
            abort(404);
        }

        return $this->renderPage($page);
    }

    private function renderPage(Page $page)
    {
        $metaTitle = $page->meta_title ?: ($page->title . ' | Fly Quick');
        $metaDesc  = $page->meta_description ?: '';

        return view('pages.dynamic', compact('page', 'metaTitle', 'metaDesc'));
    }
}
