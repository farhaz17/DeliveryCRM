<?php
// Get All sim replace reasons
function get_sim_replace_reasons(){
    return [1 => 'Stolen', 2 => 'Lost', 3 => 'Damage'];
}
// Get single sim replace reason
function get_sim_replace_reason($index){
    return get_sim_replace_reasons()[$index];
}

// Get All plate replacement reasons
function get_plate_replace_reasons(){
    return [1 => 'Stolen', 2 => 'Lost', 3 => 'Damage', 4 => 'Other'];
}
// Get single plate replacement reason
function get_plate_replace_reason($index){
    return get_plate_replace_reasons()[$index];
}

function get_uploaded_form(){
    return [1 => "Individual Uploaded", 2 => "Bulk Uploaded"];
}

function get_paid_bys(){
    return [1 => "Company", 2 => "Rider", 3 => "Staff"];
}
function get_paid_by($index){
    return get_paid_bys()[$index];
}

function dateToRead($date)
{
    return date('m-d-Y', strtotime($date));
}
function defaultPaginate($paginate_number = 10)
{
    return $paginate_number;
}

function get_department_contact_methods()
{
    return [1 => 'Telephone' ,2 => 'Mobile',3 => 'What\'s App',4 => 'Email',5 => 'Social Profile' ,6 => 'Web Site'];
}
function  get_department_contact_method($index)
{
    return get_department_contact_methods()[$index];
}

function get_department_names()
{
    return [1 => 'Accounts' ,2 => 'Operation',3 => 'HRM',4 => 'Sales & MKTG'];
}
function  get_department_name($index)
{
    return get_department_names()[$index];
}

function get_department_employee_designations()
{
    return [1 => 'Chief Executive Officer (CEO)' , 2 => 'Chief Operating Officer (COO)', 3 => 'Chief Financial Officer (CFO) or Controller', 4 => 'Chief Marketing Officer (CMO)', 5 =>'Chief Technology Officer (CTO)'];
}
function  get_department_contact_designation($index)
{
    return get_department_employee_designations()[$index];
}

function get_vehicles_status_names()
{
    return [0 => "<span class='badge badge-danger'>Not Working</span>", 1 => 'Running' , 2 => "<span class='badge badge-success'>Working</span>", 3 => "<span class='badge badge-warning'>Holding</span>"];
}
function  get_vehicles_status_name($index)
{
    return get_vehicles_status_names()[$index];
}
function get_defaulter_rider_level($id){
    $lavels = [
        1 => "<span class='text-success'>Low</span>",
        2 => "<span class='text-warning'>Medium</span>",
        3 => "<span class='text-danger'>High</span>",
    ];
    return $lavels[$id];
}
function temurl_image($image_url , $minutes = 5){
    return Storage::temporaryUrl($image_url, now()->addMinutes( $minutes ));
}

function get_follow_up_call_count_wise_color_class($total_calls){
    if($total_calls == 0) {
        return "info" ;
    }elseif($total_calls < 2){
        return "success text-white";
    }elseif($total_calls < 3){
        return "warning" ;
    }else{
        return "danger text-white" ;
    }
}

function get_platform_icon_url($platform_id){
    $platform_icon_urls = [
        1 => "assets/images/icons/drawable/careem.png",
        2 => "assets/images/icons/drawable/zomato.png",
        3 => "assets/images/icons/drawable/uber-eats.png",
        4 => "assets/images/icons/drawable/deliveroo.png",
        5 => "assets/images/icons/drawable/swan.png",
        6 => "assets/images/icons/drawable/bnk.png",
        7 => "assets/images/icons/drawable/somu_sushu.png",
        8 => "assets/images/icons/drawable/hey_karry.png",
        9 => "assets/images/icons/drawable/platform.png",
        10 => "assets/images/icons/drawable/platform.png",
        11 => "assets/images/icons/drawable/i-mile.png",
        12 => "assets/images/icons/drawable/spicy_klub.png",
        13 => "assets/images/icons/drawable/platform.png",
        14 => "assets/images/icons/drawable/platform.png",
        15 => "assets/images/icons/drawable/talabat.png",
        16 => "assets/images/icons/drawable/trot.png",
        17 => "assets/images/icons/drawable/chocomelt.png",
        18 => "assets/images/icons/drawable/platform.png",
        19 => "assets/images/icons/drawable/kabab_shop.png",
        20 => "assets/images/icons/drawable/platform.png",
        21 => "assets/images/icons/drawable/thai-wok.png",
        22 => "assets/images/icons/drawable/aster.png",
        23 => "assets/images/icons/drawable/med-care.png",
        24 => "assets/images/icons/drawable/med-care.png",
        25 => "assets/images/icons/drawable/insta.png",
    ];
    if(array_key_exists($platform_id, $platform_icon_urls)){
        return $platform_icon_urls[$platform_id];
    }else{
        return "assets/images/icons/drawable/platform.png";
    }
}
?>
