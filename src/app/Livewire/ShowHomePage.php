<?php

namespace App\Livewire;

use Livewire\Component;

class ShowHomePage extends Component
{
    public function render()
    {
        return view('livewire.show-home-page', [
            'logos' => \App\Models\Front\Logo::first(),
            'jargons' => \App\Models\Front\Jargon::first(),
            'footer_links' => \App\Models\Front\FooterLink::first(),
            'seo' => \App\Models\Front\Seo::first(),
            'page_config' => \App\Models\Front\PageConfig::first(),
        ]);
    }
}
