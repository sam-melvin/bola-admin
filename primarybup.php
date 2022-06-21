<?php
include '../dbConfig.php';

class Winners {

    public $database;

    public function __construct()
    {
        global $conn;
        
        $this->database = $conn;
    }
    public $allbets = array();
    

    public function getAllBets($drawNum,$category)
    {
        

        $betNumbers = [];
        $straightList = [];
        $historyLogs = $this->queryThreeDigits($drawNum,$category);
        $getTotalPersEarn = $this->queryTotalPersonalEarnings($drawNum);
        $getTotalResEarn = $this->queryTotalResidualEarnings($drawNum);
        $getTotalRumble = $this->queryTotalBetRumble($drawNum);
        $temp_digit = '';
        foreach ($historyLogs as $key =>$logs) {
            // $betNumbers[] = $logs['digit'];
        if($logs['category'] == '3ds'){
            

            $hasRumble = $this->getrumble($logs['digit'],$drawNum);
            $lastTwo = $this->getLastTwo($logs['digit'],$drawNum);
            $lastOne = $this->getLastOne($logs['digit'],$drawNum);
            
            // echo 'digit: '.$logs['digit'].'-';
            // echo 'rumble: '.$hasRumble.'<br />';
            $betNumbers[] = [
                'bet_id' => $logs['id'],
                'user_id' => $logs['user_id'],
                'draw_id' => $logs['draw_id'],
                'category' => $logs['category'],
                'location' => $logs['location'],
                'digit' => $logs['digit'],
                'amount' => $logs['amount'],
                'total_ramble' => $hasRumble,
                'total_ramble_bet' => $getTotalRumble,
                'total_twoD' => $lastTwo,
                'total_oneD' => $lastOne,
                'total_person_earning' => $getTotalPersEarn,
                'total_residual_earning' => $getTotalResEarn,

    
            ];
        }
            

            // if($logs['category'] == '3ds'){
            //     $temp_digit  = $logs['digit'];
            //     $straightList[] = [
            //         'bet_id' => $logs['id'],
            //         'user_id' => $logs['user_id'],
            //         'draw_id' => $logs['draw_id'],
            //         'category' => $logs['category'],
            //         'location' => $logs['location'],
            //         'digit' => $logs['digit'],
            //         'amount' => $logs['amount']
            //     ]
            // }

            //     $betnum = $this->getbets($betNumbers);
            // if (!empty($betnum) ) {
            //     // $betnum[$key]  = $hasBet;
                

            //     // foreach ($hasBet as $key => $val) {
            //     //     unset($betNumbers[$val]);
            //     // }
            // }
            // else {
            //     echo "wew";
            
            
        }
        return $betNumbers;
    }

    private function getbets($betNumbers)
    {
        $betnum = [];
       
        if (empty($betNumbers)) {
            return false;
        }

        $betNums = [];
        
        foreach($betNumbers as $val){
            
                $betNums[] = $val;
            
        }
        return $betNums;
    }

   private function getrumble($winningNumbers,$drawNum)
    {
        $historyLogs = $this->queryThreeDigits($drawNum,'3dr');
        // echo 'count: '. count($historyLogs).'<br />';
        $rumble = array();
        $total_win = 0;
        if (empty($historyLogs)) {
            return false;
        }
        $rumble = array();

        $winningEntryKey = 0;
        $singlized       = [];
        
        $singlizedW[0] = substr($winningNumbers, 0, 1);
        $singlizedW[1] = substr($winningNumbers, 1, 1);
        $singlizedW[2] = substr($winningNumbers, 2, 2);
        
        
        foreach ($historyLogs as $key => $rumble) {
            $bn = $rumble['digit'];

            $singlizedB[0] = $bn[0];
            $singlizedB[1] = $bn[1];
            $singlizedB[2] = $bn[2];

            for($i=0;$i<=2;++$i) {
                if (in_array( $singlizedW[$i], $singlizedB )) {
                    $ark = array_search($singlizedW[$i], $singlizedB);
                    unset($singlizedB[$ark]);
                }
            }

            if (count($singlizedB) === 0 && $winningNumbers != $bn) {
                $winningEntryKey = 1;
                $total_win += $rumble['amount'];
            }
        }

        $rumble['total_win'] = $total_win;
        // echo 'total_win : ' . $rumble['total_win'] . '<br />';
        return ($total_win > 0) ? $total_win : 0;
       
    }

    private function getLastTwo($winningNumbers, $drawNum)
    {
        $twoDLogs = $this->queryThreeDigits($drawNum,'2d');
        $total_lastTwo = 0;
        $substr = substr($winningNumbers,1,2);
        $winningEntryKey = 0;
        
        foreach($twoDLogs as $key => $twd) {

            if($substr == $twd['digit']) {
                $winningEntryKey = 1;
                $total_lastTwo += $twd['amount'];
            }
        }

        return $total_lastTwo;
    }

    private function getLastOne($winningNumbers, $drawNum)
    {
        $oneDLogs = $this->queryThreeDigits($drawNum,'1d');
        $total_lastOne = 0;
        $substr = substr($winningNumbers,-1);
        $winningEntryKey = 0;
        
        foreach($oneDLogs as $key => $one) {
            
            if($substr == $one['digit']) {
                $winningEntryKey= 1;
                $total_lastOne += $one['amount'];
            }
        }

        return $total_lastOne;
    }

    public function getTenPercent($allcomb)
    {
        $getbet = [];
        foreach($allcomb as $key => $valu){
            $getbet[$key] = $valu->betnumber;
        }
        // $hasdupes = $this->has_dupes($allcomb);
        // echo $hasdupes;
        // foreach($hasdupes as $dupes) {
            
        // }
       

        return $getbet;
    }

    // function has_dupes($allcomb) {
        
    //     echo 'count: '.count($allcomb);
    //     $dupes = [];
    //     $noDupes = [];
    //     $sumstr = 0;
    //     foreach($allcomb as $key => $valu) {
    //         $j = $x;
    //         // echo $valu['category'];
    //         $tempdigit =$valu['digit'];
    //         $tempamt =$valu['amount'];
    //         $tempid = $valu['bet_id'];
    //         foreach($allcomb as $key => $subvalu) {
                
               
    //                 if($tempdigit == $subvalu['digit']){
    //                     echo 'Digit: '. $subvalu['digit'];
    //                     echo 'ID: '.$subvalu['bet_id'] . '<br/>';
    //                         $bets = $subvalu['digit'];
    //                     if(!isset($dupes[$tempdigit])){
    //                         $dupes[$tempdigit] = [
    //                             'total_amount' => $tempamt
    //                         ];

    //                     }else {
    //                          $subsum = (float)$tempamt + (float)$subvalu['amount'];
    //                         $sumstr += (float)$subsum;
    //                         $dupes[$bets] =  [
    //                             'total_amount' => $sumstr
    //                         ];
    //                     }

    //                     $subsum = $tempstr + $subvalu['amount'];
    //                     $sumstr += $subsum;
    //                     // $allcomb[$k]->betnumber = '';
                        
    //                     unset($allcomb[$k]);
    //                     array_splice($allcomb, $k, 1);
    //                     echo 'count: '.count($allcomb).'<br />';
                        
    //                     $allcomb[$j]->betnumber = 0;
    //                 }
    //                 else {
    //                     $noDupes[$temp] = [
    //                         'sumstr' => $tempstr
    //                     ];
    //                 }

                    
           
    //         }

    //     }
    //     // $ctr = count($allcomb);
    //     // $dupes = [];
    //     // foreach ($allcomb as $key => $val){
    //     //     echo $key;
    //     //     $j = $key;
    //     //     $temp = $val->betnumber;
    //     //     for($k=0;$k < $ctr;$k++){

    //     //         if($j != $k) {
    //     //             if($temp == $val->betnumber){
    //     //                 $dupes[] = $val->betnumber;
    //     //             }
    //     //         }
    //     //     }

    //     // }

    //     return $dupes;
    // }


    function haveDupes($bets,$nobets) {
        $sumstr = 0;
        $dupe_array = array();
        $dupesdata = [];
        $nobetsdata = [];
        foreach ($nobets as $digit) {
            foreach ($bets as $key => $val) {

                if($digit == $val['digit']){
                    if(isset($nobetsdata[$digit])){
                        unset($nobetsdata[$digit]);
                    }
                } 
                else {
                    $nobetsdata[$digit] = $digit;
                }
                $tempDigit = $val['digit']; 
                $tempamt =  $val['amount']; 
                $rumble =  $val['total_ramble'];
                $amount_prize = number_format((float)$val['amount'] * 500, 2, '.', '');
                $total_ramble = number_format((float)$val['total_ramble'] * 80, 2, '.', '');
                $total_twoD = number_format((float)$val['total_twoD'] * 50, 2, '.', '');
                $total_oneD = number_format((float)$val['total_oneD'] * 5, 2, '.', '');
                $total_amount = number_format($val['amount'],2);
                $total_ramble_bet = number_format($val['total_ramble'],2);
                $total_twoD_bet = number_format((float)$val['total_twoD'],2);
                $total_oneD_bet = number_format((float)$val['total_oneD'],2);
                $total_person_earning = number_format($val['total_person_earning'],2); 
                $total_residual_earning = number_format($val['total_residual_earning'],2);
                if(!isset($dupesdata['d'.$val['digit']])) {
                    
                    $dupesdata['d'.$val['digit']] = [
                                'digit' => $tempDigit,
                                'total_amount' => $total_amount,
                                'total_payout' => $amount_prize ,
                                'total_ramble' => $total_ramble,
                                'total_ramble_bet' => $total_ramble_bet,
                                'total_twoD' => $total_twoD,
                                'total_twoD_bet' => $total_twoD_bet,
                                'total_oneD' => $total_oneD,
                                'total_oneD_bet' => $total_oneD_bet,
                                'total_person_earning' => $total_person_earning,
                                'total_residual_earning' => $total_residual_earning,
                                'nobets' => $nobetsdata
                            ];
                }
                
                if (++$dupe_array[$val['digit']] > 1) {
                        $dupesdata['d'.$val['digit']]['total_amount'] += $tempamt;
                        $dupesdata['d'.$val['digit']]['total_payout'] += $amount_prize;
                      
                    
                }
            }
        }
        

        return $dupesdata;
       
    }
    
    public function allCombinations($drawNum)
    {
        // $historyLogs = $this->queryWinners($drawNum);
        $allbets = [];
        $queryBets = $this->queryThreeDigits($drawNum,'1d');
        for($x=0;$x < 1000; $x++){
            $cnt= strlen($x);
            if($cnt == 1)
                $x = '00' . $x;
            else if($cnt == 2)
                $x = '0'.$x;

            // echo $x."<br />";
            $allbets[] = $x;
        }

        return $allbets;
        
    }
    

   
    
   
    private function queryThreeDigits($drawNum,$category)
    {
        $sql = "SELECT * FROM `bets` WHERE `draw_id` = '$drawNum' AND `status` = 'pending' AND `category` = '$category' ";

        // $sql = "SELECT id, agent_code, bet_numbers, digit_2, digit_1 
        //         FROM digital_tally 
        //         WHERE winning_number={$wid}";

        $historyLogs = [];

        if ($result = mysqli_query($this->database, $sql)) {

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    $historyLogs[] = $row;
                }

                mysqli_free_result($result);

            } else {
                
            }
        }

        return $historyLogs;
    }

    private function queryTotalBetRumble($drawNum)
    {
        $sql = "SELECT * FROM `bets` WHERE `draw_id` = '$drawNum' AND `status` = 'pending' AND `category` = '3dr' ";

        // $sql = "SELECT id, agent_code, bet_numbers, digit_2, digit_1 
        //         FROM digital_tally 
        //         WHERE winning_number={$wid}";


        $total_amount = 0;
        if($result=mysqli_query($this->database, $sql)) {
            if(mysqli_num_rows($result) > 0){
                
                while($row = mysqli_fetch_array($result)){
                    
                    $amount = $row['amount'];
                        //  echo "<option value='$ids'>$province</option>";

                    $total_amount += (float)$amount;
                } 
                mysqli_free_result($result);
            }else{
                
            }
        } 
       
        return $total_amount;
    }

    private function queryTotalPersonalEarnings($drawNum)
    {
        $sql = "SELECT `id`,`amount` FROM `user_earnings` WHERE `isReported` = '0' AND `type` =  'Personal' AND `draw_id`='$drawNum' ";

        // $sql = "SELECT id, agent_code, bet_numbers, digit_2, digit_1 
        //         FROM digital_tally 
        //         WHERE winning_number={$wid}";


        $total_amount = 0;
        if($result=mysqli_query($this->database, $sql)) {
            if(mysqli_num_rows($result) > 0){
                
                while($row = mysqli_fetch_array($result)){
                    
                    $amount = $row['amount'];
                        //  echo "<option value='$ids'>$province</option>";

                    $total_amount += (float)$amount;
                } 
                mysqli_free_result($result);
            }else{
                
            }
        } 
       
        return $total_amount;
    }
    

    private function queryTotalResidualEarnings($drawNum)
    {
        $sql = "SELECT `id`,`amount` FROM `user_earnings` WHERE `isReported` = '0' AND `type` =  'Residual' AND `draw_id`='$drawNum' ";

        // $sql = "SELECT id, agent_code, bet_numbers, digit_2, digit_1 
        //         FROM digital_tally 
        //         WHERE winning_number={$wid}";


        $total_amount = 0;
        if($result=mysqli_query($this->database, $sql)) {
            if(mysqli_num_rows($result) > 0){
                
                while($row = mysqli_fetch_array($result)){
                    
                    $amount = $row['amount'];
                        //  echo "<option value='$ids'>$province</option>";

                    $total_amount += (float)$amount;
                } 
                mysqli_free_result($result);
            }else{
                
            }
        } 
       
        return $total_amount;
    }
}

$winners = new Winners();

$drawNumber = 123;
$wid = 2;
$drawNum = 8;   
$category = '3ds';
// $wid = $_POST['wid'];
// $drawNum = $_POST['drawNum'];
// $drawdate = $_POST['drawdate'];
// $drawdate = date("m-d-Y", strtotime($drawdate));  
// $allbets = $winners->getTenPercent($wid,$drawNum);echo json_encode($artists)
$allcomb = $winners->getAllBets($drawNum,$category);
$nobets = $winners->allCombinations($drawNum);
// $dups = $winners->has_dupes($allcomb);
$dups = $winners->haveDupes($allcomb,$nobets);

// $allbet = $winners->getTenPercent($allcomb);
// $allbet = $winners->allCombinations();
// echo "<pre>";
// print_r($allcomb);
echo json_encode($dups);
// echo '<br>';
// echo '<br>';
// echo json_encode($allcomb);
// $exportData = json_encode($allcomb);
// print_r($exportData);
// print_r($results);

// print_r("count" . count($results));
// echo "<br/>";
// foreach($results as $key=>$value) {
//     echo $key ."<br />";
//     foreach($value as $keys=>$typeval) {
//         echo "&nbsp;&nbsp;type: ".$keys ."<br />";
//         foreach($typeval as $data) {
//             echo "&nbsp;&nbsp;&nbsp;&nbsp;tally-id: ".$data['id'] ."<br />";
//             echo "&nbsp;&nbsp;&nbsp;&nbsp;data-item: <br />";
//             foreach($data['item_keys'] as $ctr) {
//                 echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bet-index: ".$ctr."<br />";
//             }
//             echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;data-item-: ".$data['item_keys'][0] ."<br />";
//         }
//     }
//     // echo "next: ". reLoop($value)."<br />";
//     // // do stuff
// }

// function reLoop($arr) {
    
// }
// foreach($results as $result) {
//     echo $result, '<br>';
//     echo implode_key(",",$result, "BSPH01-03");
// }
// print_r($results[0].BSPH01-03);

