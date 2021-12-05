<?php


class Constants
{
    //DATABASE DETAILS
    static $DB_SERVER="localhost";
    static $DB_NAME="zone_repair";
    static $USERNAME="root";
    static $PASSWORD="";

    //STATEMENTS
    static $SQL_SELECT_ALL="SELECT * FROM tickets";
}

class Spirituality
{

    /*******************************************************************************************************************************************/
    /*
       1.CONNECT TO DATABASE.
       2. RETURN CONNECTION OBJECT
    */
    public function connect()
    {   
        $con=new mysqli(Constants::$DB_SERVER,Constants::$USERNAME,Constants::$PASSWORD,Constants::$DB_NAME);
        if($con->connect_error)
        {
           // echo "Unable To Connect";
            return null;
        }else
        {
            return $con;
        }
    }
    public function insert()
    {
        // INSERT
        $con=$this->connect();
        if($con != null)
        {

//            date_default_timezone_set('Asia/Dubai');// change according timezone
            $currentTime = date( 'Y-m-d h:i:s');


            $image_name = $_FILES['image']['name'];
            //Get voice name
            $voice_message=$_FILES['voice']['name'];
            // Get text
            $teacher_name = mysqli_real_escape_string($con, $_POST['teacher_name']);
            $ticket_id = rand(1520,9999).time();
            $zdscode = mysqli_real_escape_string($con, $_POST['zdscode']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $whatsapp = mysqli_real_escape_string($con, $_POST['whatsapp']);
            $contact = mysqli_real_escape_string($con, $_POST['contact']);
            $department_id = mysqli_real_escape_string($con, $_POST['department_id']);
            $platform = mysqli_real_escape_string($con, $_POST['platform']);
            $platform_id = mysqli_real_escape_string($con, $_POST['platform_id']);
            $message = mysqli_real_escape_string($con, $_POST['message']);


            // image file directory
            $voice_messagecode= base64_encode($voice_message.$currentTime);
            $image_namecode= base64_encode($image_name.$currentTime);
            $target_image = basename($image_namecode).'.jpg';
            $target_voice = basename($voice_messagecode).'.mp3';

            $sql = "INSERT INTO tickets (image_url, name,contact,voice_message,zdscode,email,whatsapp,department_id,created_at,ticket_id,platform,platform_id,message) VALUES ('$target_image', '$teacher_name', '$contact','$target_voice','$zdscode','$email','$whatsapp','$department_id','$currentTime','$ticket_id','$platform','$platform_id','$message')";




//mail($email, "Query Received", "Ticket Is Raised : ".$ticket_id, "FROM: Zone Delivery Services <webmaster@z-back.com>\r\nContent-type: text/html; charset=iso-8859-1\r\n");


            try
            {
                $result=$con->query($sql);
                if($result)
                {

                    move_uploaded_file($_FILES['image']['tmp_name'], "images/".$target_image);
                    move_uploaded_file($_FILES['voice']['tmp_name'], "voices/".$target_voice);
                    print(json_encode(array("message"=>"Success")));

                }else
                {
                    print(json_encode(array("message"=>"Unsuccessful. Connection was successful but data could not be Inserted.")));
                }
                $con->close();
            }catch (Exception $e)
            {
                print(json_encode(array("message"=>"ERROR PHP EXCEPTION : CAN'T SAVE TO MYSQL. ".$e->getMessage())));
                $con->close();
            }
        }else{
            print(json_encode(array("message"=>"ERROR PHP EXCEPTION : CAN'T CONNECT TO MYSQL. NULL CONNECTION.")));
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }
   

    
    public function handleRequest() {
        if (isset($_POST['name'])) {
            $this->insert();
        } 
    }


}
$spirituality=new Spirituality();
$spirituality->handleRequest();

?>