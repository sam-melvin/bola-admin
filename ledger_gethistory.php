<?php
// force redirect!
if (!isset($_POST['token'])) {
    header('Location: /');
    exit;
}

use App\Models\User;
use App\Models\LedgerTransaction;
//use App\Models\Ledger;


require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

/**
 * get logged user and validate form token
 */
$loggedUser = User::find($_SESSION[SESSION_UID]);

if (!verifyToken($_POST['token'], $loggedUser, ['ledger_id' => $_POST['id']])) {
    header('Location: /');
}

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

$results = LedgerTransaction::where('ledger_id', $_POST['id'])
    ->orderByDesc('id')
    ->get();

$renderedHtml = '';
foreach ($results as $the) {
    $maker = User::find($the->maker);

    switch ($the->status) {
        case LedgerTransaction::STATUS_PARTIAL:
            $class = 'bg-warning';
            break;
        case LedgerTransaction::STATUS_FULLY_PAID:
            $class = 'bg-success';
            break;
    }

    $renderedHtml .= '<tr>';
    $renderedHtml .= '<td>&#8369;' . number_format($the->amount,2) . '</td>';
    $renderedHtml .= '<td>' . $maker->full_name . '</td>';
    $renderedHtml .= '<td><span class="badge '. $class .'">' . ucfirst($the->status) . '</span></td>';
    $renderedHtml .= '<td>&#8369;' . number_format($the->balance,2) . '</td>';
    $renderedHtml .= '<td>' . $the->created->format('F j, Y, g:i:s a') . '</td>';
    $renderedHtml .= '<td>' . $the->remarks . '</td>';
    $renderedHtml .= '</tr>';
}

if (empty($renderedHtml)) {
    $renderedHtml = '<tr><td colspan="6">No records yet</td></tr>';
}

echo json_encode([
    'status' => 'SUCCESS',
    'data' => $renderedHtml
]);