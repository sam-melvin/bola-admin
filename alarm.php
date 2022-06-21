<?php
date_default_timezone_set('Asia/Manila');
$date = date('m/d/Y');
$serverTime = date('m/d/Y h:i:s a', time());

$userType = $_SESSION['utype'];
$userTypeAlarms = [
    'supervisor' => [
        'first'  => '10:44:59 am',
        'second' => '04:44:59 pm',
        'third'  => '08:44:59 pm',
    ],
    'manager' => [
        'first'  => '10:59:59 am',
        'second' => '04:59:59 pm',
        'third'  => '08:59:59 pm',
    ]
];
?>

<script>
    var currentTime = new Date('<?php echo $serverTime; ?>');
    var alarm = {
        first:  new Date('<?php echo $date; ?> <?php echo $userTypeAlarms[$userType]['first']; ?>'),
        second: new Date('<?php echo $date; ?> <?php echo $userTypeAlarms[$userType]['second']; ?>'),
        third:  new Date('<?php echo $date; ?> <?php echo $userTypeAlarms[$userType]['third']; ?>')
    };
    var interval = {
        first:  Math.abs(currentTime - alarm.first),
        second: Math.abs(currentTime - alarm.second),
        third:  Math.abs(currentTime - alarm.third)
    };
    var timer = 0;

    if (alarm.first - currentTime > 0) {
        timer = interval.first;
    } else if (alarm.second - currentTime > 0) {
        timer = interval.second;
    } else {
        timer = interval.third;
    }

    setTimeout(function() {
        $('#modalReminder').modal('show');
    }, timer);
</script>

<div id="modalReminder" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">REMINDER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Please submit you tally sheets NOW.</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>