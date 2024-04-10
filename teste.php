
<?php
use App\models\Passwords\Argon2idPasswordManager;

require_once __DIR__ . "/vendor/autoload.php";

$senha = new Argon2idPasswordManager("Password196!");
echo $senha->getValue();