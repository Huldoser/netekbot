<?php

  class backend {
    private log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function matchProvider($serviceProvider) {

      switch ($serviceProvider) {
        case 'פלאפון':
        case 'pelephone':
        case 'פלא-פון':
          $serviceProvider = 'pelephone';
          break;

        case 'סלקום':
          $serviceProvider = 'cellcom';
          break;

        case 'פרטנר':
        case 'partner':
        case 'אורנג':
          $serviceProvider = 'partner';
          break;

        case 'רמי לוי':
        case 'rami levi':
          $serviceProvider = 'rami_levi';
          break;

        case 'גולן טלאקום':
        case 'גולן טלקום':
        case 'גולן':
          $serviceProvider = 'golan_telecom';
          break;

        case 'hot mobile':
        case 'הוט מובייל':
          $serviceProvider = 'hot_mobile';
          break;

        default:
          $serviceProvider = 'not_found';
      }

      return $serviceProvider;
    }

  }

?>
