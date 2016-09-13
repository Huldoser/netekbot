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

        case '012'.' '.'מובייל':
        case '012':
          $serviceProvider = '012 מובייל';

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
          $fieldName = 'איזה מספר תרצה לנתק';
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

      return $fieldName.'?';
    }

    public function getFieldHebrewTranslation($fieldName) {
      switch ($fieldName) {
        case 'first_name':
          $fieldName = 'שם פרטי';
          break;

        case 'last_name':
          $fieldName = 'שם משפחה';
          break;

        case 'id_number':
          $fieldName = 'מספר זהות';
          break;

        case 'email_address':
          $fieldName = 'כתובת דואר אלקטרוני';
          break;

        case 'phone_number':
          $fieldName = 'מספר הטלפון לניתוק';
          break;

        case 'settlement':
          $fieldName = 'ישוב מגורים';
          break;

        case 'address':
          $fieldName = 'כתובת מגורים';
          break;

        case 'last_digits':
          $fieldName = 'ארבעה ספרות אחרונות';
          break;
      }

      return $fieldName.': ';
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

    public function generatedTemplate($uid) {

      $template;



      return $template;
    }


    public function sendMail($uid) {
      $sendgrid = new SendGrid($_ENV['SENDGRID_USERNAME'], $_ENV['SENDGRID_PASSWORD']);

      // the backslash mean the function will be called from the global namespace
      $email = new SendGrid\Email();
      $email->addTo('huldoser@gmail.com')
        ->setFrom('me@bar.com')
        ->setSubject('נתקבוט - בקשת ניתוק מספק שירות')
        ->setText('Hello World!')
        ->setHtml('<strong>Hello World!</strong>');

        $sendgrid->send($email);
    }

  }

?>
