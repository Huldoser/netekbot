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

    public function getQuestionByFieldName($fieldName) {
      switch ($fieldName) {
        case 'first_name':
          $fieldName = 'מה שמך הפרטי';
          break;

        case 'last_name':
          $fieldName = 'מה שם המשפחה שלך';
          break;

        case 'id_number':
          $fieldName = 'מה מספר תעודת הזהות שלך';
          break;

        case 'email_address':
          $fieldName = 'כדי שתקבל העתק של הבקשה שלך אני צריך גם את כתובת המייל שלך';
          break;

        case 'phone_number':
          $fieldName = 'מה המספר אותו תרצה לנתק';
          break;

        case 'settlement':
          $fieldName = 'באיזה ישוב אתה גר';
          break;

        case 'address':
          $fieldName = 'מה מספר הבית שלך ומספר הדירה';
          break;

        case 'last_digits':
          $fieldName = 'מה הם ארבעת הספרות האחרונות של אמצעי התשלום שבאמצעותו אתה משלם לספק';
          break;
      }

      default:
        $fieldName = 'done';

        return $fieldName.'?';
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
