<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
	Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
	Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
	EMS\ClientHelperBundle\EMSBackendBridgeBundle\EMSBackendBridgeBundle::class => ['all' => true],
	EMS\ClientHelperBundle\EMSWebDebugBarBundle\EMSWebDebugBarBundle::class => ['dev' => true],
];
