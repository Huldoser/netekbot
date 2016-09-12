<?php

  class backend {
    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function matchProvider($serviceProvider) {
      switch ($serviceProvider) {
        case 'פלאפון':
        case 'pelephone':
        case 'פלא-פון':
          $serviceProvider = 'פלאפון';
          break;

        case 'סלקום':
        case ' cellcom':
          $serviceProvider = 'סלקום';
          break;

        case 'פרטנר':
        case 'partner':
        case 'אורנג':
          $serviceProvider = 'פרטנר';
          break;

        case 'רמי לוי':
        case 'rami levi':
          $serviceProvider = 'רמי לוי';
          break;

        case 'גולן טלאקום':
        case 'גולן טלקום':
        case 'גולן':
          $serviceProvider = 'גולן טלקום';
          break;

        case 'hot mobile':
        case 'הוט מובייל':
          $serviceProvider = 'הוט מובייל';
          break;

        default:
          $serviceProvider = 'not_found';
      }

      return $serviceProvider;
    }

    public function getHebrewTranslation($word) {
      switch ($word) {
        case 'first_name':
          $word = 'שם פרטי';
          break;

        case 'last_name':
          $word = 'שם משפחה';
          break;

        case 'email_address':
         $word = 'כתובת מייל';
         break;

        case 'phone_number':
          $word = 'מספר טלפון לניתוק';
          break;

        case 'settlement':
          $word = 'ישוב מגורים';
          break;

        case 'address':
          $word = 'כתובת מגורים';
          break;

        case 'last_digits':
          $word = '4 '.'ספרות אחרונות של אמצעי התשלום';
          break;
      }

        return $word;
    }

    public function getNextField($currentFieldName) {
      $fields = array('first_name', 'last_name', 'id_number', 'email_address', 'phone_number',
        'settlement', 'address', 'last_digits', 'done');

      if ($currentFiledName === 'last_digits') {
        return 'done';
      } else if ($currentFieldName === 'empty') {
        return $fields[0];
      } else {
        for ($i = 0; $i < sizeof($fields); $i++) {
          if ($currentFieldName === $fields[$i]) {
            return $fields[$i + 1];
          }
        }
      }
    }

  }

?>
