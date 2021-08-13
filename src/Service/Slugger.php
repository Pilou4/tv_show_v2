<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class Slugger
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function sluggify($str)
    {
        return $this->slugger->slug($str);
    }
}