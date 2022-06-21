<?php
// force redirect!


use App\Models\User;
use App\Models\Wallet;
use App\Models\Transactions;


require 'bootstrap.php';

/**
 * get logged user and validate form token
 */
$user = new User();
$loggedUser = User::find($_SESSION[SESSION_UID]);

/**
 * validate the receiver must be of valid user type
 */

$receiver = Wallet::where('admin_id', sanitize($_POST['receiver']))
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
$cash_pool = (float)$_POST['cash_pool'];

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
$Transaction = [
    'user_id' => $receiver->admin_id,
    'amount' => $amount,
    'currency' =>'php',
    'payment_method' => 'system',
    'type' => 'Wallet',
    'tx_type' => '3',
    'status' => 'complete',
    'updated_by' => $loggedUser->id,
    'updated_date' => date('Y-m-d H:i:s'),
];

$walletParams = [
    'admin_id' => $receiver->admin_id,
    'cash_pool' => $cash_pool,
    'amount' => $amount
];
/**
 * save the journal records
 */
if(($trans = Transactions::create($Transaction))) {
    /**
     * insert to balances table
     */
    
    (new Wallet())->updateWallet($walletParams);

    $user->jsonEncodeSuccess($trans);
}
else {
    $user->jsonEncodeErrors('Send money failed');
}

// $receiverJournal = [
//     'performed_by' => $loggedUser->id,
//     'user_id' => $receiver->id,
//     'entry_type' => Journal::ENTRY_TYPE_CREDIT,
//     'amount' => $amount,
//     'item_type' => Journal::ITEM_TYPE_VIRTUAL,
//     'status' => Journal::STATUS_COMPLETE,
//     'remarks' => $remarks
// ];
// /**
//  * save the journal records
//  */
// if (($journal = Journal::create($receiverJournal))) {
//     /**
//      * insert to balances table
//      */
//     (new Balance())->updateBalance($journal);

//     /**
//      * add records to ledger
//      */
//     Ledger::create([
//         'journal_id' => $journal->id,
//         'user_id' => $loggedUser->id,
//         'recipient' => $receiver->id,
//         'amount' => $journal->amount,
//         'status' => Ledger::STATUS_NEW
//     ]);
// }


 // force redirect for now this can be remove when script is called from ajax
