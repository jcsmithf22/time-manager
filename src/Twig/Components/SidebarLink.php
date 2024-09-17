<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class SidebarLink
{
    public string $link;
    public string $highlightRoutes = '';
}
