<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $teamMembers = [
            [
                'name' => 'Emna Grami',
                'image' => 'author-1.jpg',
                'facebook' => 'https://www.facebook.com/emna.grami.7',
                'linkedin' => 'https://www.linkedin.com/in/emna-grami-454a182b2/',
                'github' => 'https://github.com/gEmna123',
                'instagram' => 'https://www.instagram.com/emna_grami209/'
            ],
            [
                'name' => 'Rania Laffet',
                'image' => 'author-2.jpg',
                'facebook' => 'https://www.facebook.com/rania.laffet',
                'linkedin' => 'https://www.linkedin.com/in/rania-laffet-247ba0267/',
                'github' => 'https://github.com/ranialaffet',
                'instagram' => 'https://www.instagram.com/rania_laffet/'
            ],
            [
                'name' => 'Alae Mghirbi',
                'image' => 'author-3.jpg',
                'facebook' => 'https://www.facebook.com/profile.php?id=100011450325332',
                'linkedin' => 'https://www.linkedin.com/in/alae-mghirbi/',
                'github' => 'https://github.com/AlaeMghirbi',
                'instagram' => 'https://www.linkedin.com/in/alae-mghirbi/'
            ],
            [
                'name' => 'Karim Zaafrani',
                'image' => 'author-4.jpg',
                'facebook' => 'https://www.facebook.com/karim.zaafrani',
                'linkedin' => 'https://www.linkedin.com/in/karim-zaafrani-148868209/',
                'github' => 'https://github.com/Karim-Zaf',
                'instagram' => 'https://www.instagram.com/karim__zaafrani/'
            ],
            [
                'name' => 'Anis Laddada',
                'image' => 'author-5.jpg',
                'facebook' => 'https://www.facebook.com/anis.lad.7',
                'linkedin' => 'https://www.linkedin.com/in/anis-laddada-b46163263/?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app&fbclid=IwY2xjawG6q7lleHRuA2FlbQIxMAABHfsMy1ImtF-yZ3Jhey1qHhiB0XJ3WwVH-mhmV0cOkTuhzLHvjsZlG88F0A_aem_GwXa7kkG55QZifJT6_btjw',
                'github' => 'https://github.com/AnisLADDADA/AnisLADDADA',
                'instagram' => 'https://www.instagram.com/anis_lad/profilecard/?igsh=MWpydGJha3FjaDg5dQ=='
            ]
            
            
            
        ];

        return view('about', ['teamMembers' => $teamMembers]);
    }
}
