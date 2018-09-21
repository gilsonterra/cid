<?php
return [
    'settings' => [
        'addContentLengthHeader' => false,// debugbar possible not working with true
        'debug'               => true,
        'displayErrorDetails' => true,
        'view'                => [
          'template_path' => __DIR__ . '/../resources/views/',
          'twig'          => [
            'cache'       => __DIR__ . '/../storage/cache',
            'debug'       => true,
            'auto_reload' => true,
          ],
        ],
        'db' => [
          'driver'       => 'oracle',
          'host'         => '192.168.1.11',
          'port'         => '1521',
          'database'     => 'scss',
          'service_name' => 'orcl',
          'username'     => 'estacionamento',
          'password'     => 'otnemanoicatse',
          'schema'       => 'estacionamento',
          'charset'      => 'AL32UTF8',
          'prefix'       => '',
        ],
        'tracy' => [
          'showPhpInfoPanel' => 0,
          'showSlimRouterPanel' => 0,
          'showSlimEnvironmentPanel' => 0,
          'showSlimRequestPanel' => 1,
          'showSlimResponsePanel' => 1,
          'showSlimContainer' => 0,
          'showEloquentORMPanel' => 0,
          'showTwigPanel' => 0,
          'showIdiormPanel' => 0,// > 0 mean you enable logging          
          'showProfilerPanel' => 0,
          'showVendorVersionsPanel' => 0,
          'showXDebugHelper' => 0,
          'showIncludedFiles' => 0,
          'showConsolePanel' => 0,          
          'configs' => [
              // XDebugger IDE key
              'XDebugHelperIDEKey' => 'PHPSTORM',
              // Disable login (don't ask for credentials, be careful) values( 1 || 0 )
              'ConsoleNoLogin' => 0,
              // Multi-user credentials values( ['user1' => 'password1', 'user2' => 'password2'] )
              'ConsoleAccounts' => [
                  'dev' => '34c6fceca75e456f25e7e99531e2425c6c1de443'// = sha1('dev')
              ],
              // Password hash algorithm (password must be hashed) values('md5', 'sha256' ...)
              'ConsoleHashAlgorithm' => 'sha1',
              // Home directory (multi-user mode supported) values ( var || array )
              // '' || '/tmp' || ['user1' => '/home/user1', 'user2' => '/home/user2']
              'ConsoleHomeDirectory' => __DIR__,
              // terminal.js full URI
              'ConsoleTerminalJs' => '/assets/js/jquery.terminal.min.js',
              // terminal.css full URI
              'ConsoleTerminalCss' => '/assets/css/jquery.terminal.min.css',
              'ProfilerPanel' => [
                  // Memory usage 'primaryValue' set as Profiler::enable() or Profiler::enable(1)
//                    'primaryValue' =>                   'effective',    // or 'absolute'
                  'show' => [
                      'memoryUsageChart' => 1, // or false
                      'shortProfiles' => true, // or false
                      'timeLines' => true // or false
                  ]
              ]
          ]
      ]
    ]
];
