<?php
// force redirect!
if (!isset($_POST['id'])) {
    header('Location: /');
    exit;
}

use App\Models\User;
use App\Models\Ledger;
use App\Models\LedgerTransaction;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

/**
 * get logged user and validate form token
 */
$loggedUser = User::find($_SESSION[SESSION_UID]);

/**
 * validate the receiver must be of valid user type
 */
switch ($loggedUser->type) {
    case USER_TYPE_MANAGER:
        $validUserType = USER_TYPE_SUPERVISOR;
        break;
    case USER_TYPE_SUPERVISOR:
        $validUserType = USER_TYPE_AGENT;
        break;
    default:
        $validUserType = null;
        break;
}

if (empty($validUserType)) {
    // Invalid user type redirect to homepage
    $_SESSION['error'] = 'Not allowed. Invalid user type.';
    header('Location: wallet.php');
    exit;
}

$ledger = Ledger::find($_POST['id']);

if (isset($_POST['infull'])) {
    $transactionStatus = LedgerTransaction::STATUS_FULLY_PAID;
    $amount = $ledger->amount;
    $balance = 0;
    $ledgerStatus = Ledger::STATUS_FULLY_PAID;
} else {
    $amount = $_POST['amount'];
    $balance = $ledger->amount - $amount;

    /**
     * check if balance is zero meaning the maker already paid in full otherwise
     * mark it as partial
     */
    if (0 == $balance) {
        $transactionStatus = LedgerTransaction::STATUS_FULLY_PAID;
        $ledgerStatus = Ledger::STATUS_FULLY_PAID;
    } else {
        $transactionStatus = LedgerTransaction::STATUS_PARTIAL;
        $ledgerStatus = Ledger::STATUS_PARTIAL;
    }
}

$data = [
    'ledger_id' => $ledger->id,
    'amount' => $amount,
    'maker' => $ledger->recipient,
    'status' => $transactionStatus,
    'type' => LedgerTransaction::TYPE_CREDIT,
    'balance' => $balance
];

if (!empty($_POST['remarks'])) {
    $data['remarks'] = sanitize($_POST['remarks']);
}

/**
 * save the ledger transaction records and
 * update the ledgers records
 *  - amount
 *  - status
 * TODO: // add logging
 */
if (LedgerTransaction::create($data)) {
    $ledger->amount = $balance;
    $ledger->status = $ledgerStatus;
    $ledger->save();
}


echo 'success';
header('Location: ledger.php'); // force redirect for now this can be remove when script is called from ajax
