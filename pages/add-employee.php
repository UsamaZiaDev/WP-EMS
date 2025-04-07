    <?php

        $message = "";  
        $status = null;
        $action = "";
        $employee = [];

        global $wpdb;

        if(isset($_GET["action"]) && isset($_GET["empId"])){

            $emdId = $_GET["empId"];

            if( $_GET["action"]  == "view" ){
                $action = "view";
            }

            if( $_GET["action"]  == "edit" ){
                $action = "edit";
            }

            $employee = $wpdb->get_row(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}ems_form_data WHERE id = %d", $emdId
            ), ARRAY_A );
        }

        if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ems_submit"])){ 

                $name = sanitize_text_field( $_POST["ems_name"] );
                $email = sanitize_text_field( $_POST["ems_email"] );
                $phone = sanitize_text_field( $_POST["ems_phone"] );
                $gender = sanitize_text_field( $_POST["ems_gender"] );
                $designation =  sanitize_text_field( $_POST["ems_designation"] );

               $wpdb -> insert( "{$wpdb -> prefix}ems_form_data", array(
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone,
                    "gender" => $gender,
                    "designation" => $designation
               ) );

               $last_inserted_id = $wpdb -> insert_id;

               if($last_inserted_id > 0 ){
                    $message = "Employee saved successfully";
                    $status = 1 ;
               }else{
                    $message = "Faild to save an Employe.";
                    $status = 0 ;
               }
        }

    ?>


<div class="row mt-4">
    <div class="col-lg-8">
        <div class="border rounded">
            <h4 class="bg-dark text-light px-3 py-2 rounded">
                <?php 
                    if($action && $action == "view"){
                        echo "View Employee";
                    }elseif($action && $action == "edit"){
                        echo "Edit Employee";
                    }else{
                        echo "Add Employee";
                    }
                ?>
            </h4>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>?page=add-employee" class="form-wrapper p-3" method="post">
                <div class="mb-3">
                    <label for="emp-name" class="form-label"> Name </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="emp-name" 
                        name="ems_name"
                        value=" <?php echo $employee ? $employee["name"] : "" ?> "                    >
                </div>

                <div class="mb-3">
                    <label for="emp-email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="emp-email" 
                        name="ems_email"
                        value=" <?php echo $employee ? $employee["email"]:"" ?> "     
                    >
                </div>

                <div class="mb-3">
                    <label for="emp-phone" class="form-label">Phone</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="emp-phone" 
                        name="ems_phone"
                        value=" <?php echo $employee ? $employee["phone"]:"" ?> " 
                    >
                </div>

                <div class="mb-3">
                    <label for="emp-designation" class="form-label">Designation</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="emp-designation" 
                        name="ems_designation"
                        value=" <?php echo $employee ? $employee["designation"]:"" ?> " 
                    >
                </div>

                <select class="form-select mt-4" aria-label="Default select example" id="gender" name="ems_gender">
                <?php
                    echo ($action && $employee["gender"]) ? 
                            "<option selected> {$employee['gender']} </option>":
                            "<option selected> Selects Gender </option>";
                    ?>
                    <option value="male">Male</option>
                    <option value="female">Female</option>

                </select>

                <div class="mb-4 mt-4">
                    <input type="submit" class="btn btn-dark " id="ems-submit" name="ems_submit">
                </div>
                
                <?php  if( $message ){ ?>
                    <h5 class="fw-bold alert  <?php echo ($status == true ) ? "alert-success" : "alert-danger" ?> " >
                        <?php
                            if($message){
                                    echo $message;
                            }
                        ?>
                    </h5>
                <?php    } ?>


            </form>

        </div>
    </div>
</div>