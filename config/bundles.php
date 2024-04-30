<?php

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use League\Bundle\OAuth2ServerBundle\LeagueOAuth2ServerBundle;
return [
    FrameworkBundle::class => ['all' => true],
    DoctrineBundle::class => ['all' => true],
    DoctrineMigrationsBundle::class => ['all' => true],
    DebugBundle::class => ['dev' => true],
    TwigBundle::class => ['all' => true],
    WebProfilerBundle::class => ['dev' => true, 'test' => true],
    WebpackEncoreBundle::class => ['all' => true],
    TwigExtraBundle::class => ['all' => true],
    SecurityBundle::class => ['all' => true],
    MonologBundle::class => ['all' => true],
    MakerBundle::class => ['dev' => true],
    SensioFrameworkExtraBundle::class => ['all' => true],
    LeagueOAuth2ServerBundle::class => ['all' => true],
];
