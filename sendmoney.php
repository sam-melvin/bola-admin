<?php
// force redirect!
if (!isset($_POST['receiver'])) {
    header('Location: /');
    exit;
}

use App\Models\User;
use App\Models\Journal;
use App\Models\Balance;
use App\Models\Ledger;

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

$receiver = User::where('id', sanitize($_POST['receiver']))
    ->Where('type', $validUserType)
    ->first();

/**
 * if not valid user redirect to homepage
 *
 * TODO: // add logging
 */
if (empty($receiver)) {
    $_SESSION['error'] = 'Unable to find user';
    header('Location: wallet.php');
    exit;
}

$amount = (float)$_POST['amount'];
$balance = (float)$_POST['balance'];

/**
 * Validate the request if the sender can cater the said request in terms of
 * available balance
 */
if (empty($amount)) {
    // Zero validation
    $_SESSION['error'] = 'Invalid transaction amount is zero. You cannot sent zero amount.';
    header('Location: wallet.php');
    exit;
}

if ($amount > $balance) {
    // Insufficient balance
    $_SESSION['error'] = 'Insufficient balance';
    header('Location: wallet.php');
    exit;
}

$remarks = empty($_POST['remarks']) ? null : sanitize($_POST['remarks']);

/**
 * Sending money required 2 transaction on journals table
 *  1. record that reflect that sender got deducted
 *  2. record that reflect sender send money to receiver
 *
 * In both cases an entry to balances table should be created accordingly
 *
 */
$senderJournal = [
    'performed_by' => $loggedUser->id,
    'user_id' => $loggedUser->id,
    'entry_type' => Journal::ENTRY_TYPE_DEBIT,
    'amount' => $amount,
    'item_type' => Journal::ITEM_TYPE_VIRTUAL,
    'status' => Journal::STATUS_COMPLETE,
    'remarks' => $remarks
];
/**
 * save the journal records
 */
if (($journal = Journal::create($senderJournal))) {
    /**
     * insert to balances table
     */
    (new Balance())->updateBalance($journal);
}

$receiverJournal = [
    'performed_by' => $loggedUser->id,
    'user_id' => $receiver->id,
    'entry_type' => Journal::ENTRY_TYPE_CREDIT,
    'amount' => $amount,
    'item_type' => Journal::ITEM_TYPE_VIRTUAL,
    'status' => Journal::STATUS_COMPLETE,
    'remarks' => $remarks
];
/**
 * save the journal records
 */
if (($journal = Journal::create($receiverJournal))) {
    /**
     * insert to balances table
     */
    (new Balance())->updateBalance($journal);

    /**
     * add records to ledger
     */
    Ledger::create([
        'journal_id' => $journal->id,
        'user_id' => $loggedUser->id,
        'recipient' => $receiver->id,
        'amount' => $journal->amount,
        'status' => Ledger::STATUS_NEW
    ]);
}


echo 'success';
header('Location: wallet.php'); // force redirect for now this can be remove when script is called from ajax
