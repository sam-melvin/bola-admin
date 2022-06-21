<?php
// force redirect!
// if (!isset($_POST['token'])) {
//     header('Location: /');
//     exit;
// }

use App\Models\User;
use App\Models\Draws;
use App\Models\Bets;
use App\Models\Winners;
use App\Models\UserEarnings;

require 'bootstrap.php';
$loggedUser = User::find($_SESSION[SESSION_UID]);
$ids = $_SESSION[SESSION_UID];


$selDate = $_POST['draw_date'];
$sampdate=date_create($selDate);
$sampdate=date_format($sampdate,'Y-m-d');

$userlocation = $loggedUser->assign_location;

$bets = new Bets();
$winners = new Winners();
$userearnings = new UserEarnings();

$results = Draws::where('draw_date', $sampdate)
    ->orderBy('draw_date','ASC')
    ->get();

$renderedHtml = '';
foreach ($results as $the) {
    $maker = User::find($the->maker);

    $datec=date_create($the['date_created']);
    $drawDate=date_create($the['draw_date']);
    $drawTime=date_create($the['draw_time']);
    $total_bettors = $bets->getTotalBettors($the,$userlocation);
    $total_winners = $winners->getTotalWinners($the['id'],$userlocation);
    $total_bets = $bets->getTotalBets($the,$userlocation);
    $total_payouts = $winners->getTotalPayout($the['id'],$userlocation);
    $sendDate = date_format($drawDate,'F j, Y');
    $sendTime = date_format($drawTime,'g:i a');
    $id = $the['id'];
    $drawid = $the['draw_number'];
    $digits = $the['digits'];
    $personearn = $userearnings->getTotalPersonEarnings($the,$userlocation);
    $residualearn = $userearnings->getTotalResidualEarnings($the,$userlocation);

    $renderedHtml .= '<tr>';
    $renderedHtml .= '<td >' . $the['draw_number'] . '</td>';
    $renderedHtml .= '<td class="text-warning">' . $the['digits'] . '</td>';
    $renderedHtml .= '<td>' . $total_bettors . '</td>';
    $renderedHtml .= '<td>' . $winners->getTotalWinners($the['id'],$userlocation) . '</td>';
    $renderedHtml .= '<td>&#8369;' . $bets->getTotalBets($the,$userlocation) . '</td>';
    $renderedHtml .= '<td>&#8369;' . $winners->getTotalPayout($the['id'],$userlocation) . '</td>';
    $renderedHtml .= '<td>' . date_format($drawDate,'F j, Y') . '</td>';
    $renderedHtml .= '<td>' .date_format($drawTime,'g:i a') . '</td>';
    $renderedHtml .= '<td><a href="invest-tally.php?id=' .$id. '&bettors=' .$total_bettors. '&winners=' .$total_winners.'&bets='.$total_bets.'&payouts='.$total_payouts.'&ddate='.$sendDate.'&dtime='.$sendTime.'&drawid='.$drawid.'&digit='.$digits.'&person='.$personearn.'&residual='.$residualearn.'" class="btn btn-primary ledgerModalDlg" data-token="$token" data-transactionid="" target="_blank">
    View</a></td>';
    $renderedHtml .= '</tr>';
}

if (empty($renderedHtml)) {
    $renderedHtml = '<tr><td colspan="6">No records yet</td></tr>';
}

echo json_encode([
    'status' => 'SUCCESS',
    'data' => $renderedHtml
]);

?>