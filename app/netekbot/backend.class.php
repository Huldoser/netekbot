<?php

  class backend {

    public function matchProvider($serviceprovider) {

      switch ($serviceprovider[1]) {
        case 'פלאפון':
        case 'pelephone':
        case 'פלא-פון':
          $serviceprovider[0] = 'pelephone';
          $serviceprovider[1] = 'פלאפון';
          break;

        case 'סלקום':
          $serviceprovider[0] = 'cellcom';
          $serviceprovider[1] = 'סלקום';
          break;

        case 'פרטנר':
        case 'partner':
        case 'אורנג':
          $serviceprovider[0] = 'partner';
          $serviceprovider[1] = 'פרטנר';
          break;

        case 'רמי לוי':
        case 'rami levi':
          $serviceprovider[0] = 'rami_levi';
          $serviceprovider[1] = 'רמי לוי';
          break;

        case 'גולן טלאקום':
        case 'גולן טלקום':
        case 'גולן':
          $serviceprovider[0] = 'golan_telecom';
          $serviceprovider[1] = 'גולן טלקום';
          break;

        case 'hot mobile':
        case 'הוט מובייל':
          $serviceprovider[0] = 'hot_mobile';
          $serviceprovider[1] = 'הוט מובייל';
          break;

        default:
          $serviceprovider[0] = 'not_found';
          $serviceprovider[1] = 'not_found';
      }

      return $serviceprovider;
    }

  }

?>
