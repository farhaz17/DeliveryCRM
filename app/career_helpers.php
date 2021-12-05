<?php

use App\Model\Seeder\Followup_statuses;

function get_career_document_names(){
    return [1 => 'Passport Pic',
        2 => 'Photo',
        3 => 'Canceled visa Page',
        4 => 'Cancellation Paper',
        5 => 'Emirates ID',
        6 => 'Driving License',
        7 => 'PAK CNIC Card'
    ];
}

function get_checkout_type_names()
{
    return [
        1 => 'Shuffle Platform',
        2 => 'Vacation',
        3 => 'Terminate By Platform',
        4 => 'Terminate By Company',
        5 => 'Accident',
        6 => 'Absconded',
        7 => 'Demised',
        8 => 'Cancellation',
        9 => '4PL offboard',
        10 => 'Sick',
        11 => 'Emergency Leave'

    ];
}

function follow_up_names()
{
    return [
        1 => 'Interested',
        2 => 'Call Me Later',
        3 => 'No Response',
        4 => 'Not Interested',
    ];
}
function  follow_up_name($id)
{
    return follow_up_names()[$id];
}

function get_followup_statuses_name($id){
    return Followup_statuses::find($id)->name;
}

function interview_statuses_names(){
    return [
        0 => "Pendding",
        1 => "Passed",
        2 => "Failed"
    ];
}

function get_interview_statuses_name($id){
    return interview_statuses_names()[$id];
}

function all_promotion_type_names(){
    return [
            1 => 'Tiktok',
            2 => 'Facebook',
            3 => 'Youtube',
            4 => 'Website',
            5 => 'Instagram',
            6 => 'Friend',
            7 => 'Other',
            8 => 'Radio' ,
            9 => 'Restaurant'
        ];
    }
function get_promotion_type_name($id)
    {
        return all_promotion_type_names()[$id];
    }

function get_rejoin_history_name_array(){
    return [
        1 => 'Sent to Wait list',
        2 => 'Sent to Selected',
        4 => 'Sent to Rejected',
        5 => 'Interview Sent',
        6 => 'Interview Id',
        7 => 'Interview Passed',
        8 => 'Interview Failed',
        9 => 'Interview Absent',
        10 => 'Sent to Onboard' ,
    ];
}

function get_the_rejion_name($id){

    return get_rejoin_history_name_array()[$id];
}

?>
